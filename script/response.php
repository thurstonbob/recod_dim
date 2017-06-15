
<?php
require 'include/dbconnect.php';
if(isset($_POST["idrss"]) && strlen($_POST["idrss"])>0) 
{   //check $_POST["content_txt"] is not empty

    //sanitize post value, PHP filter FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH Strip tags, encode special characters.
//    $contentToSave = filter_var($_POST["content_txt"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); 

    // Insert sanitize string in record
    $idrss=$_POST["idrss"];
    $insert_row = $conn->query("INSERT INTO rss_tas_test (idhosp,idrss,duree,severite,libelle)
       select distinct t.idhosp,t.idrss,r2.duree_rss,right(ghm,1) , group_concat(distinct concat(left(idtest,5),'-',d.libelle) separator '</br>') from tas.tests t
left join tas.test_desc d using (idtest)
    left join pmsi_dim.rdsR02 r2 on finess='540023264' and t.idrss=r2.idrss
    left join pmsi_dim.valoPP v on r2.finess=v.finess and t.idrss =v.idrss and t.idhosp=t.idhosp
    left join pmsi_dim_nom.tarifs_v2 g on r2.ghs=g.ghs_nro and g.date_effet=if(mois_sortie<3,'2016-03-01','2017-03-01')
    where r2.idrss is not null and t.idrss='".$idrss."' and idtest not like '%das'
group by r2.idrss
    union distinct
select distinct t.idhosp,t.idrss,r3.duree_rss,right(ghm,1) , group_concat(distinct concat(left(idtest,5),'-',d.libelle) separator '</br>') from tas.tests t
left join tas.test_desc d using (idtest)
    left join pmsi_dim.rdsR03 r3 on finess='540023264' and t.idrss=r3.idrss
    left join pmsi_dim.valoPP v on r3.finess=v.finess and t.idrss =v.idrss and t.idhosp=t.idhosp
    left join pmsi_dim_nom.tarifs_v2 g on r3.ghs=g.ghs_nro and g.date_effet=if(mois_sortie<3,'2016-03-01','2017-03-01')
    where r3.idrss is not null and t.idrss='".$idrss."' and idtest not like '%das'
group by r3.idrss" 
);

    if($insert_row)
    {
        //Record was successfully inserted, respond result back to index page
//        $my_id = $conn->insert_id; //Get ID of last inserted row from MySQL
  //      echo '<li id="item_'.$my_id.'">';
        echo "<a class='delButton text-center' id='".$idrss."'>- TAS</a>";
            //'<div class="del_wrapper"><a href="#" class="del_button" id="del-'.$my_id.'">';
    //    echo '<img src="images/icon_del.gif" border="0" />';
      //  echo '</a></div>';
       // echo $contentToSave.'</li>';
        $conn->close(); //close db connection

    }else{

        header('HTTP/1.1 500 '.mysql_error()); //display sql errors.. must not output sql errors in live mode.
        //header('HTTP/1.1 500 Looks like mysql error, could not insert record!'.$insert_row);
        exit();
    }

}
elseif(isset($_POST["delidrss"]) && strlen($_POST["delidrss"])>0)
{   //do we have a delete request? $_POST["recordToDelete"]

    //sanitize post value, PHP filter FILTER_SANITIZE_NUMBER_INT removes all characters except digits, plus and minus sign.
   // $idToDelete = filter_var($_POST["recordToDelete"],FILTER_SANITIZE_NUMBER_INT); 

    $delidrss=$_POST["delidrss"];
    //try deleting record using the record ID we received from POST
    $delete_row = $conn->query("DELETE FROM rss_tas_test WHERE idrss=".$delidrss);

    if($delete_row)
    {
        echo "<a class='addButton text-center' id='".$delidrss."'>+ TAS</a>";
        $conn->close(); //close db connection
        
    }else{    
        //If mysql delete query was unsuccessful, output error 
        header('HTTP/1.1 500 Could not delete record!'.mysql_error());
        exit();
    }
}
elseif(isset($_POST["idtest"]) && strlen($_POST["idtest"])>0) 
{   //check $_POST["content_txt"] is not empty

    //sanitize post value, PHP filter FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH Strip tags, encode special characters.
//    $contentToSave = filter_var($_POST["content_txt"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); 

    // Insert sanitize string in record
    $idt=$_POST["idtest"];
    $cv=$_POST["cv"];
    $insert_row = $conn->query("REPLACE INTO rss_tas_test (idhosp,idrss,duree,severite,libelle)
        select distinct t.idhosp,t.idrss,r2.duree_rss,right(ghm,1) , group_concat(distinct ifnull(concat(left(idtest,5),'-',d.libelle),idtest) separator '</br>') from tas.tests t
left join tas.test_desc d using (idtest)
    left join pmsi_dim.rdsR02 r2 on finess='540023264' and t.idrss=r2.idrss
    left join pmsi_dim.valoPP v on r2.finess=v.finess and t.idrss =v.idrss and t.idhosp=t.idhosp
    left join pmsi_dim_nom.tarifs_v2 g on r2.ghs=g.ghs_nro and g.date_effet=if(mois_sortie<3,'2016-03-01','2017-03-01')
     where  r2.idrss in (select distinct idrss from tas.tests where idtest='".$idt."')  and right(ghm,1) in (".$cv.")
group by r2.idrss
    union distinct
select distinct t.idhosp,t.idrss,r3.duree_rss,right(ghm,1) , group_concat(distinct ifnull(concat(left(idtest,5),'-',d.libelle),idtest) separator '</br>') from tas.tests t
left join tas.test_desc d using (idtest)
    left join pmsi_dim.rdsR03 r3 on finess='540023264' and t.idrss=r3.idrss
    left join pmsi_dim.valoPP v on r3.finess=v.finess and t.idrss =v.idrss and t.idhosp=t.idhosp
    left join pmsi_dim_nom.tarifs_v2 g on r3.ghs=g.ghs_nro and g.date_effet=if(mois_sortie<3,'2016-03-01','2017-03-01')
     where  r3.idrss in (select distinct idrss from tas.tests where idtest='".$idt."')  and right(ghm,1) in (".$cv.")
group by r3.idrss" 
);

    if($insert_row)
    {
        echo $conn->affected_rows;
        $conn->close(); //close db connection

    }else{

        header('HTTP/1.1 500 '.mysql_error()); //display sql errors.. must not output sql errors in live mode.
        exit();
    }

}
else
{
    //Output error
    header('HTTP/1.1 500 Error occurred, Could not process request!');
    exit();
}
?>
