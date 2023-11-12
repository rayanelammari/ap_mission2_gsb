@extends ('sommaireG')
@section('contenu1')
<div id="contenu">


<h3>Formulaire d'ajout de visiteur.</h3>
@csrf <!-- Ajoutez cette ligne pour inclure le jeton CSRF -->

<form action="{{Route('chemin_ajouterVisiteur')}}" method="post">
  
 <label for="nom">Nom</label>
 <input type="text" name="nom" id="nom" required/><br><br>
 <label for="prenom">Prenom</label>
 <input type="text"  name="prenom" id="prenom" required/><br><br>
 <label for="login">Login</label>
 <input type="text" name="login" id="login" required/><br><br>
 <label for="mdp">mdp</label>
 <input type="password" name="mdp" id="mdp" required/><br><br>
 <label for="adresse">Adresse</label>
 <input type="text" name="adresse" id="adresse" required/><br><br>
 <label for="cp">CP</label>
 <input type="text" name="cp"  id="cp" required/><br><br>
 <label for="ville">ville</label> 
 <input type="text" name="ville" id="ville" required/><br><br>   
 <label for="dateEmbauche">dateEmbauche</label>
 <input type="date" name="dateEmbauche" id="dateEmbauche" required/><br><br>   
<input type="submit"/>
</form>

</div>

<!--<script>

function action(){
  alert("Formulaire a bien été envoyé ! merci de votre confiance.");
}
</script>-->

@endsection