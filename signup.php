<?php
session_start();
IF(ISSET($_SESSION['id'])&& $_SESSION['id']=='u400274'){
    require 'include/dbconnect.php';

    //set validation error flag as false
    $error = false;

    //check if form is submitted
    if (isset($_POST['signup'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
        if($password != $cpassword) {
            $error = true;
            $cpassword_error = "Password and Confirm Password doesn't match";
        }
        if(mysqli_query($conn, "INSERT INTO user_login(id,full_name,password) VALUES('" . $id . "', '" . $full_name . "', '" . md5($password) . "')")) {
            $successmsg = "Utilisateur créé avec succès !";
        } else {
            $errormsg = "Erreur dans la création de l'utilisateur !";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Création d'un utilisateur</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" >
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<body>
		<div class="container">
			<div class="row" align="center">
				<h1>Nouvel utilisateur</h1>
			</div>
		</div>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 well">
            <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform">
                <fieldset>
                    <legend>Enregistrement</legend>

                    <div class="form-group">
                        <label for="name">Nom d'utilisateur</label>
                        <input type="text" name="id" placeholder="nom d'utilisateur" required value="" class="form-control" />
                    </div>

                    <div class="form-group">
                        <label for="name">Nom complet</label>
                        <input type="text" name="full_name" placeholder="Nom complet" required value="" class="form-control" />
                    </div>

                    <div class="form-group">
                        <label for="name">Mot de passe</label>
                        <input type="password" name="password"  required class="form-control" />
                    </div>

                    <div class="form-group">
                        <label for="name">Confirmation du mot de passe</label>
                        <input type="password" name="cpassword" placeholder="" required class="form-control" />
   <span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="signup" value="Valider" class="btn btn-primary" />
                    </div>
                </fieldset>
            </form>
            <span class="text-success"><?php if (isset($successmsg)) { echo $successmsg; } ?></span>
            <span class="text-danger"><?php if (isset($errormsg)) { echo $errormsg; } ?></span>
        </div>
    </div>
</div>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
</body>
</html>
<?php 
}else{
    echo "<script language=\"javascript\">alert(\"Please login\");document.location.href='login.php';</script>"; 
}
?>
