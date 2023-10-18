@extends ('sommaireG')
    @section('contenu1')
      <div id="contenu">
            <form action="{{ route('chemin_gererVisiteur') }}" method="post">
                {{ csrf_field() }} <!--laravel va ajouter un champ caché avec un token -->
                <h2>Liste des visiteurs :</h2>
                <h3>sélectionner un visiteur: </h3>

                <table>
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>nom</th>
                            <th>prenom</th>
                            <th>login</th>
                            <th>mdp</th> 
                            <th>adresse</th> 
                            <th>cp</th> 
                            <th>ville</th> 
                            <th>dateEmbauche</th> 
                            <th></th> 
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($Visiteurs as $unVisiteur)
                    <tr>
                 
                        <td>{{ $unVisiteur['id'] }}</td>
                        <td>{{ $unVisiteur['nom'] }}</td>
                        <td>{{ $unVisiteur['prenom'] }}</td>
                        <td>{{ $unVisiteur['login'] }}</td>
                        <td>{{ $unVisiteur['mdp'] }}</td>
                        <td>{{ $unVisiteur['adresse'] }}</td>
                        <td>{{ $unVisiteur['cp'] }}</td>
                        <td>{{ $unVisiteur['ville'] }}</td>
                        <td>{{ $unVisiteur['dateEmbauche'] }}</td>
                        
                        
                        <td>
                        <form action="{{ route('chemin_modifierVisiteur') }}" method="post">
                        <input type="hidden" name="id" value="{{$unVisiteur['id']}}">
                        <button type="submit">Modifier</button>
                        </form>
                        </td>
                     

                    </tr>
                    @endforeach
                </tbody>
                </table>
        
                <br><button type="submit">Ajouter un nouveau visiteur</button>
            </form>
@endsection 
 