@extends ('sommaireG')
    @section('contenu1')
    <div id="contenu">

        <h1>Modifier un visiteur</h1>

   
        <form action="{{Route('chemin_modifierFrais',['idVisiteur'=>$infoFicheFrais['idVisiteur']] )}}" method="POST">
        @csrf <!-- Ajoutez cette ligne pour inclure le jeton CSRF -->
                <label for="idVisiteur">Id Visiteur:</label><br>
                <input type="text" name="idVisiteur" id ="idVisiteur" value="{{$infoFicheFrais['idVisiteur']}}" readonly><br>
                <label for="mois">Mois :</label><br>
                <input type="text" id="mois" name="mois" value="{{$infoFicheFrais['mois']}}" readonly><br>
                <label for="nbJustificatifs">nbJustificatifs:</label><br>
                <input type="int" id="nbJustificatifs" name="nbJustificatifs" value="{{$infoFicheFrais['nbJustificatifs']}}"readonly><br>
                <label for="montantValide">montantValide:</label><br>
                <input type="text" id="montantValide" name="montantValide" value="{{$infoFicheFrais['montantValide']}}"readonly><br>
                <label for="dateModif">dateModif:</label><br>
                <input type="text" id="dateModif" name="dateModif" value="{{$infoFicheFrais['dateModif']}}"readonly><br>
                <label for="idEtat">idEtat:</label><br>
                <input type="text" id="idEtat" name="idEtat" value="{{$infoFicheFrais['idEtat']}}"><br>
                <!-- ... (autres champs du formulaire) ... -->
                <input type="submit" name="submit" value="Enregistrer les modifications">
        </form>
       

            
    </div>
            
        
    @endsection

