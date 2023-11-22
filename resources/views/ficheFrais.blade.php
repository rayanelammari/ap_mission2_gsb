@extends ('sommaireG')
    @section('contenu1')
      <div id="contenu">

                {{ csrf_field() }} <h2>Liste des fiche frais :</h2>
                <h3>sélectionner une fiche frais: </h3>
                
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>mois</th>
                            <th>Etat de la fiche</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fiche as $uneFiche)
                        <tr>
                    
                            <td>{{ $uneFiche['idVisiteur'] }}</td>
                            <td>{{ $uneFiche['mois'] }}</td>
                            <td>{{ $uneFiche['idEtat'] }}</td>

                            <td>
                              <a href="{{ route('chemin_modifFicheFrais', ['idVisiteur' => $uneFiche['idVisiteur']] ) }}">
                              <input type="hidden" name="idVisiteur" value="{{ $uneFiche['idVisiteur'] }}">
                              <button type="submit" class="modifier" style="border: none; background: none; padding: 0;">
                              <img src="data:image/png;base64,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">
                              </button>
                              </a>
                            </td>

                        
                        </tr>

                        @endforeach

                    </tbody>
                </table>
                  
   
        </div>

    @endsection 
