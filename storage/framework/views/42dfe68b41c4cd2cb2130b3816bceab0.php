<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=7">

        <?php echo $__env->make('layouts.favicon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
        
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
        <?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- End Header -->

        <!-- ======= Sidebar ======= -->
        <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- End Sidebar-->

        <main id="main" class="main">

            <div class="pagetitle">
                <h1>Tableau de bord</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(route('welcome')); ?>">Accueil</a>
                        </li>

                        <li class="breadcrumb-item">Admin</li>
                        
                        <li class="breadcrumb-item active">Demande de stage</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->
            

            <div class="container">
                <h2 class="text-center">Les demandes de stage</h2>
                <?php if(session('success')): ?>
                    <p style="color: green;"><?php echo e(session('success')); ?></p>
                <?php endif; ?>
            </div>

            <div class="table-responsive">

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom du Stagiaire</th>
                            <th>CV</th>
                            <th>Lettre</th>
                            <th>Date de Soumission</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__currentLoopData = $demandes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $demande): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td><?php echo e($demande->stagiaire->user->nom); ?> <?php echo e($demande->stagiaire->user->prenom); ?></td>
                                <td><a href="<?php echo e(asset($demande->cv)); ?>" target="_blank" class="btn btn-primary">Voir CV</a></td>
                                <td><a href="<?php echo e(asset($demande->lettre_de_demande)); ?>" target="_blank" class="btn btn-secondary">Voir Lettre</a></td>
                                <td><?php echo e($demande->date_soumission); ?></td>
                                <td>
                                    <form action="<?php echo e(route('recevoirDemandeUpdate', $demande->id)); ?>" method="POST" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <input type="hidden" name="statut" value="acceptée">
                                        <button class="btn btn-success btn-sm">Accepter</button>
                                    </form>

                                    <form action="<?php echo e(route('recevoirDemandeUpdate', $demande->id)); ?>" method="POST" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <input type="hidden" name="statut" value="refusée">
                                        <button class="btn btn-danger btn-sm">Refuser</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>



        </main>

        <!-- Vendor JS Files -->
        <?php echo $__env->make('layouts.vendorJs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Template Main JS File -->
        <script src="<?php echo e(asset('assets/admin/js/main.js')); ?>"></script>
    </body>
</html><?php /**PATH C:\laragon\www\stagiaire\resources\views/admin/recevoirDemande.blade.php ENDPATH**/ ?>