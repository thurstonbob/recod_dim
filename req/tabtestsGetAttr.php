<?
header('Content-type: application/json');
require '../include/dbconnect.php';
$sql = "select r.idhosp,r.idrss,r.duree,r.severite,r.libelle,t.id,t.nom, t.prenom, date_pec from rss_tas r left join tim t on r.idtim=t.id left join rss_cand c using (idrss)  where idtim is not null order by date_pec desc";
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
            'idtim' =>$row[5],
            'nom' =>$row[6],
            'prenom' =>$row[7],
            'date_pec' =>$row[8]
        );      
        array_push($arrVal, $name);
    }
    echo  json_encode($arrVal);
}
mysqli_close($conn);
?>
