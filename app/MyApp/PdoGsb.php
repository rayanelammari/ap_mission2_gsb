<?php
namespace App\MyApp;
use PDO;
use Illuminate\Support\Facades\Config;
class PdoGsb{
        private static $serveur;
        private static $bdd;
        private static $user;
        private static $mdp;
        private  $monPdo;
	
/**
 * crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */				
	public function __construct(){
        
        self::$serveur='mysql:host=' . Config::get('database.connections.mysql.host');
        self::$bdd='dbname=' . Config::get('database.connections.mysql.database');
        self::$user=Config::get('database.connections.mysql.username') ;
        self::$mdp=Config::get('database.connections.mysql.password');	  
        $this->monPdo = new PDO(self::$serveur.';'.self::$bdd, self::$user, self::$mdp); 
  		$this->monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		$this->monPdo =null;
	}
	

/**
 * Retourne les informations d'un visiteur
 
 * @param $login 
 * @param $mdp
 * @return l'id, le nom et le prénom sous la forme d'un tableau associatif 
*/
public function getInfosGestionnaire($login, $mdp) {
    $req = "SELECT gestionnaire.id as id, gestionnaire.nom as nom, gestionnaire.prenom as prenom FROM gestionnaire WHERE gestionnaire.login = :login AND gestionnaire.mdp = :mdp";
    
    $stmt = $this->monPdo->prepare($req);
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':mdp', $mdp);
    $stmt->execute();
    
    $ligne = $stmt->fetch();
    return $ligne;
}


public function getInfosVisiteur($login, $mdp,) {
    $req = "SELECT visiteur.id as id, visiteur.nom as nom, visiteur.prenom as prenom FROM visiteur WHERE visiteur.login = :login AND visiteur.mdp = :mdp";
    
    $stmt = $this->monPdo->prepare($req);
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':mdp', $mdp);
    $stmt->execute();
    
    $ligne = $stmt->fetch();
    return $ligne;



}

public function getInfosComptable($login, $mdp,) {
    $req = "SELECT comptable.id as id, comptable.nom as nom, comptable.prenom as prenom FROM comptable WHERE comptable.login = :login AND comptable.mdp = :mdp";
    
    $stmt = $this->monPdo->prepare($req);
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':mdp', $mdp);
    $stmt->execute();
    
    $ligne = $stmt->fetch();
    return $ligne;



}




/**
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais au forfait
 * concernées par les deux arguments
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return l'id, le libelle et la quantité sous la forme d'un tableau associatif 
*/
public function getLesFraisForfait($idVisiteur, $mois) {
    $req = "SELECT fraisforfait.id as idfrais, fraisforfait.libelle as libelle, 
            lignefraisforfait.quantite as quantite 
            FROM lignefraisforfait 
            INNER JOIN fraisforfait ON fraisforfait.id = lignefraisforfait.idfraisforfait
            WHERE lignefraisforfait.idvisiteur = :idVisiteur AND lignefraisforfait.mois = :mois
            ORDER BY lignefraisforfait.idfraisforfait";

    $stmt = $this->monPdo->prepare($req);
    $stmt->bindParam(':idVisiteur', $idVisiteur);
    $stmt->bindParam(':mois', $mois);
    $stmt->execute();

    $ligne = $stmt->fetchAll();
    return $ligne;
}

/**
 * Retourne tous les id de la table FraisForfait
 
 * @return un tableau associatif 
*/
	public function getLesIdFrais(){
		$req = "select fraisforfait.id as idfrais from fraisforfait order by fraisforfait.id";
		$res = $this->monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}
