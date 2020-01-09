$(document).ready(function() {
    listUser();

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
                alert('Veuillez remplir les champs !');
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
                affTask(k);
                listUser(); //rafraichir la liste des User

            },
            error: function() {
                alert('Pas de suppression');
                //JSONErrorFun()
            }
        });
    }

    function affTask(k) {
        var nomUser = "";
        var emailUser = "";
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/../managerone/backend/index.php?action=user/getUser&id=' + k,
            success: function(data) {
                if (data.status == 1) {
                    nomUser = data.data.name;
                    emailUser = data.data.email;
                }
            },
            error: function() {
                aler('getUser function not Work ! Try again later');
            }
        });

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
//                alert(data.msg);
                    var tmp = '<label><h4><span class="badge badge-warning">Pas de Tâche pour l\'user ' + nomUser + '(email: ' + emailUser + ')</span></h4></label>';
                    $('#datatask').html(tmp);
                }

            },
            error: function() {
                var tmp = '<label class="label">Pas de Tâche l\'user ' + nomUser + '(email: ' + emailUser + ') pour cet utilisateur<span></span></label>';
                $('#datatask').html(tmp);
//            alert('Error pas de valeurs renvoyé');
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
});
