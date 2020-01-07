<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <input type="hidden" id="inpHidd" name="inpHid">

        <div id="detail">

        </div>

        <div id="taskList">

        </div>

    </body>
</html>
<script src= "jquery/dist/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var idHidd = $('#inpHidd').val();

        $.ajax({
            type: "GET",
            url: '/../managerone/backend/index.php?action=user/getUser' + '&id=' + idHidd,
            dataType: "json",
            success: function(data) {
                // do somethings

                var aff = "";

                if (data.status == 1) {
                    aff += '<label>Nom : ' + data.data.name + '</label><br/>';
                    aff += '<label>Email : ' + data.data.email + '</label><hr/>';
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
    });
</script>