/**
 * Met à jour la table ligneFraisForfait
 
 * Met à jour la table ligneFraisForfait pour un visiteur et
 * un mois donné en enregistrant les nouveaux montants
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $lesFrais tableau associatif de clé idFrais et de valeur la quantité pour ce frais
 * @return un tableau associatif 
*/
	public function majFraisForfait($idVisiteur, $mois, $lesFrais){
		$lesCles = array_keys($lesFrais);

		foreach($lesCles as $unIdFrais){
			$qte = $lesFrais[$unIdFrais];
			$req = "update lignefraisforfait set lignefraisforfait.quantite = $qte
			where lignefraisforfait.idvisiteur = '$idVisiteur' and lignefraisforfait.mois = '$mois'
			and lignefraisforfait.idfraisforfait = '$unIdFrais'";
			$this->monPdo->exec($req);
		}
		
	}

/**
 * Teste si un visiteur possède une fiche de frais pour le mois passé en argument
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return vrai ou faux 
*/	
	public function estPremierFraisMois($idVisiteur,$mois)
	{
		$ok = false;
		$req = "select count(*) as nblignesfrais from fichefrais 
		where fichefrais.mois = '$mois' and fichefrais.idvisiteur = '$idVisiteur'";
		$res = $this->monPdo->query($req);
		$laLigne = $res->fetch();
		if($laLigne['nblignesfrais'] == 0){
			$ok = true;
		}
		return $ok;
	}
/**
 * Retourne le dernier mois en cours d'un visiteur
 
 * @param $idVisiteur 
 * @return le mois sous la forme aaaamm
*/	
	public function dernierMoisSaisi($idVisiteur){
		$req = "select max(mois) as dernierMois from fichefrais where fichefrais.idvisiteur = '$idVisiteur'";
		$res = $this->monPdo->query($req);
		$laLigne = $res->fetch();
		$dernierMois = $laLigne['dernierMois'];
		return $dernierMois;
	}
	
/**
 * Crée une nouvelle fiche de frais et les lignes de frais au forfait pour un visiteur et un mois donnés
 
 * récupère le dernier mois en cours de traitement, met à 'CL' son champs idEtat, crée une nouvelle fiche de frais
 * avec un idEtat à 'CR' et crée les lignes de frais forfait de quantités nulles 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
*/
	public function creeNouvellesLignesFrais($idVisiteur,$mois){
		$dernierMois = $this->dernierMoisSaisi($idVisiteur);
		$laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur,$dernierMois);
		if($laDerniereFiche['idEtat']=='CR'){
				$this->majEtatFicheFrais($idVisiteur, $dernierMois,'CL');
				
		}
		$req = "insert into fichefrais(idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat) 
		values('$idVisiteur','$mois',0,0,now(),'CR')";
		$this->monPdo->exec($req);
		$lesIdFrais = $this->getLesIdFrais();
		foreach($lesIdFrais as $uneLigneIdFrais){
			$unIdFrais = $uneLigneIdFrais['idfrais'];
			$req = "insert into lignefraisforfait(idvisiteur,mois,idFraisForfait,quantite) 
			values('$idVisiteur','$mois','$unIdFrais',0)";
			$this->monPdo->exec($req);
		 }
	}


/**
 * Retourne les mois pour lesquel un visiteur a une fiche de frais
 
 * @param $idVisiteur 
 * @return un tableau associatif de clé un mois -aaaamm- et de valeurs l'année et le mois correspondant 
*/
	public function getLesMoisDisponibles($idVisiteur){
		$req = "select fichefrais.mois as mois from  fichefrais where fichefrais.idvisiteur ='$idVisiteur' 
		order by fichefrais.mois desc ";
		$res = $this->monPdo->query($req);
		$lesMois =array();
		$laLigne = $res->fetch();
		while($laLigne != null)	{
			$mois = $laLigne['mois'];
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);
			$lesMois["$mois"]=array(
		     "mois"=>"$mois",
		    "numAnnee"  => "$numAnnee",
			"numMois"  => "$numMois"
             );
			$laLigne = $res->fetch(); 		
		}
		return $lesMois;
	}
