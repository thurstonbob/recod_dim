<?
	header('Content-type: application/json');
	require '../include/dbconnect.php';
	$cv="";
	$test_cv="";
	if(isset($_GET["cv"])) 
	{  
		$cv=implode(",",$_GET["cv"]);
		$test_cv= " and right(ghm,1) in (".$cv.")";
	}
	$sql = "select t.idrss,t.idhosp,count(distinct left(idtest,5)) as nbtest, group_concat(distinct concat(left(idtest,5),'-',d.libelle) separator '</br>')as lestests
    ,r2.duree_rss,concat(cmd,ghm) as ghm ,g.ghs_lib,v.valoGHS,if(tt.idrss is null,0,1) as present,right(ghm,1)
    from pmsi_dim.rdsR02 r2
    left join tas.tests t on finess='540023264' and t.idrss=r2.idrss
    left join tas.test_desc d using (idtest)
    left join tas.rss_tas_test tt on r2.idrss=tt.idrss
    left join pmsi_dim.valoPP v on r2.finess=v.finess and t.idrss =v.idrss and t.idhosp=t.idhosp
    left join pmsi_dim_nom.tarifs_v2 g on r2.ghs=g.ghs_nro and g.date_effet=if(mois_sortie<3,'2016-03-01','2017-03-01')
    where 1
    and idtest not like '%das'".$test_cv."
    group by t.idrss
    having nbtest>1
    union distinct
    select t.idrss,t.idhosp,count(distinct left(idtest,5)) as nbtest, group_concat(distinct concat(left(idtest,5),'-',d.libelle) separator '</br>')as lestests
    ,r3.duree_rss,concat(cmd,ghm) as ghm ,g.ghs_lib,v.valoGHS,if(tt.idrss is null,0,1) as present,right(ghm,1)
    from pmsi_dim.rdsR03 r3
    left join tas.tests t on finess='540023264' and t.idrss=r3.idrss
    left join tas.test_desc d using (idtest)
    left join tas.rss_tas_test tt on r3.idrss=tt.idrss
    left join pmsi_dim.valoPP v on r3.finess=v.finess and t.idrss =v.idrss and t.idhosp=t.idhosp
    left join pmsi_dim_nom.tarifs_v2 g on r3.ghs=g.ghs_nro and g.date_effet=if(mois_sortie<3,'2016-03-01','2017-03-01')
    where 1
    and idtest not like '%das'".$test_cv."
    group by t.idrss
    having nbtest>1";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		//    output data of each row
		$arrVal = array();
		while($row = $result->fetch_array()) {
			$act_str=($row[8]=="0" ? "<a class='addButton text-center'id='".$row[0]."'>+ TAS</a>":"<a class='delButton text-center'id='".$row[0]."'>- TAS</a>");
			$act_str.=($row[8]=="0" ? "&nbsp;<a class='remButton' id='".$row[0]."'><span class='glyphicon glyphicon-trash' id='".$row[0]."'></span></a>":"");
			$name = array(
            'idhosp' => "<a href='http://web100tprd.chu-nancy.fr/mwsiissrv.dll/hal/pmsi/dossierpmsi/browser/dossierResume?resume=".$row[0]."' target='_blank'>". $row[1]. "</a>",
            'nbtest' => $row[2],
            'desctest' => $row[3],
            'duree' => $row[4],
            'ghm' => $row[5],
            'ghmlib' =>$row[6],  
            'valoghs' =>money_format('%!n &euro;', $row[7]),
            'action' =>$act_str,
            'sev' =>$row[9]
			);      
			array_push($arrVal, $name);
		}
		echo  json_encode($arrVal);
	}
	mysqli_close($conn);
	
?>
