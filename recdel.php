<?php
	if(isset($_POST["idhosp"])){
		$idhosp=$_POST['idhosp'];
		
		$servername = "livenne";
		$username = "u400274";
		$password = "drap26drwz";
		$dbname = "tas";
		
		
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$conn->query('SET NAMES utf8');
		
		try{
			$conn->autocommit(FALSE); // i.e., start transaction
			$sql_del = "update rss_tas set idtim=NULL,date_pec=NULL where idhosp='".$idhosp."';";
			// Escape user inputs for security
			$result1=$conn->query($sql_del) ;
			if ( !$result1 ) {
				$result1->free();
				throw new Exception($conn->error);
			}
			
			$conn->commit();
			$conn->autocommit(TRUE);
			
?>
    <P class="lead">Annulation de l'attribution du s&eacute;jour <? echo $idhosp ?></p>
					<form method="post" action="recupd.php" role="form" name="recform" id="recform" ajax="true">
						<button type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i>&nbsp;Chargement..." class="btn btn-primary btn-lg btn-block" id="recbutton">Demander un s&eacute;jour &agrave; recoder</button>
					</form>
		<?       
			}catch ( Exception $e ) {
			// before rolling back the transaction, you'd want
			// to make sure that the exception was db-related
			$conn->rollback(); 
			$conn->autocommit(TRUE); // i.e., end transaction   
		}
		$conn->close();
	}else{echo "Erreur : pas de idhosp";}
?>
