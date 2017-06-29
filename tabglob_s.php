<div class="row">
	<form action="/recodage/recxls.php">
		<div class="col-md-3 col-md-offset-4">
			<button type="submit" class="btn btn-success" ><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;T&eacute;l&eacute;charger au format Excel</button>
		</div>
	</form>
</div>
<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active"><a href="#attr" aria-controls="attr" role="tab" data-toggle="tab">Attribu&eacute;s</a></li>
	<li role="presentation" ><a href="#libre" aria-controls="libre" role="tab" data-toggle="tab">Non attribu&eacute;s</a></li>
	<li role="presentation" ><a href="#stat" aria-controls="stat" role="tab" data-toggle="tab">Statistiques</a></li>
</ul>
<div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="attr">
		
		<div class="container">
			<div class="row">				
				<h1 class="display-2">Tableau de recodage - s&eacute;jours attribu&eacute;s</h1>
				<table 
				id="tabglob"
				data-toggle="table"
				data-classes="table table-hover table-condensed"
				data-striped="true"
				data-sort-name="date_pec"
				data-sort-order="desc"
				data-pagination="true"
				data-page-size="15"
				data-locale="fr"
				data-search="true"
				data-url="req/tabtestsGetAttr.php"
				data-method="get"
				>
					
					<thead>
						
						<tr>
							<th class="col-md-1" data-field="idhosp" data-sortable="true">IEP</th>
							<th class="col-md-1" data-field="duree" data-sortable="true">Dur&eacute;e</th>
							<th class="col-md-1" data-field="severite" data-sortable="true">S&eacute;v&eacute;rit&eacute;</th>
							<th class="col-md-3" data-field="libelle" data-sortable="true" data-cell-style="smallFontCS">Libell&eacute;</th>
							<th class="col-md-1" data-field="idtim" data-sortable="true">Id TIM</th>
							<th class="col-md-2" data-field="nom" data-sortable="true">Nom</th>
							<th class="col-md-1" data-field="prenom" data-sortable="true">Pr&eacute;nom</th>
							<th class="col-md-2" data-field="date_pec" data-sortable="true" data-formatter="dateFormatter">Date PEC</th>
							
						</tr>
						
					</thead>
					
					<tbody>
					</tbody>
					
				</table>
				<script>
					$('#tabglob').bootstrapTable({locale:'fr_CA'});
					
				</script>
			</div><!--container-->
		</div><!--row-->
		
	</div>
	<div role="tabpanel" class="tab-pane" id="libre">
		<div class="container">
			<div class="row">				
				<h1 class="display-2">Tableau de recodage - S&eacute;jours non attribu&eacute;s</h1>
				<table 
				id="free"
				data-toggle="table"
				data-classes="table table-hover table-condensed"
				data-striped="true"
				data-sort-name="date_pec"
				data-sort-order="desc"
				data-pagination="true"
				data-page-size="15"
				data-locale="fr"
				data-search="true"
				data-url="req/tabtestsGetFree.php"
				data-method="get"
				>
					
					<thead>
						
						<tr>
							<th class="col-md-2" data-field="idhosp" data-sortable="true">IEP</th>
							<th class="col-md-1" data-field="duree" data-sortable="true">Dur&eacute;e</th>
							<th class="col-md-1" data-field="severite" data-sortable="true">S&eacute;v&eacute;rit&eacute;</th>
							<th class="col-md-4" data-field="libelle" data-sortable="true" data-cell-style="smallFontCS">Libell&eacute;</th>
							<th class="col-md-4" data-field="date_ins" data-sortable="true" data-formatter="dateFormatter">Date Insertion</th>
							
						</tr>
						
					</thead>
					
					<tbody>
					</tbody>
					
				</table>
				<script>
					$('#free').bootstrapTable({locale:'fr_CA'});
					
				</script>
			</div><!--container-->
		</div><!--row-->
	</div><!--tabpanel-->
	<div role="tabpanel" class="tab-pane" id="stat">
		<div class="container">
			<div class="row">
				<h1 class="display-2">Statistiques</h1>
				<div id="masterhead">
					<div class="container">
						<div class="slideshow">
							<div id="slideshow" class="carousel slide" data-ride="carousel">
								<div class="carousel-inner">
									<div class="item active">
										<div class="container">
											<div id="columnchart_material" style="width: 800px; height: 500px;"></div>
										</div><!-- /. contailner -->
									</div><!-- /. Item Active -->
									<div class="item">
										<div class="container">
											<div id="barchart_material" style="width: 800px; height: 500px;"></div>
										</div><!-- /. contailner -->
									</div><!-- /. Item -->
									<div class="item">
										<div id="columnchart_material2" style="width: 800px; height: 500px;"></div>
									</div><!-- /. Item -->
								</div><!-- /. Carousel-Inner -->
								<div class="controlsBlock">
									<div class="controls">
										<a class="left carousel-control" href="#slideshow" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
										<a class="right carousel-control" href="#slideshow" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
										<!--<a class="left carousel-control" href="#slideshow" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
										<a class="right carousel-control" href="#slideshow" data-slide="next"><i class="fa fa-chevron-right"></i></a>-->
										<div class="carousel-indicators">
											<li data-target="#slideshow" data-slide-to="0" class="active"></li>
											<li data-target="#slideshow" data-slide-to="1"></li>
											<li data-target="#slideshow" data-slide-to="2"></li>
										</div>
									</div>
								</div>
							</div><!-- /# Slideshow .Carousel -->
						</div><!-- /. Slideshow -->
					</div><!-- /. Container -->
				</div><!-- /# Mastehead -->
				<script>
					//google.charts.load('current', {'packages':['bar']});
					google.charts.load('current', {packages: ['corechart', 'bar']});
					
					google.charts.setOnLoadCallback(drawChartExh);
					google.charts.setOnLoadCallback(drawChartUsr);
					google.charts.setOnLoadCallback(drawChartJcod);
					
					function drawChartExh() {
						var jsonData = $.ajax({
							url: "req/tabtestsGetStat.php",
							type:'GET',
							data:'st=exh',
							dataType: "json",
							async: false
						}).responseText;
						var data = new google.visualization.DataTable(jsonData);
						var options = {
							chart: {
								title: 'Exhaustivité Recodage',
								subtitle: 'Exhaustivité des séquences de recodage par date tirage au sort',
							},
							width:800,
							height:500,
							isStacked: true,  series: {
								0:{color:'#b1cbbb'},
								1:{color:'#eea29a'}
							}
							
						}
						var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
						
						chart.draw(data, google.charts.Bar.convertOptions(options));
					}
					
					function drawChartUsr() {
						var jsonData = $.ajax({
							url: "req/tabtestsGetStat.php",
							type:'GET',
							data:'st=usr',
							dataType: "json",
							async: false
						}).responseText;
						var data = new google.visualization.DataTable(jsonData);
						var options = {
							title: 'Séjours par utilisateur',
							subtitle: 'Nombre de s&eacute;jours attribu&eacute; par utilisateur',
							width:800,
							height:500,
							hAxis: {
								title: 'Nb séjours',
							},
							vAxis: {
								textStyle: {
									fontSize: 10,
								}
							}
						};
						var chart = new google.visualization.BarChart(document.getElementById('barchart_material'));
						
						chart.draw(data, options);
					}
					
					function drawChartJcod() {
						var jsonData = $.ajax({
							url: "req/tabtestsGetStat.php",
							type:'GET',
							data:'st=jcod',
							dataType: "json",
							async: false
						}).responseText;
						console.log(jsonData);
						var data = new google.visualization.DataTable(jsonData);
						var view = new google.visualization.DataView(data);
						view.setColumns([0, 1,
						{ calc: "stringify", 
							sourceColumn: 1,
							type: "string",
						role: "annotation" },
						{
							sourceColumn: 2,
							type: "string",
                                                        role: "annotationText", 
    properties: {
            html: true
                    },
}]);
						var options = {
                                                    tooltip: {isHtml: true},
							title: 'Jours de codage',
							subtitle: 'Nombre de séjour par jour de codage',
							chartArea:{left:80,top:0,width:"100%",height:"100%"},
							width:800,
							height:500,
							legend: { position: 'none' },
							vAxis: {
								textStyle: {
									fontSize: 8,
								}
							},
							annotations: {
								textStyle: {
									color: 'black',
									fontSize: 8,
								},
                                alwaysOutside: true
							}
                                                };
						var chart = new google.visualization.BarChart(document.getElementById('columnchart_material2'));
						
						chart.draw(view, options);
						
					}
					
					$(document).ready(function(){
						$('#slideshow').carousel({
							pause: true,
							interval: false
						});
					});
				</script>
			</div><!--row-->
		</div><!--container-->
	</div><!--tabpanel-->
</div><!--tabcontent-->

