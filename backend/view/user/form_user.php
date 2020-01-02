<?php $title = 'Ajouter un User'; ?>

<?php ob_start(); ?>

<h3>Ajout d'un nouvel user</h3><hr/>
<div class="row">

    <div class="col-md-6">
        <form method="post" action="index.php?action=user/addUser">
            <div class="form-group">
                <label for="name">Nom de l'utilisateur</label>
                <input type="name" name="nom" class="form-control" id="name" placeholder="Entrez le nom de l'utilisateur" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="mail" class="form-control" id="email" placeholder="Entrez l'email" required>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="btnVl" id="btnVal">
            </div>
        </form>
    </div>    
</div>


<?php $content = ob_get_clean(); ?>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/managerone/public/template.php'); ?>
