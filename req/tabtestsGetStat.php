<?
header('Content-type: application/json');
require '../include/dbconnect.php';
$sql = "select date_ins,sum(if(idtim is not null,1,0)) as nb,sum(if(idtim is null,1,0)) as nbn from rss_tas r group by date_ins desc";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $rows = array();
    $table = array();
    $table['cols'] = array(

        // Labels for your chart, these represent the column titles.
        //     /* 
        //             note that one column is in "string" format and another one is in "number" format 
        //                     as pie chart only required "numbers" for calculating percentage 
        //                             and string will be used for Slice title
        //                                 */
        //
        array('label' => 'Date', 'type' => 'string'),
        array('label' => 'Nb_attr', 'type' => 'number'),
        array('label' => 'Nb_libre', 'type' => 'number')

    );

    foreach($result as $r) {

        $temp = array();

        // The following line will be used to slice the Pie chart

        $temp[] = array('v' => (string) date('d/m/Y',strtotime($r['date_ins']))); 

        //             // Values of the each slice

        $temp[] = array('v' => (int) $r['nb']); 
        $temp[] = array('v' => (int) $r['nbn']); 
        $rows[] = array('c' => $temp);
    }

    $table['rows'] = $rows;

/*
    //    output data of each row
    $arrVal = array();
    array_push($arrVal,array("Date","Nb_attr","Nb_libre"));
    while($row = $result->fetch_array()) {
        $name = array(
            $row[0],
            $row[1],
            $row[2]
        );      
        array_push($arrVal, $name);
}*/
    //echo  json_encode($arrVal);
    echo  json_encode($table);
}
mysqli_close($conn);
?>
