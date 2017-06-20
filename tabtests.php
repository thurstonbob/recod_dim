<!DOCTYPE html>
<?php
	require 'include/dbconnect.php';
	$sql_test = "select distinct t.idtest,d.libelle from tas.tests t left join tas.test_desc d using(idtest) WHERE 1";
	$sql_sev = "select s from (select distinct right(ghm,1) as s
    from pmsi_dim.rdsR02 r2
    left join tas.tests t on finess='540023264' and t.idrss=r2.idrss
    where t.idrss IS NOT NULL
    union distinct
    select distinct right(ghm,1) as s
    from pmsi_dim.rdsR03 r3
    left join tas.tests t on finess='540023264' and t.idrss=r3.idrss
    where t.idrss IS NOT NULL) as tt order by s";
	$result_test = $conn->query($sql_test);
	$result_sev = $conn->query($sql_sev);
	
?>
<script src="script/bootstrap-table-fr-FR.js"></script>

<script src="script/tabtest_bst.js" ></script>



<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active"><a href="#tests" aria-controls="tests" role="tab" data-toggle="tab">Tests</a></li>
	<li role="presentation" ><a href="#multi" aria-controls="multi" role="tab" data-toggle="tab">S&eacute;jours multi-tests</a></li>
	<li role="presentation" ><a href="#taspan" aria-controls="taspan" role="tab" data-toggle="tab">Pr&eacute;tirage</a></li>
