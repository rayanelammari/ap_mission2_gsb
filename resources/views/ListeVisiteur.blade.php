@extends ('sommaireG')
    @section('contenu1')
      <div id="contenu">
                
   

                {{ csrf_field() }} <h2>Liste des visiteurs :</h2>
                <h3>sélectionner un visiteur: </h3>
                
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
                    
                            <td>{{ $unVisiteur['id'] }}</td>
                            <td>{{ $unVisiteur['nom'] }}</td>
                            <td>{{ $unVisiteur['prenom'] }}</td>
                            
                            
                            <td>

                                <a href="{{ Route('chemin_modifierVisiteur', ['id'=>$unVisiteur['id']] ) }}">
                                    <input type="hidden" name="id" value="{{$unVisiteur['id']}}">
                                    <button type="submit" class="modifier">Modifier</button>
                                </a>

                            </td>

                            <td>

                                <a href="{{ Route('chemin_supprimer', ['id'=>$unVisiteur['id']] ) }}">
                                    <input type="hidden" name="id" value="{{$unVisiteur['id']}}">
                                    <button type="submit" class="supprimer">Supprimer</button>


                            </td>
                        
                        </tr>

                        @endforeach

                    </tbody>
                </table>
                    <a href="{{Route('chemin_ajout')}}">
                        <input type="submit" value="Ajouter">
                    </a>
                    <a href="{{route('chemin_genererPdf')}}">
                        <input type="submit" value="Télécharger en Pdf">
                    </a>
        </div>

    @endsection 
