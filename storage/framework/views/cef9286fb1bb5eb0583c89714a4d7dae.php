<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=7">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">


        <?php echo $__env->make('layouts.favicon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.min.js"></script>

        <!-- Google Fonts -->
        <link href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="<?php echo e(asset('assets/admin/vendor/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('assets/admin/vendor/bootstrap-icons/bootstrap-icons.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('assets/admin/vendor/boxicons/css/boxicons.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('assets/admin/vendor/quill/quill.snow.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('assets/admin/vendor/quill/quill.bubble.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('assets/admin/vendor/remixicon/remixicon.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('assets/admin/vendor/simple-datatables/style.css')); ?>" rel="stylesheet">

        <!-- Template Main CSS File -->
        <link href="<?php echo e(asset('assets/admin/css/style.css')); ?>" rel="stylesheet">
    </head>

    <body>

        <!-- ======= Header ======= -->
        <?php echo $__env->make('layouts.welheade', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- End Header -->

        <!-- ======= Sidebar ======= -->
        <?php echo $__env->make('layouts.stagiaireSidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- End Sidebar-->

        <main id="main" class="main">

            <div class="pagetitle">
                <h1>Tableau de bord</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(route('welcome')); ?>">Accueil</a>
                        </li>

                        <li class="breadcrumb-item">Stagiaire</li>
                        
                        <li class="breadcrumb-item active">Liste des projets à effectuer</li>
                    </ol>
                </nav>
            </div>
            <!-- End Page Title -->

            <div class="container">
                <h2 class="text-center">La liste des projets à effectuer</h2>

                <?php if(Session::has('message')): ?>
                    <div class="alert alert-info" role="alert"><?php echo e(Session::get('message')); ?></div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="alert alert-danger">
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>

                            <th>Titre</th>

                            <th>Date de début</th>

                            <th>Détail</th>

                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($index + 1); ?> </td>

                                <td><?php echo e($projet->titre_projet); ?></td>

                                <td><?php echo e(\Carbon\Carbon::parse($projet->date_debut)->format('d/m/Y')); ?></td>

                                <td>
                                    <a href="<?php echo e(route('voirProjetStagiaire', $projet->id)); ?>" target="_blank" class="btn btn-primary">Voir</a>
                                </td>

                                <td>
                                    <?php if(isset($projet->id)): ?>
                                        <form action="<?php echo e(route('stagiaire.updateProjet', ['id' => $projet->id])); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" name="statut" value="terminé" class="btn btn-success" aria-label="Marquer la tâche comme terminée">Terminé</button>
                                            <button type="submit" name="statut" value="annulé" class="btn btn-danger" aria-label="Marquer la tâche comme annulée">Annulé</button>
                                        </form>
                                    <?php else: ?>
                                        <p>Erreur : Impossible de trouver l'ID de la tâche.</p>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center">Aucune tâche pour le moment.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>

        <!-- Vendor JS Files -->
        <?php echo $__env->make('layouts.vendorJs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Template Main JS File -->
        <script src="<?php echo e(asset('assets/admin/js/main.js')); ?>"></script>
    </body>
</html><?php /**PATH C:\laragon\www\stagiaire\resources\views/stagiaire/ProjetListeFaire.blade.php ENDPATH**/ ?>