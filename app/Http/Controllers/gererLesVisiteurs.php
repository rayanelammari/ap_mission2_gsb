<?php

namespace App\Http\Controllers;

use App\Facades\PdoGsb as FacadesPdoGsb;
use App\MyApp\PdoGsb as MyAppPdoGsb;
use Illuminate\Http\Request;
use PdoGsb;
use PDF;



class gererLesVisiteurs extends Controller
{
    function afficherVisiteur(Request $request){
       
        if( session('gestionnaire') != null){
            $gestionnaire = session('gestionnaire');
            htmlentities($idGestionnaire = $gestionnaire['id']);
            $Visiteurs = PdoGsb::getListeVisiteur();
            $view = view('ListeVisiteur')
                    ->with('Visiteurs', $Visiteurs)
                    ->with('gestionnaire', $gestionnaire);

            return $view;
            
        }
        else{
            return view('connexionG')->with('erreurs',null);
        }
       
           
    }

    function infoVisiteur(Request $request)
    {  
        if(session('gestionnaire') != null)
        {
            $gestionnaire = session('gestionnaire');

            htmlentities($idGestionnaire = $gestionnaire['id']);
            htmlentities($id = $request['id']);
                
            $infoVisiteur =PdoGsb::getInfoVisiteur($id);
            $Visiteurs = PdoGsb::getListeVisiteur();



            $view = view('modifierVisiteur')
                    ->with('infoVisiteur',$infoVisiteur)
                    ->with('Visiteurs',$Visiteurs)
                    ->with('gestionnaire', $gestionnaire);
                   
            return $view;
        } else
        {
            return view('connexionG')->with('erreurs',null);
        }

    } 

    function modifierVisiteur(Request $request)
      { //dd($request);
         if(session('gestionnaire') != null)
        {

            $gestionnaire = session('gestionnaire');

            htmlentities($idGestionnaire = $gestionnaire['id']);

            htmlentities($id = $request['id']);
         
            htmlentities($nom = $request['nom']);
            htmlentities($prenom = $request['prenom']);
            htmlentities($login = $request['login']);
            htmlentities($mdp = $request['mdp']);
            htmlentities($adresse = $request['adresse']);
            htmlentities($cp = $request['cp']);
            htmlentities($ville = $request['ville']);
            htmlentities($dateEmbauche = $request['dateEmbauche']);
            
            $infoVisiteur =PdoGsb::getInfoVisiteur($id);
            $modifierVisiteur = PdoGsb::getModifierVisiteurs($id,$nom, $prenom, $login, $mdp, $adresse, $cp, $ville, $dateEmbauche);
            $Visiteurs = PdoGsb::getListeVisiteur();

            //dd($infoVisiteur);

            $view = view('ListeVisiteur')
                    ->with('infoVisiteur',$infoVisiteur)
                    ->with('Visiteurs', $Visiteurs)
                    ->with('modifierVisiteur', $modifierVisiteur)
                    ->with('gestionnaire', $gestionnaire);
                   
            return $view;

        }
        else
        {
            return view('connexionG')->with('erreurs',null);
        }
    }


    function nouveauVisiteur(Request $request)
    {

        if(session('gestionnaire')!= null)
        {
            
            $gestionnaire = session('gestionnaire');
            $idGestionnaire = $gestionnaire['id'];

            

            $view = view('ajouterVisiteur')
            ->with('gestionnaire', $gestionnaire);
                 
            return $view;
        }
        else
        {
            return view('connexion')->with('erreurs', null);
        }
    }


    function ajouterVisiteur(Request $request){

        if(session('gestionnaire') != null){

            $gestionnaire = session('gestionnaire');
            //$idGestionnaire = $gestionnaire['id'];
            $id = $request['idVisiteur'];
            $nom =  $request['nom'];
            $prenom =  $request['prenom'];
            $login = $request['login'];
            $mdp = $request['mdp'];
            $adresse = $request['adresse'];
            $cp = $request['cp'];
            $ville = $request['ville'];
            $dateEmbauche = $request['dateEmbauche'];
            $Visiteurs = PdoGsb::getListeVisiteur();
            $ajouterVisiteur = PdoGsb::getAjouterVisiteur($id,$nom, $prenom, $login, $mdp, $adresse, $cp , $ville , $dateEmbauche);
            $view = view('ListeVisiteur')
                ->with('ajouterVisiteur', $ajouterVisiteur)
                ->with('Visiteurs', $Visiteurs)
                ->with('gestionnaire', $gestionnaire);
                
                return $view;

        }else{
            return view('connexionG')->with('erreurs',null); 
        }
    }

    function supprimer(Request $request)
    {

        if(session('gestionnaire')!= null)
        {
            
            $gestionnaire = session('gestionnaire');
            $idGestionnaire = $gestionnaire['id'];
            $id=$request['id'];
            $infoVisiteur =PdoGsb::getInfoVisiteur($id);

            

            $view = view('supprimerVisiteur')
                ->with('infoVisiteur', $infoVisiteur)
                ->with('gestionnaire', $gestionnaire);
                 
            return $view;
        }
        else
        {
            return view('connexion')->with('erreurs', null);
       
        }
    }
    function supprimerVisiteur(Request $request)
    {
        if (session('gestionnaire') != null) {
            $gestionnaire = session('gestionnaire');
            $idGestionnaire = $gestionnaire['id'];
    
            $id = $request['id'];
    
            $Visiteurs = PdoGsb::getListeVisiteur();
            $visiteurExiste = false;
            foreach ($Visiteurs as $info) {
                if (!empty($info['id']) && $info['id'] == $id) {
                    $visiteurExiste = true;
                    break;
                }
            }
            //var_dump($visiteurExiste); 

            
    
            if ($visiteurExiste) {
        
                // Supprimer les fiches de frais associées au visiteur
                PdoGsb::supprimerFichesFraisVisiteur($id);
    
                // Supprimer le visiteur
                $supprimerVisiteur = PdoGsb::getSupprimerVisiteur($id);

                $Visiteurs = PdoGsb::getListeVisiteur();

    
                $view = view('ListeVisiteur')
                    ->with('supprimerVisiteur', $supprimerVisiteur)
                    ->with('Visiteurs',$Visiteurs)
                    ->with('gestionnaire', $gestionnaire);
    
                return $view;
            }else
            {
                return "Le visiteur que vous voulez supprimer n'existe pas.";

            }
        } else {
            return view('connexionG')->with('erreurs', null);
        }
    }

    public function getPostPdf()
    {
 
        if( session('gestionnaire') != null){
            $gestionnaire = session('gestionnaire');
            $idGestionnaire = $gestionnaire['id'];
            $Visiteurs = PdoGsb::getListeVisiteur();
            // Générer le PDF
            $pdf = PDF::loadView('listeVisiteurPdf', ['Visiteurs' => $Visiteurs]);

            // Télécharger le PDF
             return $pdf->download('liste_visiteurs.pdf');
        }
        
        else{
            return view('connexionG')->with('erreurs',null);
        }
    }

   
 

    
}

    
    

    

        
    
       

