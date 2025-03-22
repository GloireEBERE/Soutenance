<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connexion</title>

    <?php echo $__env->make('layouts.favicon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Font Icon -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/material-icon/css/material-design-iconic-font.min.css')); ?>">

    <!-- Main css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
</head>
<body>

    <div class="main">

        <section class="signup">
            <!-- <img src="images/signup-bg.jpg" alt=""> -->
            <div class="container">
                <div class="signup-content">
                    <form action="<?php echo e(route('login.submit')); ?>" method="POST" id="signup-form" class="signup-form">
                        <h2 class="form-title">Se connecter</h2>
                        <?php if(Session::has('message')): ?>
                            <div class="alert alert-info" role="alert"><?php echo e(Session::get('message')); ?></div>
                        <?php endif; ?>
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <input type="email" class="form-input" name="email" id="email" placeholder="Votre adresse mail" required/>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-input" name="mot_de_passe" id="password" placeholder="Votre mot de passe" required/>
                            <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                            <?php $__errorArgs = ['mot_de_passe'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="submit" id="submit" class="form-submit" value="Se connecter"/>
                        </div>
                    </form>
                    <p class="loginhere">
                        Vous n'avez pas de compte ? <a href="<?php echo e(route('inscription.form')); ?>" class="loginhere-link">S'inscrire</a>
                    </p>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="<?php echo e(asset('assets/vendor/jquery/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/main.js')); ?>"></script>

</body>
</html><?php /**PATH C:\laragon\www\stagiaire\resources\views/connexion.blade.php ENDPATH**/ ?>