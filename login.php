<!DOCTYPE HTML>
<html>
	<head>
		<title>Administration Recodage</title>
		
		<!-- bootstrap-3.3.7 -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		
		<!-- JQUERY -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		
		<link href="style/style.css" rel="stylesheet" type="text/css">
		
	</head>
	<body>
		<div class="container">
			<div class="row" align="center">
				<h1>Administration recodage</h1>
			</div>
		</div>
		<div class="wrapper">
			<form class="form-signin" action="" method="post"> 
				<h2 class="form-signin-heading">Connection</h2>
				
				<input type="text" class="form-control" name="username" placeholder="nom d'utilisateur" required="" autofocus="" /><br>
				
				<input type="password" class="form-control" name="password" placeholder="Mot de passe" required=""/>
				<br>
				
				<button class="btn btn-lg btn-primary btn-block" type="submit">Valider</button>   
			</form>
		</div>
	</body>
</html>
<?php
	require 'include/dbconnect.php';
	IF(ISSET($_POST['username'])){
		$login = $_POST['username'];
		$password = $_POST['password'];
		
        $res = $conn->query("SELECT * FROM user_login WHERE id='$login' AND password=md5('$password')");
		IF($res)
		{
			$data = $res->fetch_assoc();	
			session_start();
			$_SESSION['id'] = $data['id'];
			$_SESSION['name'] = $data['full_name'];
			echo "<script language=\"javascript\">document.location.href='index.php';</script>";
			}else{
			echo "<script language=\"javascript\">alert(\"Invalid username or password\");document.location.href='login.php';</script>";
		}
	}
?>
