<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PdoGsb;

class gererLesVisiteurs extends Controller
{
    function afficherVisiteur(Request $request){
       
        if( session('gestionnaire') != null){
            $gestionnaire = session('gestionnaire');
            $idGestionnaire = $gestionnaire['id'];
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

    function modifierVisiteur(Request $request){
        if(session('gestionnaire') != null){
            $gestionnaire = session('gestionnaire');
            $idGestionnaire = $gestionnaire['id'];
            $modfierVisiteurs = PdoGsb::getModifierVisiteurs();

            $view = view('modifierVisiteur')
                    ->with('modifierVisiteurs',$modfierVisiteurs)
                    ->with('gestionnaire', $gestionnaire);


        }else{
            return view('connexionG')->with('erreurs',null);
        }

    function ajouterVisiteur($nom, $prenom, $login,$mdp, $adresse, $cp , $ville , $dateEmbauche){
        if(session('gestionnaire') != null){
            $gestionnaire = session('gestionnaire');
            $idGestionnaire = $gestionnaire['id'];
            $ajouterVisiteur = PdoGsb::getAjouterVisiteur();

        $view = view('ajouterVisiteur')
                ->with('ajouterVisiteur', $ajouterVisiteur)
                ->with('gestionnaire', $gestionnaire);


        }else{
            return view('connexionG')->with('erreurs',null);
        }
    }

        
    }
       
}
