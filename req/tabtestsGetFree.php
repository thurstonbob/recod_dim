<?
	header('Content-type: application/json');
	require '../include/dbconnect.php';
	$sql = "select r.idhosp,r.idrss,r.duree,r.severite,r.libelle, date_ins from rss_tas r where idtim is null order by date_ins desc";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		//    output data of each row
		$arrVal = array();
		while($row = $result->fetch_array()) {
			$name = array(
            'idhosp' => "<a href='http://web100tprd.chu-nancy.fr/mwsiissrv.dll/hal/pmsi/dossierpmsi/browser/dossierResume?resume=".$row[1]."' target='_blank'>". $row[0]. "</a>",
            'duree' => $row[2],
            'severite' =>$row[3],
            'libelle' =>$row[4],
            'date_ins' =>$row[5]
			);      
			array_push($arrVal, $name);
		}
		echo  json_encode($arrVal);
	}
	mysqli_close($conn);
?>
