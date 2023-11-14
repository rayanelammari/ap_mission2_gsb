@extends ('sommaireG')
    @section('contenu1')
      <div id="contenu">
               

        <h2>Liste des visiteurs :</h2>
        <h3>Sélectionner un visiteur :</h3>

        <table class="table table-responsive">
            @foreach($Visiteurs as $unVisiteur)
                <tr>
                    <td>{{ $unVisiteur['id'] }}</td>
                    <td>{{ $unVisiteur['nom'] }}</td>
                    <td>{{ $unVisiteur['prenom'] }}</td>
                </tr>
            @endforeach
        </table>
        
    @endsection 
