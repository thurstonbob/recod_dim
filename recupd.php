<?php
	include '../sitedim/foruser.php';
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
		$sql_sel = "SELECT r.idhosp,r.idrss,r.duree,r.severite, r.libelle FROM rss_tas_asup r WHERE idtim IS NULL and date_pec IS NULL ORDER BY date_ins DESC,severite ASC,duree DESC LIMIT 1";
		// Escape user inputs for security
		$result1=$conn->query($sql_sel) ;
		if ( !$result1 ) {
			$result1->free();
			throw new Exception($conn->error);
		}
		
		if ($result1->num_rows > 0) {
			//    output data of each row
			while($row = $result1->fetch_array()) {
				$rec_user = $user->get('username');
				
				$sql_upd = "update rss_tas_asup set idtim='".$rec_user."',date_pec=NOW() where idhosp='".$row[0]."';";
				$result2=$conn->query($sql_upd);
				if ( !$result2 ) {
					$result2->free();
					throw new Exception($conn->error);
				}
				$conn->commit();
				$conn->autocommit(TRUE);
				
			?>
			<form method="post" action="recupd.php" role="form" name="recupdform" id="recupdform" ajax="true">
				<div class="form-group">
					<label for="idhosplab">N° IEP</label>
					<label class="form-control" id="idhospbtn"  ><a id="sejlink" href='http://web100tprd.chu-nancy.fr/mwsiissrv.dll/hal/pmsi/dossierpmsi/browser/dossierResume?resume=<? echo $row[1] ?>' target='_blank'><? echo $row[0] ?></a>
					</div>
					<div class="form-group">
						<label for="iddurlab">Dur&eacute;e</label>
						
						<label class="form-control" id="duree" ><? echo $row[2] ?> </label>
					</div>
					<div class="form-group">
						<label for="idsevlab">S&eacute;v&eacute;rit&eacute;</label>
						
						<label class="form-control" id="severite" ><? echo $row[3] ?></label>
					</div>
					<div class="form-group">
						<label for="idliblab">Libell&eacute;</label>
					<br>	
						<textarea readonly rows="3" id="libelle" class="form-control" ><? echo str_replace("</br>","\n",$row[4]) ?></textarea>
					</div>
					<button type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i>&nbsp;Chargement..." class="btn btn-primary btn-lg btn-block" id="recbutton">Demander un autre s&eacute;jour</button>
				</form>
				<form method="post" action="recdel.php" class="recdelc" role="form" name="recdelform" id="recdelform" ajax="true">
					<div class="form-group">
                        <input type="hidden" name="idhosp" id="idhosp" value="<?echo $row[0]?>">
					</div>
					<button type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i>&nbsp;Chargement..." class="btn btn-danger btn-lg btn-block" id="recbutton">Annuler l'attribution</button>
				</form>
				<?        }
				} else {
				echo "Pas de s&eacute;jour &agrave; recoder";
			}
			}catch ( Exception $e ) {
			// before rolling back the transaction, you'd want
			// to make sure that the exception was db-related
			$conn->rollback(); 
			$conn->autocommit(TRUE); // i.e., end transaction   
		}
		$conn->close();
	?>
	<script>
	$(document).ready(function() {
    $("#sejlink").click(function() {
	$( ".recdelc" ).remove();
        //Do stuff when clicked
    });
});
	</script>
