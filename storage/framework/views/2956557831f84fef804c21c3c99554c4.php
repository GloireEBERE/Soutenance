<div class="search-results">
    <h2>Résultats de la recherche : "<?php echo e($query); ?>"</h2>

    <h3>Stagiaires</h3>
    <?php $__currentLoopData = $stagiaires; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stagiaire): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <p><?php echo e($stagiaire->nom); ?> <?php echo e($stagiaire->prenom); ?> (<?php echo e($stagiaire->email); ?>)</p>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <h3>Projets</h3>
    <?php $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <p><?php echo e($projet->titre_projet); ?> - <?php echo e($projet->statut); ?></p>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <h3>Tâches</h3>
    <?php $__currentLoopData = $taches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tache): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <p><?php echo e($tache->nom); ?> : <?php echo e($tache->description); ?></p>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <h3>Rapports</h3>
    <?php $__currentLoopData = $rapports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rapport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <p><?php echo e($rapport->theme_rapport); ?> - <a href="<?php echo e(asset('storage/' . $rapport->document_rapport)); ?>">Voir le rapport</a></p>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php echo e($stagiaires->links()); ?>

    <?php echo e($projets->links()); ?>

    <?php echo e($taches->links()); ?>

    <?php echo e($rapports->links()); ?>

</div>
<?php /**PATH C:\laragon\www\stagiaire\resources\views/tuteur/resultat.blade.php ENDPATH**/ ?>