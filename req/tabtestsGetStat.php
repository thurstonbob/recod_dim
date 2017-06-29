<?
	header('Content-type: application/json');
	require '../include/dbconnect.php';
	if(isset($_GET["st"]) && $_GET["st"]=="exh")
	{ 
		$sql = "select date_ins,sum(if(idtim is not null,1,0)) as nb,sum(if(idtim is null,1,0)) as nbn from rss_tas r group by date_ins desc";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			$rows = array();
			$table = array();
			$table['cols'] = array(
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
			echo  json_encode($table);
		}
	}elseif(isset($_GET["st"]) && $_GET["st"]=="usr")
	{
		$sql = "select concat(t.nom,' ',t.prenom) as nm,count(distinct(idrss)) as nb_sej from rss_tas r
        left join tim t on r.idtim=t.id
		where idtim is not null group by idtim order by nb_sej desc";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			$rows = array();
			$table = array();
			$table['cols'] = array(
            array('label' => 'Utilisateur', 'type' => 'string'),
            array('label' => 'Nb_sej', 'type' => 'number')
			
			);
			
			foreach($result as $r) {
				
				$temp = array();
				
				// The following line will be used to slice the Pie chart
				
				$temp[] = array('v' => (string) $r['nm']); 
				$temp[] = array('v' => (int) $r['nb_sej']); 
				$rows[] = array('c' => $temp);
			}
			
			$table['rows'] = $rows;
			echo  json_encode($table);
		}
		
	}elseif(isset($_GET["st"]) && $_GET["st"]=="jcod")
	{
		$sql = "select date(date_pec) as datec,count(distinct idhosp) as nb_sej, group_concat(distinct tt.nm,':',tt.nb_sej order by tt.nb_sej desc separator '\n') as det
		from rss_tas r
		left join (select date(date_pec) as datec,concat(t.nom,' ',t.prenom)as nm, count(distinct idhosp) as nb_sej
		from tim t
		left join rss_tas r on t.id=r.idtim and t.nom is not null
		where date_pec is not null and idtim is not null
		group by date(date_pec),r.idtim
		order by date(date_pec) desc) as tt on date(date_pec)=tt.datec
		where date_pec is not null and year(date_pec)=2017                
		group by date(date_pec)
		order by date(date_pec) desc";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			$rows = array();
			$table = array();
			$table['cols'] = array(
            array('label' => 'Date', 'type' => 'string'),
            array('label' => 'Nb_sej', 'type' => 'number'),
            array('label' => 'dt', 'type' => 'string')
           // array('type' => 'string','role'=>'tooltip','p'=>array('html'=>'true'))
            //array('id' => '','type' => 'string', 'role' => 'tooltip','p' => array('role'=>'tooltip'))
			
			
			);
			
			foreach($result as $r) {
				
				$temp = array();
				
				// The following line will be used to slice the Pie chart
				
				$temp[] = array('v' => (string) date('d/m/Y',strtotime($r['datec']))); 
				$temp[] = array('v' => (int) $r['nb_sej']); 
				$temp[] = array('v' => (string) nl2br(htmlentities($r['det']))); 
				$rows[] = array('c' => $temp);
			}
			
			$table['rows'] = $rows;
			echo  json_encode($table);
		}
		
	}
	
	mysqli_close($conn);
?>
