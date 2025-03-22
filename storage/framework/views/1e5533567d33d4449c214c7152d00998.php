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
                        
                        <li class="breadcrumb-item active">Mon rapport de stage final</li>
                    </ol>
                </nav>
            </div>
            <!-- End Page Title -->

            <div class="container">
                <h2 class="text-center">Mon rapport de stage final</h2>

                <?php if(Session::has('message')): ?>
                    <div class="alert alert-info" role="alert"><?php echo e(Session::get('message')); ?></div>
                <?php endif; ?>
            </div>

            <div>
                <div class="card mt-4">
                    <div class="card-body">
                        <?php if($rapportFinal): ?>
                            <h4>Thème du rapport : <?php echo e($rapportFinal->theme_rapport); ?></h4>
                            <p>Date de soumission : <b><?php echo e($rapportFinal->date_soumission); ?></b></p>
                            <a href="<?php echo e(asset($rapportFinal->document_rapport)); ?>" class="btn btn-primary" download>Télécharger le rapport</a>
                        <?php else: ?>
                            <p class="text-danger">Aucun rapport de stage final disponible.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>

        <!-- Vendor JS Files -->
        <?php echo $__env->make('layouts.vendorJs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Template Main JS File -->
        <script src="<?php echo e(asset('assets/admin/js/main.js')); ?>"></script>
    </body>
</html><?php /**PATH C:\laragon\www\stagiaire\resources\views/stagiaire/consulterRapportFinal.blade.php ENDPATH**/ ?>