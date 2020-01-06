<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>FrontEnd Manager One</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>-->

<!--<script src= "main.js" type="text/javascript"></script>-->
    </head>
    <body class="container">
        <br/>

		
		<div class="row"><label id="1p">Remplissez le formulaire pour ajouter un Utilisateur</label></div>
        <div class="row">
            
            <div class="col-md-3"><input type="text" name="nom" id="nom" placeholder="entrez le nom" class="form-control"></div>
            <div class="col-md-3"><input type="email" name="email" id="email" placeholder="entrez l'email" class="form-control"></div>
            <div class="col-md-3"><input type="button" value="valider" name="btn" id="btn" class="btn btn-primary"></div>
        </div><hr/>
	
	
		<div class="row"><label id="2p">Remplissez le formulaire pour ajouter une Task</label></div>
        <div id="tb" class="row">                      
           
                <!-- Ajouter une Task -->
                
                <div class="col-md-2"><input type="text" name="title" id="title" placeholder="entrez le title" class="form-control"></div>
                <div class="col-md-2"><input type="text" name="descp" id="descp" placeholder="entrez la description" class="form-control"></div>
                <div class="col-md-2"><input type="date" name="creation_date" id="creation_date" placeholder="entrez la date" class="form-control"></div>
                <div class="col-md-2"><input type="text" name="status" id="status" placeholder="entrez le status" class="form-control"></div>
                <div class="col-md-2">
                    <input type="number" name="user_id" id="user_id" placeholder="entrez user_id" class="form-control">
<!--                    <select name="user_id" id="user_id">
                        <option value="">Select User</option>
                        <option value="saab">Saab</option>
                        <option value="mercedes">Mercedes</option>
                        <option value="audi">Audi</option>
                    </select> -->
                </div>
                <div class="col-md-2"><input type="button" value="Creer la tache" name="btnTask" id="btnTask" class="btn btn-info"></div>
            
        </div><hr/>
		
		<div class="row">
		<div class="col-md-3">
                <input type="button" value="Charger les Users" name="btnList" id="btnList" class="btn btn-success">
            </div>
		</div>
		
        <hr/>
        <div class="row">
            <div id="datatab" class="col-md-7"> <!--  style="display: none; float: left;" -->
                <!-- Liste des Users -->
            </div>

            <div id="datatask" class="col-md-5">
                <!-- Liste des task pour un User -->
            </div> <!--  style="display: none; float: right;" -->



        </div>

        <div></div>

    </body>
</html>
<script src= "jquery/dist/jquery.js" type="text/javascript"></script>
<script src= "main.js" type="text/javascript"></script>

