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
$sql = "select t.idrss,t.idhosp,t.duree,t.libelle as libelle,concat(cmd,ghm) as ghm ,g.ghs_lib,v.valoGHS,right(ghm,1),t.date_ins
    from tas.rss_tas_test t
    left join pmsi_dim.rdsR02 r2 on r2.idrss=t.idrss
    left join pmsi_dim.valoPP v on r2.finess=v.finess and t.idrss =v.idrss and t.idhosp=t.idhosp
    left join pmsi_dim_nom.tarifs_v2 g on r2.ghs=g.ghs_nro and g.date_effet=if(mois_sortie<3,'2016-03-01','2017-03-01')
    where 1".$test_cv."
    union distinct
    select  t.idrss,t.idhosp,t.duree,t.libelle as libelle,concat(cmd,ghm) as ghm ,g.ghs_lib,v.valoGHS,right(ghm,1),t.date_ins
    from tas.rss_tas_test t
    left join pmsi_dim.rdsR03 r3 on r3.idrss=t.idrss
    left join pmsi_dim.valoPP v on r3.finess=v.finess and t.idrss =v.idrss and t.idhosp=t.idhosp
    left join pmsi_dim_nom.tarifs_v2 g on r3.ghs=g.ghs_nro and g.date_effet=if(mois_sortie<3,'2016-03-01','2017-03-01')
    where 1".$test_cv;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    //    output data of each row
    $arrVal = array();
    while($row = $result->fetch_array()) {
        $act_str="<a class='delButton text-center'id='".$row[0]."'>- TAS</a>";
        $name = array(
            'idhosp' => "<a href='http://web100tprd.chu-nancy.fr/mwsiissrv.dll/hal/pmsi/dossierpmsi/browser/dossierResume?resume=".$row[0]."' target='_blank'>". $row[1]. "</a>",
            'duree' => $row[2],
            'libelle' => $row[3],
            'ghm' => $row[4],
            'ghmlib' =>$row[5],  
            'valoghs' =>money_format('%!n &euro;', $row[6]),
            'action' =>$act_str,
            'sev' =>$row[7],
            'date_ins' =>$row[8]
        );      
        array_push($arrVal, $name);
    }
    echo  json_encode($arrVal);
}
mysqli_close($conn);

?>
