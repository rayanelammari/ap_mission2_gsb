@extends ('modeles/gestionnaire')
    @section('menu')
            <!-- Division pour le sommaire -->
        <div id="menuGauche">
            <div id="infosUtil">
                  
             </div>  
               <ul id="menuList">
                   <li >
                    <strong>Bonjour {{ $gestionnaire['nom'] . ' ' . $gestionnaire['prenom'] }}</strong>
                      
                   <!--</li>
                  <li class="smenu">
                     <a href="{{ route('chemin_gestionFrais')}}" title="Saisie fiche de frais ">Saisie fiche de frais</a>
                  </li>
                  <li class="smenu">
                    <a href="{{ route('chemin_selectionMois') }}" title="Consultation de mes fiches de frais">Mes fiches de frais</a>
                  </li>-->
                  <li class="smenu">
                <a href="{{ route('chemin_gererVisiteur') }}" title="Gérer visiteur">Liste des visiteurs </a>
                  </li>  
               <li class="smenu">
                <a href="{{ route('chemin_deconnexionG') }}" title="Se déconnecter">Déconnexion</a>
                  </li>
                
                
                </ul>
               
        </div>
    @endsection