<script type="text/javascript">

    $(document).ready(function() {
        listUser();
    });

    $('#btnTask').click(function() {
        var title = $('#title').val();
        var description = $('#descp').val();
        var creation_date = $('#creation_date').val();
        var status = $('#status').val();
        var user_id = $('#user_id').val();
        $.ajax({
            type: "GET",
            url: '/../managerone/backend/index.php?action=task/addTask&title=' + title + '&description=' + description + '&creation_date=' + creation_date + '&status=' + status + '&user_id=' + user_id,
            dataType: "json",
            success: function(data) {
                // do somethings
                affTask(user_id);
                alert("Task ajouté avec succes");
            },
            error: function() {
                affTask(user_id);
                alert('Er d\'ajout de task !');
                //JSONErrorFun()
            }
        });
    });

    $('#btn').click(function() {
        var name = $('#nom').val();
        var email = $('#email').val();

        $.ajax({
            type: "GET",
            url: '/../managerone/backend/index.php?action=user/addUser' + '&name=' + name + '&email=' + email,
            dataType: "json",
            success: function(data) {
                // do somethings
                if (data.status == 1) {
                    listUser();
                    alert(data.msg);
                } else {
                    alert(data.msg);
                }


            },
            error: function() {
                alert('Error Nok');
                //JSONErrorFun()
            }
        });
    });


    $('#btnList').click(function() {
        listUser();
    });

    function listUser() {
        $.ajax({
            type: "GET",
            url: '/../managerone/backend/index.php?action=user/listUser',
            dataType: "json",
            success: function(data) {
                // do somethings

                if (data.status == 1) {
                    var taille = data.data.length;
                    if (taille > 0) {
                        // fabrication d tablau html
                        var entete = '<table class="table table-condensed table-hover table-striped">';
                        entete += "<tr><th>#</th>";
                        entete += "<th>Nom</th>";
                        entete += "<th>Email</th>";
                        entete += "<th>Action</th></tr>";


                        for (i = 0; i < taille; i++) {
                            entete += "<tr><td>" + data.data[i].id + "</td>";
                            entete += "<td>" + data.data[i].name + "</td>";
                            entete += "<td>" + data.data[i].email + "</td>";
                            entete += '<td><button href="#" onClick="affTask(' + data.data[i].id + ')">Afficher les tâches</button>';
                            entete += '<button href="#" onClick="deleteUser(' + data.data[i].id + ')">Supprimer User</button></td></tr>';
                        }
                        entete += "</table>";

                        $('#datatab').html(entete);

                    } else {
                        alert("Tab vide");
                    }
                } else {
                    alert(data.msg);
                }

            },
            error: function() {
                alert('Error pas de valeurs renvoyé');
                //JSONErrorFun()
            }
        });
    }
    function deleteUser(k) {
        $.ajax({
            type: "GET",
            url: '/../managerone/backend/index.php?action=user/deleteUser' + '&id=' + k,
            dataType: "json",
            success: function(data) {
                // do somethings
                if (data.status == 1) {
                    alert(data.msg);
                } else {
                    alert(data.msg);
                }

                listUser(); //rafraichir la liste des User

            },
            error: function() {
                alert('Pas de suppression');
                //JSONErrorFun()
            }
        });
    }

    function affTask(k) {
        $.ajax({
            type: "GET",
            url: '/../managerone/backend/index.php?action=user/getTasks&id=' + k,
            dataType: "json",
            success: function(data) {
                // do somethings

                if (data.status == 1) {
                    var taille = data.data.length;
                    if (taille > 0) {
                        // fabrication d tablau html
                        var entete = '<table class="table table-condensed table-hover table-striped">';
                        entete += "<tr><th>ID Task</th>";
                        entete += "<th>Title</th>";
                        entete += "<th>Description</th>";
                        entete += "<th>Date de Creation</th>";
                        entete += "<th>Status</th><th>action</th></tr>";


                        for (i = 0; i < taille; i++) {
                            entete += "<tr><td>" + data.data[i].id + "</td>";
                            entete += "<td>" + data.data[i].title + "</td>";
                            entete += "<td>" + data.data[i].description + "</td>";
                            entete += "<td>" + data.data[i].creation_date + "</td>";
                            entete += "<td>" + data.data[i].status + "</td>";
                            entete += '<td><button href="#" onClick="deleteTask(' + data.data[i].id + ',' + data.data[i].user_id + ')">Delete</button></td></tr>';
                        }
                        entete += "</table>";

                        $('#datatask').html(entete);

                    } else {
                        alert("Tab vide");
                    }
                } else {
                    alert(data.msg);
                }

            },
            error: function() {
                alert('Error pas de valeurs renvoyé');
                //JSONErrorFun()
            }
        });
    }

    function deleteTask(k, i) {
        $.ajax({
            type: "GET",
            url: '/../managerone/backend/index.php?action=task/deleteTask' + '&id=' + k,
            dataType: "json",
            success: function(data) {
                // do somethings
                if (data.status == 1) {
                    affTask(i);
                    alert(data.msg);
                } else {
                    alert(data.msg);
                }
                

            },
            error: function() {
                
                alert('Pas de suppression');
                //JSONErrorFun()
            }
        });
    }
</script>

