@extends ('sommaireG')
    @section('contenu1')
      <div id="contenu">
            <form action="{{ route('chemin_modifierVisiteur') }}" method="post">
          
                <h1>Modifier un visiteur</h1>
                    <input type="hidden" name="num" value="{{$unVisiteur['id']}}">
                    <label for="nom">Nom:</label><br>
                    <input type="text" id="nom" name="nom" value="{{$unVisiteur['nom']}}"><br>
                    <label for="prenom">Prénom:</label><br>
                    <input type="text" id="prenom" name="prenom" value="{{$unVisiteur['prenom']}}"><br>
                    <label for="login">Login*:</label><br>
                    <input type="text" id="login" name="login" value="{{$unVisiteur['login']}}"><br>
                    <label for="mdp">Mot de passe:</label><br>
                    <input type="password" id="password" name="password" value="{{$unVisiteur['mdp']}}"><br>
                    <label for="adresse">Adresse:</label><br>
                    <input type="text" id="adresse" name="adresse" value="{{$unVisiteur['adresse']}}"><br>
                    <label for="cp">Code postal:</label><br>
                    <input type="cp" id="cp" name="cp" value="{{$unVisiteur['cp']}}"><br>
                    <label for="ville">Ville:</label><br>
                    <input type="text" id="ville" name="ville" value="{{$unVisiteur['ville']}}"><br><br>
                    <label for="dateE">Date Embauche:</label><br>
                    <input type="text" id="dateE" name="dateE" value="{{$unVisiteur['dateEmbauche']}}"><br><br>
                    <input type="submit" name="submit" value="Enregistrer les modifications">
            </form>
           
        
    @endsection

