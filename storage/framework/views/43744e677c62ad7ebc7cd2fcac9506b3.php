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
                        
                        <li class="breadcrumb-item active">Consulter les rapports</li>
                    </ol>
                </nav>
            </div>
            <!-- End Page Title -->

            <div class="container">
                <h2 class="text-center">Les rapports de stage</h2>
                <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>
            </div>

            <div>
                <?php if($rapports->isEmpty()): ?>
                    <p class="text-center text-danger">Aucun rapport de stage n'a été trouvé.</p>
                <?php else: ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom du Stagiaire</th>
                                <th>Email</th>
                                <th>Thème du Rapport</th>
                                <th>Date de Soumission</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $rapports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $rapport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($index + 1); ?></td>
                                    <td><?php echo e($rapport->stagiaire->user->nom); ?></td>
                                    <td><?php echo e($rapport->stagiaire->user->email); ?></td>
                                    <td><?php echo e($rapport->theme_rapport); ?></td>
                                    <td><?php echo e($rapport->date_soumission); ?></td>
                                    <td>
                                        <a href="<?php echo e(asset($rapport->document_rapport)); ?>" class="btn btn-primary btn-sm" target="_blank">
                                            <i class="bi bi-eye"></i> Lire
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php endif; ?>

            </div>
        </main>

        <!-- Vendor JS Files -->
        <?php echo $__env->make('layouts.vendorJs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Template Main JS File -->
        <script src="<?php echo e(asset('assets/admin/js/main.js')); ?>"></script>
    </body>
</html><?php /**PATH C:\laragon\www\stagiaire\resources\views/admin/consulterRapport.blade.php ENDPATH**/ ?>