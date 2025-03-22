<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link active" href="<?php echo e(route('dashboard.user')); ?>">
                <i class="bi bi-grid"></i>
                <span>Tableau de bord</span>
            </a>
        </li><!-- Fin Tableau de bord -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo e(route('AfficherDemande')); ?>">
                <i class="bi bi-pencil-square"></i>
                <span>Soumettre une demande</span>
            </a>
        </li>
        <!-- Fin Faire une demande -->

        <?php
            // Récupère les demandes du stagiaire connecté
            $demandes = auth()->user()->stagiaire->demandes ?? collect();

            // Récupère la première demande
            $demande = $demandes->first(); 
        ?>

        <?php if($demande && $demande->statut == 'en attente'): ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo e(route('demande.affiche', ['id' => $demande->id])); ?>">
                    <i class="bi bi-file-earmark-diff"></i>
                    <span>Modifier la demande</span>
                </a>
            </li>
        <?php endif; ?>

        <?php if(auth()->check() && auth()->user()->stagiaire && auth()->user()->stagiaire->demandes->where('statut', 'acceptée')->isNotEmpty()): ?>

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo e(route('TacheListeFaire')); ?>">
                    <i class="bi bi-calendar-event"></i>
                    <span>Liste des tâches à effectuer</span>
                </a>
            </li>
            <!-- Fin liste des tâches à effectuer -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo e(route('TacheListeValider')); ?>">
                    <i class="bi bi-list-stars"></i>
                    <span>Liste des tâches déjà effectuées</span>
                </a>
            </li>
            <!-- Fin liste des tâches déjà effectuées -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo e(route('ProjetListeFaire')); ?>">
                    <i class="bi bi-calendar-event"></i>
                    <span>Liste des projets à effectuer</span>
                </a>
            </li>
            <!-- Fin Liste des projets à effectuer -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo e(route('ProjetListeValider')); ?>">
                    <i class="bi bi-card-checklist"></i>
                    <span>Liste des projets déjà effectués</span>
                </a>
            </li>
            <!-- Fin Liste des projets déjà effectués -->

            <li class="nav-item">
                <a class="nav-link collapsed"  href="<?php echo e(route('rapportFinalAffiche')); ?>">
                    <i class="bi bi-file-earmark-arrow-up-fill"></i>
                    <span>Sauvegarder un rapport de stage</span>
                </a>
            </li>
            <!-- Fin rapport final -->

            <?php
                // Récupère le rapport de stage final
                $rapportStage = auth()->user()->stagiaire->rapportStage ?? collect();

                // Récupère la première demande
                $rapportStages = $rapportStage->first(); 
            ?>

            <?php if($rapportStages): ?>

                <li class="nav-item">
                    <a class="nav-link collapsed"  href="<?php echo e(route('consulterRapportFinal')); ?>">
                        <i class="bi bi-file-arrow-down-fill"></i>
                        <span>Consulter mon rapport final</span>
                    </a>
                </li>
                <!-- Fin rapport final -->
            <?php endif; ?>
        <?php endif; ?>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo e(route('stagiaire.demandes')); ?>">
                <i class="bi bi-files"></i>
                <span>Mes demandes</span>
            </a>
        </li>
        <!-- Fin Mes demandes -->

        <li class="nav-item">
            <a class="nav-link collapsed"  href="<?php echo e(route('profil.user')); ?>">
                <i class="bi bi-person"></i>
                <span>Profil</span>
            </a>
        </li>
        <!-- Fin Profil -->

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

    </ul>

</aside>
<?php /**PATH C:\laragon\www\stagiaire\resources\views/layouts/stagiaireSidebar.blade.php ENDPATH**/ ?>