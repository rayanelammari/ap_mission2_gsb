<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
        /*-------------------- Use case connexion---------------------------*/
Route::get('/',[
        'as' => 'chemin_connexion',
        'uses' => 'connexionController@connecter'
]);


Route::post('/',[
        'as'=>'chemin_valider',
        'uses'=>'connexionController@valider'
]);
Route::get('deconnexion',[
        'as'=>'chemin_deconnexion',
        'uses'=>'connexionController@deconnecter'
]);
        /*-------------------- gestionnaire case connexion---------------------------*/
        Route::get('/',[
                'as' => 'chemin_connexionG',
                'uses' => 'connexionControllerG@connecterG'
        ]);
        
        
        Route::post('/',[
                'as'=>'chemin_validerG',
                'uses'=>'connexionControllerG@validerG'
        ]);
        Route::get('deconnexion',[
                'as'=>'chemin_deconnexionG',
                'uses'=>'connexionControllerG@deconnecterG'
        ]);


         /*-------------------- Use case état des frais---------------------------*/
Route::get('selectionMois',[
        'as'=>'chemin_selectionMois',
        'uses'=>'etatFraisController@selectionnerMois'
]);

Route::post('listeFrais',[
        'as'=>'chemin_listeFrais',
        'uses'=>'etatFraisController@voirFrais'
]);

        /*-------------------- Users case gérer les frais---------------------------*/

Route::get('gererFrais',[
        'as'=>'chemin_gestionFrais',
        'uses'=>'gererFraisController@saisirFrais'
]);

Route::post('sauvegarderFrais',[
        'as'=>'chemin_sauvegardeFrais',
        'uses'=>'gererFraisController@sauvegarderFrais'
]);

/*-----------------Route gestionnaire--------------*/
Route::any('gererVisiteur', [
        'as' => 'chemin_gererVisiteur',
        'uses' => 'gererLesVisiteurs@afficherVisiteur'
    ]);
    
Route::get('infoVisiteur', [
        'as' => 'chemin_infoVisiteur',
        'uses' => 'gererLesVisiteurs@infoVisiteur'
]);
Route::get('ajouterVisiteur',[
        'as'=>'chemin_ajout',
        'uses'=>'gererLesVisiteurs@nouveauVisiteur'
]);

Route::post('ajouterVisiteur',[
        'as'=>'chemin_ajouterVisiteur',
        'uses'=>'gererLesVisiteurs@ajouterVisiteur'
]);

Route::get('modifierVisiteur',[
        'as' =>'chemin_modifierVisiteur',
        'uses' => 'gererLesVisiteurs@infoVisiteur'
]);



Route::post('modifierVisiteur',[
        'as' =>'chemin_modifier',
        'uses' => 'gererLesVisiteurs@modifierVisiteur'
]);

Route::post('supprimerVisiteur', [
        'as' =>'chemin_supprimerVisiteur',
        'uses' => 'gererLesVisiteurs@supprimerVisiteur'
]);

Route::get('supprimerVisiteur', [
        'as' =>'chemin_supprimer',
        'uses' => 'gererLesVisiteurs@supprimer'
]);

 Route::get('genererPdf',[
        'as' =>'chemin_genererPdf',         
        'uses'=>'gererLesVisiteurs@genererPdfListeVisiteur'
 ]);


/*-----------Comptable*/
Route::get('listeFicheFrais', [
        'as' =>'chemin_ficheFrais',
        'uses' => 'gererFicheFrais@afficheFrais'
]);
Route::get('infoFicheFrais', [
        'as' =>'chemin_infoFicheFrais',
        'uses' => 'gererFicheFrais@infoFrais'
]);

Route::get('modifFicheFrais', [
        'as' =>'chemin_modifFicheFrais',
        'uses' => 'gererFicheFrais@infoFrais'
]);
Route::post('modifFicheFrais',[
        'as' =>'chemin_modifierFrais',
        'uses' => 'gererFicheFrais@modifierFicheFrais'
]);




