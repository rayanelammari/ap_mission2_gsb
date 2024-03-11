<div id="contenu">
               

        <h2>Liste des visiteurs :</h2>
        <h3>Sélectionner un visiteur :</h3>

        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>id</th>
                    <th>nom</th>
                     <th>prenom</th>
                </tr>
            </thead>
            <tbody>
                @foreach($Visiteurs as $unVisiteur)
                    <tr>
                        <td>{{ $unVisiteur['id'] }}</td></br>
                        <td>{{ $unVisiteur['nom'] }}</td>
                        <td>{{ $unVisiteur['prenom'] }}</td></br>
                    </tr>
                @endforeach
            </tbody>

        </table>
</div>
