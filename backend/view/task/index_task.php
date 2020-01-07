<?php $title = 'Manager.One'; ?>

<?php ob_start(); ?>
<h1>Liste des Task</h1><hr/>


<div class="jumbotron">
    <h1 class="display-4">Main Task Page</h1>
    <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
    <p class="lead">
        <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
    </p>
</div>




<?php $content = ob_get_clean(); ?>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/managerone/public/template.php'); ?>