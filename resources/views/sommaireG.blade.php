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
                            <a href="{{ route('chemin_gererVisiteur') }}" title="Gérer visiteur">Liste des visiteurs</a>
                        </li>
                    @elseif(isset($visiteur))
                        Bonjour {{ $visiteur['nom'] . ' ' . $visiteur['prenom'] }}
                        <!-- ... Autres éléments spécifiques au visiteur ... -->
                    @else
                        Bienvenue, Visiteur
                    @endif
                </strong>
            </li>
            <li class="smenu">
                <a href="{{ route('chemin_deconnexionG') }}" title="Se déconnecter">Déconnexion</a>
            </li>
        </ul>
    </div>
@endsection