/**
 * Retourne les informations d'une fiche de frais d'un visiteur pour un mois donné
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return un tableau avec des champs de jointure entre une fiche de frais et la ligne d'état 
*/	
	public function getLesInfosFicheFrais($idVisiteur,$mois){
		$req = "select fichefrais.idEtat as idEtat, fichefrais.dateModif as dateModif, fichefrais.nbJustificatifs as nbJustificatifs, 
			fichefrais.montantValide as montantValide, etat.libelle as libEtat from  fichefrais inner join etat on fichefrais.idEtat = etat.id 
			where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$res = $this->monPdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne;
	}

	public function getListeVisiteur()
{
    $req = "SELECT id, nom, prenom FROM visiteur";
    $res = $this->monPdo->prepare($req);
    $res->execute();
    $ligne = $res->fetchAll();

    return $ligne;
}


/**
 * Modifie l'état et la date de modification d'une fiche de frais
 
 * Modifie le champ idEtat et met la date de modif à aujourd'hui
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 */
/*function genererId() {
    return chr(rand(97, 122)) . rand(10, 99);
}*/

	public function majEtatFicheFrais($idVisiteur,$mois,$etat){
		$req = "update ficheFrais set idEtat = '$etat', dateModif = now() 
		where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$this->monPdo->exec($req);
	}
	public function getAjouterVisiteur($id,$nom, $prenom, $login, $mdp, $adresse, $cp, $ville, $dateEmbauche)
	{	
		if (empty($id)) {
			$id = chr(rand(97, 122)) . str_pad(rand(0, 99), 2, '0', STR_PAD_LEFT);
		}
	
		$req = "INSERT INTO visiteur (id,nom, prenom, login, mdp, adresse, cp, ville, dateEmbauche) VALUES (:idVisiteur,:nom, :prenom, :login, :mdp, :adresse, :cp, :ville, :dateEmbauche) 
		ON DUPLICATE KEY UPDATE id = :idVisiteur, nom = :nom, prenom = :prenom, login=:login, mdp = :mdp, adresse = :adresse, cp = :cp, ville = :ville, dateEmbauche = :dateEmbauche";
	
		$rs = $this->monPdo->prepare($req);
		
		
		$rs->bindValue(':idVisiteur', $id);

		$rs->bindValue(':nom', $nom);
	
		$rs->bindValue(':prenom', $prenom);
	
		$rs->bindValue(':login', $login);
	
		$rs->bindValue(':mdp', $mdp);
	
		$rs->bindValue(':adresse', $adresse);
	
		$rs->bindValue(':cp', $cp);
	
		$rs->bindValue(':ville', $ville);
	
		$rs->bindValue(':dateEmbauche', $dateEmbauche);


		$ligne = $rs->execute();
	
		return $ligne;
	}
	
	 public function getModifierVisiteurs($id,$nom, $prenom, $login, $mdp, $adresse, $cp, $ville, $dateEmbauche) {
		$req = "UPDATE visiteur SET nom = :nom, prenom = :prenom, login=:login, mdp = :mdp, adresse = :adresse, cp = :cp, ville = :ville, dateEmbauche = :dateEmbauche WHERE id = :id";
		//echo($nom."-".$prenom."-".$login."-".$mdp."-".$adresse."-". $cp."-".$ville."-".$dateEmbauche."-".$id);
		$stmt = $this->monPdo->prepare($req);
		
		$stmt->bindParam(':id', $id, PDO::PARAM_STR);
		//var_dump($id);
		$stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
		//ar_dump($nom);
		
		$stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
		//var_dump($prenom);

		$stmt->bindParam(':login', $login, PDO::PARAM_STR);
		//var_dump($login);

		$stmt->bindParam(':mdp', $mdp, PDO::PARAM_STR);
		//var_dump($mdp);

		$stmt->bindParam(':adresse', $adresse, PDO::PARAM_STR);
		//var_dump($adresse);

		$stmt->bindParam(':cp', $cp, PDO::PARAM_INT);
		//var_dump($cp);

		$stmt->bindParam(':ville', $ville, PDO::PARAM_STR);
		//var_dump($ville);

		$stmt->bindParam(':dateEmbauche', $dateEmbauche,PDO::PARAM_STR);
		//var_dump($dateEmbauche);*/


		$ligne = $stmt->execute();
		//var_dump($req);
		return $ligne;
	}
	
	

	public function getInfoVisiteur($id)
	{
		$req ="SELECT * FROM visiteur WHERE id = :id";
		$stmt = $this->monPdo->prepare($req);
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC); 
	}

	
	public function getSupprimerVisiteur($id){
		$req = "DELETE FROM visiteur where id=:id";
		$rs = $this->monPdo->prepare($req);
		$rs->bindParam(':id', $id);
		$rs->execute();
		
	}

	public function supprimerFichesFraisVisiteur($idVisiteur)
{	
	  // Supprimer les lignes de frais associées au visiteur
	  $reqLigneFrais = "DELETE FROM lignefraisforfait WHERE idVisiteur = :idVisiteur";
	  $rsLigneFrais = $this->monPdo->prepare($reqLigneFrais);
	  $rsLigneFrais->bindParam(':idVisiteur', $idVisiteur);
	  $rsLigneFrais->execute();
  
    $req = "DELETE FROM fichefrais WHERE idVisiteur = :idVisiteur";
    $rs = $this->monPdo->prepare($req);
    $rs->bindParam(':idVisiteur', $idVisiteur);
    $rs->execute();
}



	//Comptable :

	// public function getVisiteurNomPrenom($nomPrenom)
    // {
    //     $req = "SELECT prenom, nom FROM visiteur";
    //     $rs = $this->monPdo->query($req);
    //     // Fetch the results as an associative array
    //     $result = $rs->fetchAll(PDO::FETCH_ASSOC);
    //     return $result;
    // }

	
	public function getListeFrais()
{
    $req = "SELECT idVisiteur,mois,idEtat FROM fichefrais";
    $res = $this->monPdo->prepare($req);
    $res->execute();
    $ligne = $res->fetchAll();

    return $ligne;
}

