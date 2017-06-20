<div class="row">
        <form action="/recodage/recxls.php">
                <div class="col-md-3 col-md-offset-4">
                        <button type="submit" class="btn btn-success" ><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;Télécharger au format Excel</button>
                </div>
        </form>
</div>
<ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#attr" aria-controls="attr" role="tab" data-toggle="tab">Attribués</a></li>
        <li role="presentation" ><a href="#libre" aria-controls="libre" role="tab" data-toggle="tab">Non attribués</a></li>
        <li role="presentation" ><a href="#stat" aria-controls="stat" role="tab" data-toggle="tab">Statistiques</a></li>
</ul>
<div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="attr">

                <div class="container">
                        <div class="row">				
                                <h1 class="display-2">Tableau de recodage - séjours attribués</h1>
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
                                <h1 class="display-2">Tableau de recodage - Séjours non attribués</h1>
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
<script type="text/javascript">
google.charts.load('current', {'packages':['bar']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var jsonData = $.ajax({
    url: "req/tabtestsGetStat.php",
        dataType: "json",
        async: false
                                                      }).responseText;
console.log(jsonData);
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
    </script>
                <div id="columnchart_material" style="width: 800px; height: 500px;"></div>
                        </div><!--container-->
                </div><!--row-->
                </div><!--tabpanel-->
                </div><!--tabcontent-->

