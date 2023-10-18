@extends ('listemois')
@section('contenu2')

<h3>Formulaire d'ajout de visiteur.</h3>


<form action="{{chemin_ajouterVisiteur}}">

 <label for="">Nom</label>
 <input type="text" name="" id="">
 <label for="">Prenom</label>
 <input type="text">
 <label for="">Login</label>
 <input type="text">
 <label for="">mdp</label>
 <input type="text">
 <label for="">Adresse</label>
 <input type="text">
 <label for="">CP</label>
 <input type="text" name="" id="">
 <label for="">VILLE</label>    
 <input type="text" name="" id="">
 <label for="">dateEmbauche</label>
 <input type="text">
</form>