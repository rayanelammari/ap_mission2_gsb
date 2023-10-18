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

        /*-------------------- Use case gérer les frais---------------------------*/

Route::get('gererFrais',[
        'as'=>'chemin_gestionFrais',
        'uses'=>'gererFraisController@saisirFrais'
]);

Route::post('sauvegarderFrais',[
        'as'=>'chemin_sauvegardeFrais',
        'uses'=>'gererFraisController@sauvegarderFrais'
]);

Route::get('gererVisiteur',[
        'as'=>'chemin_gererVisiteur',
        'uses'=>'gererLesVisiteurs@afficherVisiteur'
]);


Route::post('ajouterVisiteur',[
        'as'=>'chemin_ajouterVisiteur',
        'uses'=>'gererLesVisiteurs@ajouterVisiteur'
]);

Route::post('modifierVisiteur', [
        'as' =>'chemin_modifierVisiteur',
        'uses' => 'gererLesVisiteurs@modifierVisiteur'
]);





