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
$sql = "select r.idhosp,r.idrss,r.duree,r.severite,r.libelle,t.id,t.nom, t.prenom, date_pec from rss_tas r left join tim t on r.idtim=t.id left join rss_cand c using (idrss)  where r.idtim='".$rec_user."' order by date_pec desc";
$result = $conn->query($sql);


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
<?
echo '<pre>Bonjour '.$user->get('name').'</pre>';
?>
<div class="container">
<div class="row">				
<h1 class="display-2">Tableau de recodage</h1>
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
<th class="col-md-2" data-field="idtim" data-sortable="true">Id TIM</th>
<th class="col-md-3" data-field="nom" data-sortable="true">Nom</th>
<th class="col-md-3" data-field="prenom" data-sortable="true">Pr&eacute;nom</th>
<th class="col-md-3" data-field="date_pec" data-sortable="true">Date PEC</th>

</tr>

</thead>

<tbody>
<?

if ($result->num_rows > 0) {
//    output data of each row
        while($row = $result->fetch_array()) {
            echo "<tr>
			<td> <a href='http://web100tprd.chu-nancy.fr/mwsiissrv.dll/hal/pmsi/dossierpmsi/browser/dossierResume?resume=".$row[1]."' target='_blank'>". $row[0]. "</a></td>
			<td>". $row[2]. "</td>
			<td>" . $row[3]. "</td>
			<td>" . $row[4]. "</td>
			<td>" . $row[5]. "</td>
			<td>" . $row[6]."</td>
			<td>" . $row[7]."</td>
			<td>" . date("d/m/Y",strtotime($row[8]))."</td>
			</tr>";
        }
} else {
    echo "0 resultats";
}

$conn->close();
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
</body>
</html>
