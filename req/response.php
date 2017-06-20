
<?php
require '../include/dbconnect.php';
if(isset($_POST["idrss"]) && strlen($_POST["idrss"])>0) 
{    
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
        echo "<a class='delButton text-center' id='".$idrss."'>- TAS</a>";
        $conn->close(); //close db connection

    }else{

        header('HTTP/1.1 500 '.mysql_error()); //display sql errors.. must not output sql errors in live mode.
        exit();
    }

}
elseif(isset($_POST["delidrss"]) && strlen($_POST["delidrss"])>0)
{   
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
{  
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
elseif(isset($_POST["delidtest"]) && strlen($_POST["delidtest"])>0) 
{   
    $idt=$_POST["delidtest"];
    $cv=$_POST["cv"];
    $del_row = $conn->query("DELETE rss_tas_test FROM rss_tas_test 
        left join tas.tests using (idrss)
        where idtest='".$idt."'  and severite in (".$cv.")" 
    );

    if($del_row)
    {
        echo $conn->affected_rows;
        $conn->close(); //close db connection

    }else{

        header('HTTP/1.1 500 '.mysql_error()); //display sql errors.. must not output sql errors in live mode.
        exit();
    }

}
elseif(isset($_POST["valtas"])) 
{   
    $tr_row = $conn->query("replace into rss_tas_asup select * from rss_tas_test" );
    $nbrow=0;
    if($tr_row)
    {
        $nbrow = $conn->affected_rows;
        //$tr2_row = $conn->query("truncate rss_tas_test"); 
        $tr2_row = $conn->query("delete from tests where idrss in (select distinct idrss from rss_tas_test)"); 
        if($tr2_row){
            $tr3_row = $conn->query("truncate rss_tas_test"); 
            if($tr3_row){
                echo $nbrow;
                $conn->close(); //close db connection
            }
            else{
                header('HTTP/1.1 500 '.mysql_error()); //display sql errors.. must not output sql errors in live mode.
                exit();
            }
        }
        else{
            header('HTTP/1.1 500 '.mysql_error()); //display sql errors.. must not output sql errors in live mode.
            exit();
        }

    }else{

        header('HTTP/1.1 500 '.mysql_error()); //display sql errors.. must not output sql errors in live mode.
        exit();
    }

}
elseif(isset($_POST["hideidrss"]) && strlen($_POST["hideidrss"])>0)
{   
    $hideidrss=$_POST["hideidrss"];
    //try deleting record using the record ID we received from POST
    $delete_row = $conn->query("DELETE FROM tests WHERE idrss=".$hideidrss);

    if($delete_row)
    {
        echo $hideidrss;
        $conn->close(); //close db connection

    }else{    
        //If mysql delete query was unsuccessful, output error 
        header('HTTP/1.1 500 Could not delete record!'.mysql_error());
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