</ul>
<div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="tests">
		
		<div class="container">
			<div class="row">				
				<div class="col-md-4">
					<h1 class="display-2">Tableau des tests</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-md-1 text-right" style="font-size:12px;font-weight: bold;color:grey;padding-top:5px;">
					<br>TESTS
				</div>
				<div class="col-md-8" >
					<br><form method="post"  role="form" name="tabform" id="tabform" ajax="true">
						<select id="testsel" name="testsel" >
							<option selected value="all">Tous</option>
							<?php
								while ($row = mysqli_fetch_array($result_test)) {
									$test_sel= '<option value="'.$row[0].'">' ;
									$test_sel.= $row[0].'-'.$row[1].'</option>';
									echo $test_sel;
								}
							?>
						</select>
					</form>
				</div><!--col6-->
				<div class="col-md-1">
					<br><label>Niveaux</label>
				</div>
				<div class="col-md-2">
					<?php
						$sev_cb="";
						$sev_cb2="";
						$sev_cb3="";
						while ($row = mysqli_fetch_array($result_sev)) {
							if($row[0]==='A'||$row[0]==='E'){
								$sev_cb.='<br>';
								$sev_cb2.='<br>';
								$sev_cb3.='<br>';
							}
							$sev_cb.='    <label class="checkbox-inline">
							<input type="checkbox" value="'.$row[0].'" class="cbs" name="checkboxlist" checked>'.$row[0].'
							</label>';
							$sev_cb2.='    <label class="checkbox-inline">
							<input type="checkbox" value="'.$row[0].'" class="cbs2" name="checkboxlist2" checked>'.$row[0].'
							</label>';
							$sev_cb3.='    <label class="checkbox-inline">
							<input type="checkbox" value="'.$row[0].'" class="cbs3" name="checkboxlist3" checked>'.$row[0].'
							</label>';
						}
						echo $sev_cb;
					?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-md-offset-3" id="com" name="com" style="padding-top:8px;font-style:italic;font-size:10px;"></div>
			</div>
			<div class="row">
				<table
				id="test_table"
				data-toggle="table"
				data-classes="table table-hover table-condensed"
				data-striped="true"
				data-sort-name="idtest"
				data-sort-order="asc"
				data-pagination="true"
				data-page-size="10"
				data-locale="fr"
				data-search="true"
				data-url="req/tabtestsGetTable.php"                        
				data-query-params="queryParams"                        
				data-method="get"
				>
					<thead>
						
						<tr>
							<th class="col-md-1" data-field="idtest" data-sortable="true">Id Test</th>
							<th class="col-md-1" data-field="idhosp" data-sortable="true">IEP</th>
							<th class="col-md-1" data-field="duree" data-sortable="true" data-align="right">Dur&eacute;e RSS</th>
							<th class="col-md-1" data-field="ghm" data-sortable="true">GHM</th>
							<th class="col-md-6" data-field="ghmlib" data-sortable="true">Libell&eacute;</th>
							<th class="col-md-1" data-field="valoghs" data-sortable="true" data-sorter="euroSorter" data-align="right">Valo GHS</th>
							<th class="col-md-1" data-field="action" data-sortable="false">Action</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
				<script>
					$('#test_table').bootstrapTable({locale:'fr_CA'});
				</script>
			</div><!--row-->
		</div><!--container-->
		<div class="container">
			<div class="col-md-6 col-md-offset-4">
				<a class="addButton_all">Ajouter les s&eacute;jours du test et des niveaux selectionn&eacute;s</a>
			</div>
			<div class="col-md-6 col-md-offset-4">
				<a class="delButton_all">Retirer les s&eacute;jours du test et des niveaux selectionn&eacute;s</a>
			</div>
		</div><!--container-->
	</div><!--tabpanel-->
	<div role="tabpanel" class="tab-pane" id="multi">
		<div class="container">
			<div class="row">
				<div class="col-md-6">                                
					<h1 class="display-2">Tableau des s&eacute;jours multi-tests</h1>
				</div>
				<div class="col-md-1">                                
					<br><label>Niveaux</label>
				</div>
				<div class="col-md-5">                                
					<?php
						echo $sev_cb2;
					?>
					
				</div>
			</div><!--row-->
			<div class="row">				
				<table 
				id="testmulti_table"
				data-toggle="table"
				data-classes="table table-hover table-condensed"
				data-striped="true"
				data-sort-name="nbtest"
				data-sort-order="desc"
				data-pagination="true"
				data-page-size="5"
				data-locale="fr"
				data-search="true"
				data-url="req/tabtestsGetTableMulti.php"
				data-query-params="queryParams2"                        
				data-method="get"
				>
					
					<thead>
						
						<tr>
							<th class="col-md-1" data-field="idhosp" data-sortable="true">IEP</th>
							<th class="col-md-1" data-field="nbtest" data-sortable="true" data-align="right">Nb Tests</th>
							<th class="col-md-3" data-field="desctest" data-sortable="false" data-cell-style="smallFontCS">Desc. Test</th>
							<th class="col-md-1" data-field="duree" data-sortable="true" data-align="right">Dur&eacute;e RSS</th>
							<th class="col-md-1" data-field="ghm" data-sortable="true">GHM</th>
							<th class="col-md-3" data-field="ghmlib" data-sortable="true">Libell&eacute;</th>
							<th class="col-md-1" data-field="valoghs" data-sortable="true" data-sorter="euroSorter" data-align="right">Valo GHS</th>
							<th class="col-md-1" data-field="action" data-sortable="false">Action</th>
							
							
						</tr>
						
					</thead>
					
					<tbody>
					</tbody>
				</table>
				<script>
					$('#testmulti_table').bootstrapTable({locale:'fr_CA'});
				</script>
			</div><!--container-->
		</div><!--row-->
	</div><!--tabpanel-->
	<div role="tabpanel" class="tab-pane" id="taspan">
		<div class="container">
			<div class="row">
				<div class="col-md-6">                                
					<h1 class="display-2">S&eacute;jours en attente de validation</h1>
				</div>
				<div class="col-md-1">                                
					<br><label>Niveaux</label>
				</div>
				<div class="col-md-5">                                
					<?php
						echo $sev_cb3;
					?>
					
				</div>
			</div><!--row-->
			<div class="row">				
				<table 
				id="testtas_table"
				data-toggle="table"
				data-classes="table table-hover table-condensed"
				data-striped="true"
				data-sort-name="date_ins"
				data-sort-order="desc"
				data-pagination="true"
				data-page-size="5"
				data-locale="fr"
				data-search="true"
				data-url="req/tabtestsGetTas.php"
				data-query-params="queryParams3"                        
				data-method="get"
				>
					
					<thead>
						
						<tr>
							<th class="col-md-1" data-field="idhosp" data-sortable="true">IEP</th>
							<th class="col-md-1" data-field="duree" data-sortable="true" data-align="right">Dur&eacute;e RSS</th>
							<th class="col-md-2" data-field="libelle" data-sortable="false" data-cell-style="smallFontCS">Libell&eacute; tests</th>
							<th class="col-md-1" data-field="ghm" data-sortable="true">GHM</th>
							<th class="col-md-3" data-field="ghmlib" data-sortable="true">Libell&eacute; GHM</th>
							<th class="col-md-1" data-field="valoghs" data-sortable="true" data-sorter="euroSorter" data-align="right">Valo GHS</th>
							<th class="col-md-1" data-field="action" data-sortable="false">Action</th>
							<th class="col-md-1" data-field="date_ins" data-sortable="true" data-formatter="dateFormatter">Date insert</th>
							
							
						</tr>
						
					</thead>
					
					<tbody>
					</tbody>
				</table>
				<script>
					$('#testtas_table').bootstrapTable({locale:'fr_CA'});
				</script>
				<div class="container">
					<div class="col-md-6 col-md-offset-4">
						<a class="valtas">Valider le tirage</a>
					</div>
				</div><!--container-->
				
			</div><!--container-->
		</div><!--row-->
	</div><!--tabpanel-->
</div><!--tabcontent-->
<? $conn->close();?>
<div>
	
	
