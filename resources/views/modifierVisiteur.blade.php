@extends ('sommaireG')
    @section('contenu1')
    <div id="contenu">

        <h1>Modifier un visiteur</h1>

   
        <form action="{{Route('chemin_modifier',['id'=>$infoVisiteur['id']] )}}" method="POST">
        @csrf <!-- Ajoutez cette ligne pour inclure le jeton CSRF -->
                <label for="id">Id:</label><br>
                <input type="text" name="id" id ="id" value="{{$infoVisiteur['id']}}" readonly><br>
                <label for="nom">Nom:</label><br>
                <input type="text" id="nom" name="nom" value="{{$infoVisiteur['nom']}}"><br>
                <label for="prenom">Prenom:</label><br>
                <input type="text" id="prenom" name="prenom" value="{{$infoVisiteur['prenom']}}"><br>
                <label for="login">Login*:</label><br>
                <input type="text" id="login" name="login" value="{{$infoVisiteur['login']}}"><br>
                <label for="mdp">Mot de passe*:</label><br>
                <input type="password" id="mdp" name="mdp" value="{{$infoVisiteur['mdp']}}"><br>
                <label for="adresse">Adresse:</label><br>
                <input type="text" id="adresse" name="adresse" value="{{$infoVisiteur['adresse']}}"><br>
                <label for="cp">Code postal:</label><br>
                <input type="text" id="cp" name="cp" value="{{$infoVisiteur['cp']}}"><br>
                <label for="ville">Ville:</label><br>
                <input type="text" id="ville" name="ville" value="{{$infoVisiteur['ville']}}"><br><br>
                <label for="dateEmbauche">Date Embauche:</label><br>
                <input type="date" id="dateEmbauche" name="dateEmbauche" value="{{$infoVisiteur['dateEmbauche']}}"><br><br>
                <!-- ... (autres champs du formulaire) ... -->
                <input type="submit" name="submit" value="Enregistrer les modifications">
        </form>
       

            
    </div>
            
        
    @endsection

