<?php

namespace App\Http\Controllers;

use App\Facades\PdoGsb as FacadesPdoGsb;
use App\MyApp\PdoGsb as MyAppPdoGsb;
use Illuminate\Http\Request;
use PdoGsb;


class gererFicheFrais extends Controller
{

public function afficheFrais(Request $request)
{
    if (session('comptable') != null) {
        $comptable = session('comptable');
        htmlentities($idComptable = $comptable['id']);
        $fiche = PdoGsb::getListeFrais();
    
        $view = view('ficheFrais')
            ->with('fiche', $fiche)
            ->with('comptable', $comptable);

        return $view;
    } else {
        return view('connexionG')->with('erreurs', null);
    }
}

public function infoFrais(Request $request)
{
    if (session('comptable') != null) {
        $comptable = session('comptable');
        htmlentities($idComptable = $comptable['id']);
        htmlentities($idV = $request['idVisiteur']);
        $fiche = PdoGsb::getListeFrais();
        $infoFicheFrais=PdoGsb::getInfoFrais($idV);
    
        $view = view('modifFicheFrais')
            ->with('fiche', $fiche)
            ->with('infoFicheFrais', $infoFicheFrais)
            ->with('comptable', $comptable);



        return $view;
    } else {
        return view('connexionG')->with('erreurs', null);
    }
}

function modifierFicheFrais(Request $request)
{
    if (session('comptable') != null) {
        $comptable = session('comptable');
        htmlentities($idComptable = $comptable['id']);

        htmlentities($idV = $request['idVisiteur']);
   
      htmlentities($mois = $request['mois']);
      htmlentities($nbJustificatifs = $request['nbJustificatifs']);
      htmlentities($montantValide = $request['montantValide']);
      htmlentities($dateModif = $request['dateModif']);
      htmlentities($idEtat = $request['idEtat']);
      
      $infoFicheFrais=PdoGsb::getInfoFrais($idV);
      $modifierFicheFrais = PdoGsb::getModifFrais($idV,$mois,$nbJustificatifs,$montantValide,$dateModif,$idEtat);
      $fiche = PdoGsb::getListeFrais();


      //dd($infoVisiteur);

      $view = view('ficheFrais')
                ->with('fiche', $fiche)
                ->with('infoFicheFrais', $infoFicheFrais)
                ->with('modifierFicheFrais',$modifierFicheFrais)
                ->with('comptable', $comptable);
             
      return $view;

  }
  else
  {
      return view('connexionG')->with('erreurs',null);
  }
}



    

}