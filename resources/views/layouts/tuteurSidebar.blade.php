<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="{{ route('dashboard.tuteur') }}">
                <i class="bi bi-grid"></i>
                <span>Tableau de bord</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('profil.tuteur') }}">
                <i class="bi bi-person"></i>
                <span>Profil</span>
            </a>
        </li><!-- End Profile Page Nav -->

        @php
            // Récupérer le tuteur connecté
            $tuteur = auth()->user()->tuteur ?? null;

            // Récupérer les stagiaires affectés au tuteur, ou une collection vide si aucun tuteur
            $stagiaires = $tuteur ? $tuteur->stagiaires : collect();
        @endphp

        @if($stagiaires->isNotEmpty())
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('listeStagiaire.tuteur') }}">
                    <i class="bi bi-person-lines-fill"></i>
                    <span>Liste des stagiaires affectés</span>
                </a>
            </li>
            <!-- End Liste des stagiaires affectés Page Nav -->
        @endif
        

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('tacheAffiche') }}">
                <i class="bi bi-send-fill"></i>
                <span>Attribuer une tâche</span>
            </a>
        </li>
        <!-- End Liste des tuteurs Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('listeTacheAfaire.tuteur') }}">
                <i class="bi bi-calendar-event"></i>
                <span>Liste des tâches à accomplir</span>
            </a>
        </li>
        <!-- End Liste des tuteurs Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('listeTacheAccomplie.tuteur') }}">
                <i class="bi bi-list-check"></i>
                <span>Liste des tâches accomplies</span>
            </a>
        </li>
        <!-- End Liste des tuteurs Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('projetAffiche') }}">
                <i class="bi bi-send"></i>
                <span>Attribuer un projet</span>
            </a>
        </li>
        <!-- End Attribuer un projet Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('listeProjet') }}">
                <i class="bi bi-list-nested"></i>
                <span>Liste des projets</span>
            </a>
        </li>
        <!-- End Liste des tuteurs Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed"  href="{{ route('consulteRapport') }}">
                <i class="bi bi-file-arrow-down-fill"></i>
                <span>Consulter le rapport de stage</span>
            </a>
        </li>

        @auth
            <li class="nav-item">
                <!-- Formulaire de déconnexion avec bouton -->
                <form action="{{ route('deconnexion') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link collapsed" style="border: none; background: transparent;">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </li>
        @endauth

        
<!-- End Error 404 Page Nav -->

    </ul>

</aside>