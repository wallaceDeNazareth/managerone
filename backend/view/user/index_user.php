<?php $title = 'Manager.One'; ?>

<?php ob_start(); ?>
<h1>Liste des User</h1><hr/>

<br/>
<div class="row">
    
    <?php if(isset($_GET['message'])){ ?>
    <div class="col-md-12">
            <div class="alert alert-success" role="alert">
                <strong><?= $_GET['message'] ?></strong>
            </div>
        </div>
    <?php } ?>
    
    <div class="col-md-12">
        <a class="btn btn-success" href="index.php?action=user/addUser">Ajouter un user</a>
    </div>

</div>
<?php $content = ob_get_clean(); ?>

<?php require($_SERVER['DOCUMENT_ROOT'].'/managerone/backend/public/template.php'); ?>

<!--<div class="row">-->

<!--<div col-md-12>


</div>
</div>

<div class="container">
    <br/>
    <div class="row">


        <div class="col-md-12">
            <div class="alert alert-success" role="alert">
                <strong>Well done!</strong> You successfully read this important alert message.
            </div>

        </div>




    </div>
</div>-->