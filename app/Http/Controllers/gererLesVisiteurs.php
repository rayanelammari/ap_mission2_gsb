<?php

namespace App\Http\Controllers;

use App\Facades\PdoGsb as FacadesPdoGsb;
use App\MyApp\PdoGsb as MyAppPdoGsb;
use Illuminate\Http\Request;
use PdoGsb;
use Dompdf\Options;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
//use App\Your\Namespace\PdoGsb;



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
            htmlentities($idGestionnaire = $gestionnaire['id']);

            

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
            htmlentities($idGestionnaire = $gestionnaire['id']);
            htmlentities($id = $request['idVisiteur']);
            htmlentities($nom =  $request['nom']);
            htmlentities($prenom =  $request['prenom']);
            htmlentities($login = $request['login']);
            htmlentities($mdp = password_hash($request['mdp'], PASSWORD_DEFAULT));
            htmlentities($adresse = $request['adresse']);
            htmlentities($cp = $request['cp']);
            htmlentities($ville = $request['ville']);

            htmlentities($dateEmbauche = $request['dateEmbauche']);
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
            htmlentities($idGestionnaire = $gestionnaire['id']);
            htmlentities($id=$request['id']);
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
            htmlentities($idGestionnaire = $gestionnaire['id']);
    
            htmlentities($id = $request['id']);
    
            $Visiteurs = PdoGsb::getListeVisiteur();
            $visiteurExiste = false;
            foreach ($Visiteurs as $info) {
                if (!empty(htmlentities($info['id'])) && htmlentities($info['id']) == $id) {
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

    function genererPdfListeVisiteur() {
        if(session('gestionnaire')!= null)
        {
            
            $gestionnaire = session('gestionnaire');
            htmlentities($idGestionnaire = $gestionnaire['id']);
            $Visiteurs = PdoGsb::getListeVisiteur();
            
            $options= new Options();

            $dompdf=new Dompdf($options);


        $html = View::make('listeVisiteurPdf', ['Visiteurs' => $Visiteurs, 'gestionnaire' => $gestionnaire])->render();
        $dompdf->loadHtml($html);

        $dompdf->render();

        return $dompdf->stream('liste_visiteur.pdf');
        }else {
            return view('connexionG')->with('erreurs', null);
        }
    }

   
 

    
}

    
    

    

        
    
       

