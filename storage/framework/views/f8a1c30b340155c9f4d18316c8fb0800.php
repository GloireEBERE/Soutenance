<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="<?php echo e(route('dashboard')); ?>">
                <i class="bi bi-grid"></i>
                <span>Tableau de bord</span> 
            </a>
        </li>
        <!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo e(route('affectation.index')); ?>">
                <i class="bi bi-person-up"></i>
                <span>Affectation des stagiaires</span>
            </a>
        </li>
        <!-- End Affectation des stagiaires Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo e(route('changeRoleAffiche')); ?>">
                <i class="bi bi-bookmark-star-fill"></i>
                <span>Changement de statut</span>
            </a>
        </li>
        <!-- End Changement de statut Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo e(route('valider')); ?>">
                <i class="bi bi-person-check"></i>
                <span>Les stagiaires acceptées</span>
            </a>
        </li><!-- End Les stagiaires acceptées Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo e(route('refuser')); ?>">
                <i class="bi bi-person-dash"></i>
                <span>Les stagiaires Refusées</span>
            </a>
        </li><!-- End Les stagiaires Refusées Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo e(route('liste')); ?>">
                <i class="bi bi-person-lines-fill"></i>
                <span>Liste complète</span>
            </a>
        </li><!-- End Liste des tuteurs Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo e(route('recevoirDemande')); ?>">
                <i class="bi bi-file-earmark"></i>
                <span>Liste des demandes de stage</span>
            </a>
        </li><!-- End Liste des demandes de stage Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo e(route('tuteur')); ?>">
                <i class="bi bi-person-check-fill"></i>
                <span>Liste des tuteurs</span>
            </a>
        </li><!-- End Liste des tuteurs Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo e(route('consulterRapport')); ?>">
                <i class="bi bi-file-arrow-down-fill"></i>
                <span>Les rapports de stage</span>
            </a>
        </li><!-- End Liste des tuteurs Page Nav -->
        

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo e(route('profile')); ?>">
                <i class="bi bi-person"></i>
                <span>Profil</span>
            </a>
        </li>
        <!-- End Profile Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo e(route('statistic')); ?>">
                <i class="bi bi-bar-chart-line-fill"></i>
                <span>Les statistiques</span>
            </a>
        </li><!-- End Statistiques Page Nav -->

        <?php if(auth()->guard()->check()): ?>
            <li class="nav-item">
                <!-- Formulaire de déconnexion avec bouton -->
                <form action="<?php echo e(route('deconnexion')); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="nav-link collapsed" style="border: none; background: transparent;">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </li>
        <?php endif; ?>

        
<!-- End Error 404 Page Nav -->

    </ul>

</aside><?php /**PATH C:\laragon\www\stagiaire\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>