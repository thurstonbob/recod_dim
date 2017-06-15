<!DOCTYPE html>
<?php
	include '../sitedim/foruser.php';
	$rec_user = $user->get('username');
	$servername = "livenne";
	$username = "u400274";
	$password = "drap26drwz";
	$dbname = "tas";
	//Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	//Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	$conn->query('SET NAMES utf8');
	$sql = "select r.idhosp,r.idrss,r.duree,r.severite,r.libelle,t.id,t.nom, t.prenom, date_pec from rss_tas r left join tim t on r.idtim=t.id left join rss_cand c using (idrss)  where idtim is not null order by date_pec desc";
	$result = $conn->query($sql);
	$sql2 = "select r.idhosp,r.idrss,r.duree,r.severite,r.libelle,t.id,t.nom, t.prenom, date_pec from rss_tas r left join tim t on r.idtim=t.id left join rss_cand c using (idrss)  where idtim is null order by date_pec desc";
	$result2 = $conn->query($sql2);
	
	
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title> 
			Tableau de recodage
		</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css">
		
		<!-- Latest compiled and minified JavaScript -->
		<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>
		
		<!-- Latest compiled and minified Locales -->
		<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-zh-CN.min.js"></script>
		<script src="bootstrap-table-fr-FR.js"></script>
	</head>
	
	<body>
	<form action="/recodage/recxls.php" style="float:right;">
    <button type="submit" class="btn btn-success" ><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;Télécharger au format Excel</button>
</form>
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#attr" aria-controls="attr" role="tab" data-toggle="tab">Attribués</a></li>
			<li role="presentation" ><a href="#libre" aria-controls="libre" role="tab" data-toggle="tab">Non attribués</a></li>
		</ul>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="attr">
				
				<div class="container">
					<div class="row">				
						<h1 class="display-2">Tableau de recodage - séjours attribués</h1>
						<table data-toggle="table"
						data-classes="table table-hover table-condensed"
						data-striped="true"
						data-sort-name="date_pec"
						data-sort-order="desc"
						data-pagination="true"
						data-page-size="20"
						data-locale="fr"
						data-search="true"
						>
							
							<thead>
								
								<tr>
									<th class="col-md-1" data-field="idhosp" data-sortable="true">IEP</th>
									<th class="col-md-1" data-field="duree" data-sortable="true">Dur&eacute;e</th>
									<th class="col-md-1" data-field="severite" data-sortable="true">S&eacute;v&eacute;rit&eacute;</th>
									<th class="col-md-3" data-field="libelle" data-sortable="true">Libell&eacute;</th>
									<th class="col-md-1" data-field="idtim" data-sortable="true">Id TIM</th>
									<th class="col-md-2" data-field="nom" data-sortable="true">Nom</th>
									<th class="col-md-1" data-field="prenom" data-sortable="true">Pr&eacute;nom</th>
									<th class="col-md-2" data-field="date_pec" data-sortable="true">Date PEC</th>
									
								</tr>
								
							</thead>
							
							<tbody>
								<?
									
									if ($result->num_rows > 0) {
										//    output data of each row
										while($row = $result->fetch_array()) {
											$date_pec=$row[8]==null?"non attribué":date("d/m/Y H:i",strtotime($row[8]));
											echo "<tr>
											<td> <a href='http://web100tprd.chu-nancy.fr/mwsiissrv.dll/hal/pmsi/dossierpmsi/browser/dossierResume?resume=".$row[1]."' target='_blank'>". $row[0]. "</a></td>
											<td>". $row[2]. "</td>
											<td>" . $row[3]. "</td>
											<td>" . $row[4]. "</td>
											<td>" . $row[5]. "</td>
											<td>" . $row[6]."</td>
											<td>" . $row[7]."</td>
											<td>" .$date_pec."</td>
											</tr>";
										}
										} else {
										echo "0 resultats";
									}
									
								?>
							</tbody>
							
						</table>
					</div><!--container-->
				</div><!--row-->
				
				<script>
					
					function queryParams() {
						return {
							type: 'owner',
							sort: 'updated',
							direction: 'desc',
							per_page: 100,
							page: 1
						};
					}
				</script>
			</div>
				<div role="tabpanel" class="tab-pane" id="libre">
					<div class="container">
						<div class="row">				
							<h1 class="display-2">Tableau de recodage - Séjours non attribués</h1>
							<table data-toggle="table"
							data-classes="table table-hover table-condensed"
							data-striped="true"
							data-sort-name="date_pec"
							data-sort-order="desc"
							data-pagination="true"
							data-page-size="20"
							data-locale="fr"
							data-search="true"
							>
								
								<thead>
									
									<tr>
										<th class="col-md-2" data-field="idhosp" data-sortable="true">IEP</th>
										<th class="col-md-1" data-field="duree" data-sortable="true">Dur&eacute;e</th>
										<th class="col-md-1" data-field="severite" data-sortable="true">S&eacute;v&eacute;rit&eacute;</th>
									<th class="col-md-4" data-field="libelle" data-sortable="true">Libell&eacute;</th>
									<th class="col-md-4" data-field="date_pec" data-sortable="true">Date PEC</th>
									
								</tr>
								
							</thead>
							
							<tbody>
								<?
									
									if ($result2->num_rows > 0) {
										//    output data of each row
										while($row = $result2->fetch_array()) {
											$date_pec=$row[8]==null?"non attribué":date("d/m/Y",strtotime($row[8]));
											echo "<tr>
											<td> <a href='http://web100tprd.chu-nancy.fr/mwsiissrv.dll/hal/pmsi/dossierpmsi/browser/dossierResume?resume=".$row[1]."' target='_blank'>". $row[0]. "</a></td>
											<td>". $row[2]. "</td>
											<td>" . $row[3]. "</td>
											<td>" . $row[4]. "</td>
											<td>" .$date_pec."</td>
											</tr>";
										}
										} else {
										echo "0 resultats";
									}
									
								?>
							</tbody>
							
						</table>
					</div><!--container-->
				</div><!--row-->
				
				<script>
					
					function queryParams() {
						return {
							type: 'owner',
							sort: 'updated',
							direction: 'desc',
							per_page: 100,
							page: 1
						};
					}
				</script>
			</div>
		</div>
										$conn->close();

	</body>
</html>
