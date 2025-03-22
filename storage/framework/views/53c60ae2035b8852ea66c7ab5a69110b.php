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
                        
                        <li class="breadcrumb-item active">Affectation des stagiaires</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->
            

            <div class="container">
                <h2 class="text-center">La liste des affectations des stagiaires</h2>
                <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>
            </div>

            <div class="table-responsive ">
                <table class="table table-hover">
                    <thead class="table-primary">
                        <th>#</th>

                        <th>Nom</th>

                        <th>Prénom</th>

                        <th>Email</th>

                        <th>Tuteur</th>

                        <th>Action</th>

                    </thead>
                    
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $stagiaires; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $stagiaire): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>

                                <td><?php echo e($stagiaire->user->nom); ?></td>

                                <td><?php echo e($stagiaire->user->prenom); ?></td>

                                <td><?php echo e($stagiaire->user->email); ?></td>

                                <td>
                                    <?php if(is_null($stagiaire->tuteur_id)): ?> 
                                        <span class="text-danger">Non affecté</span>
                                    <?php else: ?>
                                        <span class="text-success">
                                            <?php echo e($stagiaire->tuteur->user->nom ?? 'Tuteur inconnu'); ?> <?php echo e($stagiaire->tuteur->user->prenom ?? ''); ?>

                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if(is_null($stagiaire->tuteur_id)): ?>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#assignModal" data-stagiaire-id="<?php echo e($stagiaire->id); ?>">
                                            Affecter
                                        </button>
                                    <?php else: ?>
                                        <span class="text-secondary">Déjà affecté(e)</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">Aucun enregistrement trouvé !</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    
                </table>

                <!-- Modale d'Affectation -->
                <div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="<?php echo e(route('affectation.assign', ':stagiaire_id')); ?>" id="assignForm">
                                <?php echo csrf_field(); ?>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="assignModalLabel">Affecter un Tuteur</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                
                                <div class="modal-body">
                                    <label for="tuteur">Choisissez un tuteur :</label>
                                    <select name="tuteur_id" id="tuteur" class="form-select" required>
                                        <?php $__currentLoopData = $tuteurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tuteur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($tuteur->id); ?>">
                                                <?php echo e($tuteur->user->nom); ?> <?php echo e($tuteur->user->prenom); ?> : (<?php echo e($tuteur->stagiaires_count ?? 'aucun'); ?> stagiaire(s))
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Affecter</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Vendor JS Files -->
        <?php echo $__env->make('layouts.vendorJs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Template Main JS File -->
        <script src="<?php echo e(asset('assets/admin/js/main.js')); ?>"></script>

        <script>
            const assignForm = document.getElementById('assignForm');
            const assignModal = document.getElementById('assignModal');

            assignModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const stagiaireId = button.getAttribute('data-stagiaire-id');
                assignForm.action = assignForm.action.replace(':stagiaire_id', stagiaireId);
            });
        </script>
    </body>
</html><?php /**PATH C:\laragon\www\stagiaire\resources\views/admin/affectation.blade.php ENDPATH**/ ?>