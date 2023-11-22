@extends('modeles/gestionnaire')

@section('menu')
    <!-- Division pour le sommaire -->
    <div id="menuGauche">
        <div id="infosUtil">
        </div>  
        <ul id="menuList">
            
            <li>
                <strong>
                    @if(isset($gestionnaire))
                        Bonjour {{ $gestionnaire['nom'] . ' ' . $gestionnaire['prenom'] }}
                        <!-- ... Autres éléments spécifiques au gestionnaire ... -->
                        <li class="smenu">
                            <a href="{{ route('chemin_gererVisiteur') }}" title="Gérer visiteur">Gérer les visiteurs</a>
                        </li>
                   
                    @elseif(isset($visiteur))
                        Bonjour {{ $visiteur['nom'] . ' ' . $visiteur['prenom'] }}
                        <li class="smenu">
                            <a href="{{ route('chemin_gestionFrais')}}" title="Saisie fiche de frais ">Saisie fiche de frais</a>
                        </li>
                         <li class="smenu">
                            <a href="{{ route('chemin_selectionMois') }}" title="Consultation de mes fiches de frais">Mes fiches de frais</a>
                        </li>
                    @else
                        Bonjour {{ $comptable['nom'] . ' ' . $comptable['prenom'] }}
                        <li class="smenu">
                            <a href="{{ route('chemin_ficheFrais') }}" title="Consultation des visiteurs">Gérer fiche frais</a>
                        </li>
                    @endif
                </strong>
            </li>
            <li class="smenu">
                <a href="{{ route('chemin_deconnexionG') }}" title="Se déconnecter">Déconnexion</a>
            </li>
        </ul>
    </div>
@endsection