public function getInfoFrais($idV)
{
	$req ="SELECT * FROM fichefrais WHERE idVisiteur = :idVisiteur";
	$stmt = $this->monPdo->prepare($req);
	$stmt->bindParam(':idVisiteur', $idV);
	$stmt->execute();
	return $stmt->fetch(PDO::FETCH_ASSOC); 
}
	

public function getModifFrais($idV, $mois, $nbJustificatifs, $montantValide, $dateModif, $idEtat)
{

 
       
        $reqUpdateFicheFrais = "UPDATE fichefrais SET nbJustificatifs = :nbJustificatifs, montantValide=:montantValide, dateModif = :dateModif, idEtat = :idEtat WHERE idVisiteur = :idVisiteur AND mois = :mois";
        $stmtUpdateFicheFrais = $this->monPdo->prepare($reqUpdateFicheFrais);
        $stmtUpdateFicheFrais->bindParam(':idVisiteur', $idV, PDO::PARAM_STR);
        $stmtUpdateFicheFrais->bindParam(':mois', $mois, PDO::PARAM_STR);
        $stmtUpdateFicheFrais->bindParam(':nbJustificatifs', $nbJustificatifs, PDO::PARAM_INT);
        $stmtUpdateFicheFrais->bindParam(':montantValide', $montantValide, PDO::PARAM_INT);
        $stmtUpdateFicheFrais->bindParam(':dateModif', $dateModif, PDO::PARAM_STR);
        $stmtUpdateFicheFrais->bindParam(':idEtat', $idEtat, PDO::PARAM_STR);
        $stmtUpdateFicheFrais->execute();

    
}

// public function getListeVisiteur()
// {
// 	$req = "SELECT id, nom, prenom FROM visiteur";
// 	$res = $this->monPdo->prepare($req);
// 	$res->execute();
// 	$ligne = $res->fetchAll();

// 	return $ligne;
// }

}
