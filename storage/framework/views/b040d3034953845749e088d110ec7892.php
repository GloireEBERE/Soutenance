<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="description">
        <meta content="" name="keywords">

        <?php echo $__env->make('layouts.favicon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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

        <!-- =======================================================
        * Template Name: NiceAdmin
        * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
        * Updated: Apr 20 2024 with Bootstrap v5.3.3
        * Author: BootstrapMade.com
        * License: https://bootstrapmade.com/license/
        ======================================================== -->
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
                        
                        <li class="breadcrumb-item active">Tableau de bord</li>
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

            <section class="section dashboard">
                <div class="row">

                    <!-- Left side columns -->
                    <div class="container">
                        <div class="row">

                            <!-- Stagiaire refusé Card -->
                            <div class="col-xxl-4 col-md-6">
                                <div class="card info-card sales-card">

                                    <div class="filter">
                                        <a class="icon" href="<?php echo e(route('refuser')); ?>" data-bs-toggle="dropdown">
                                            <i class="bi bi-person-dash"></i>
                                        </a>
                                    </div>

                                    <div class="card-body">
                                        <h5 class="card-title">Stagiaire refusé</span></h5>

                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-person-fill-slash"></i>
                                            </div>

                                            <div class="ps-3">
                                                <?php if(isset($stagiairesRefuses)): ?>
                                                    <h6><?php echo e($stagiairesRefuses > 0 ? $stagiairesRefuses : 'Aucun stagiaire refusé'); ?></h6>
                                                <?php else: ?>
                                                    <h6>Information non disponible</h6>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- End Stagiaire refusé Card -->

                            <!-- Stagiaire accepté Card -->
                            <div class="col-xxl-4 col-md-6">
                                <div class="card info-card revenue-card">

                                    <div class="filter">
                                        <a class="icon" href="<?php echo e(route('valider')); ?>" data-bs-toggle="dropdown">
                                            <i class="bi bi-person-check"></i>
                                        </a>

                                    </div>

                                    <div class="card-body">
                                        <h5 class="card-title">Stagiaire accepté</span></h5>

                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-person-check"></i>
                                            </div>

                                            <div class="ps-3">
                                                <?php if(isset($stagiairesAcceptes)): ?>
                                                    <h6><?php echo e($stagiairesAcceptes > 0 ? $stagiairesAcceptes : 'Aucun stagiaire accepté'); ?></h6>
                                                <?php else: ?>
                                                    <h6>Information non disponible</h6>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- End Stagiaire accepté Card -->

                            <!-- Tuteur Card -->
                            <div class="col-xxl-4 col-md-6">

                                <div class="card info-card customers-card">

                                    <div class="filter">
                                        <a class="icon" href="#" data-bs-toggle="dropdown">
                                            <i class="bi bi-person-circle"></i>
                                        </a>
                                    </div>

                                    <div class="card-body">
                                        <h5 class="card-title">Tuteur</span></h5>

                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-person-circle"></i>
                                            </div>

                                            <div class="ps-3">
                                                <?php if(isset($tuteurs)): ?>
                                                    <h6><?php echo e($tuteurs > 0 ? $tuteurs : 'Aucun tuteur enregistré.'); ?></h6>
                                                <?php else: ?>
                                                    <h6>Information non disponible</h6>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <!-- End Tuteur Card -->

                            <!-- Administrateur Card -->
                            <div class="col-xxl-4 col-md-6">

                                <div class="card info-card customers-card">

                                    <div class="filter">
                                        <a class="icon" href="#" data-bs-toggle="dropdown">
                                            <i class="bi bi-person-fill-gear"></i>
                                        </a>
                                    </div>

                                    <div class="card-body">
                                        <h5 class="card-title">Administrateur</span></h5>

                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-person-fill-gear"></i>
                                            </div>

                                            <div class="ps-3">
                                                <?php if(isset($admins)): ?>
                                                    <h6><?php echo e($admins > 0 ? $admins : 'Aucun administrateur enregistré.'); ?></h6>
                                                <?php else: ?>
                                                    <h6>Information non disponible</h6>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <!-- End Administrateur Card -->

                        </div>
                    </div><!-- End Left side columns -->

                </div>
            </section>

        </main><!-- End #main --> 

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Vendor JS Files -->
    <?php echo $__env->make('layouts.vendorJs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Template Main JS File -->
    <script src="<?php echo e(asset('assets/admin/js/main.js')); ?>"></script>

    </body>

</html><?php /**PATH C:\laragon\www\stagiaire\resources\views/admin/index.blade.php ENDPATH**/ ?>