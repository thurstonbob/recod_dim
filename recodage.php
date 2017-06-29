<!DOCTYPE html>
<?php
include '../sitedim/foruser.php';
?>
<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
                <meta charset="utf-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title> 
                        Recodage
                </title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
                <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<script type="text/javascript">
$(document).ready(function (e) {
        $(document).on('submit', 'form', function(e) {
        e.preventDefault();
        var $btn = $('#recbutton').button('loading');
        console.log($(this).closest("form").attr('id'));
        var form_data = $(this).serialize();
        console.log(form_data);
        var form_url = $(this).attr("action");
        console.log(form_url);
        var form_method = $(this).attr("method").toUpperCase();
        console.log(form_method);
        $.ajax({
            url: form_url,
                type: form_method,
                data: form_data,//data: "name=" + name + "&email=" + email + "&message=" + message,
                cache: false,
                success: function (returnhtml) {
                    $btn.button('reset');
                    $('#result').html(returnhtml);
                },
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError);
			}
        });
    });
});
</script>
        </head>

        <body>
<? 
if($user->id == 0){echo "<h2>Problème de connexion, vous devez vous reconnecter :</h2><a href='https://livenne.chu-nancy.fr/sitedim/'>--> SiteDIM</a>";}else{

echo '<pre>Bonjour ' . $user->get('name') . '</pre>';
?>
                <div class="container">
                        <div class="row">				
                                <h1 class="display-2">S&eacute;jour &agrave; recoder</h1>
                                <div id="result">
                                        <form method="post" action="recupd.php" role="form" name="recform" id="recform" ajax="true">
                                                <button type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i>&nbsp;Chargement..." class="btn btn-primary btn-lg btn-block" id="recbutton">Demander un s&eacute;jour &agrave; recoder</button>
                                        </form>
                                </div><!--result-->

                        </div><!--row-->
                </div><!--container-->
<?
}
?>
        </body>
</html>
