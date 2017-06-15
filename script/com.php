<?
header('Content-type: application/json');
require '../include/dbconnect.php';
$sql_test_com = "select distinct t.idtest,d.commentaires from tas.tests t left join tas.test_desc d using(idtest) WHERE 1";
$result_test_com = $conn->query($sql_test_com);
$to_encode = array();
while($row = $result_test_com->fetch_assoc()) {
      $to_encode[] = $row;
}
echo json_encode($to_encode);
?>
