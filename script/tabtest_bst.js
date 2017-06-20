
var com_array={};
$.getJSON('script/com.php', function(data) {
    $.each(data, function(index, val) {
        com_array[val.idtest]=val.commentaires;
	});
});
$(document).ready(function (e) {
	
	$('table').bootstrapTable({
		onLoadSuccess: function() {
			$('a.addButton').off('click').click(function(e){
				addTasClick(e);
			});
			$('a.remButton').off('click').click(function(e){
				hideTasClick(e);
			});
			$('a.addButton_all').off('click').click(function(e){
				addTasClick_all(e);
			});
			$('a.delButton_all').off('click').click(function(e){
				delTasClick_all(e);
			});
			$('a.delButton').off('click').click(function(e){
				delTasClick(e);
			});
			$('a.valtas').off('click').click(function(e){
				valTasClick(e);
			});
			
		},
		onResetView: function() {
			$('a.addButton').off('click').click(function(e){
				addTasClick(e);
			});
			$('a.remButton').off('click').click(function(e){
				hideTasClick(e);
			});
			$('a.delButton').off('click').click(function(e){
				delTasClick(e);
			});
			$(".se-pre-con").fadeOut("slow");
			
		},
		onRefreshOptions: function() {
			$('a.addButton').off('click').click(function(e){
				addTasClick(e);
			});
			$('a.remButton').off('click').click(function(e){
				hideTasClick(e);
			});
			$('a.delButton').off('click').click(function(e){
				delTasClick(e);
			});
			$(".se-pre-con").fadeOut("slow");
			
		}
	});
	
	
	
    $( ".addButton_all" ).hide();
    $( ".delButton_all" ).hide();
	
    $('.cbs').click(function(){
        $('#test_table').bootstrapTable('refresh');
	});
	
    $('.cbs2').click(function(){
        $('#testmulti_table').bootstrapTable('refresh');
		
	});
    $('.cbs3').click(function(){
        $('#testtas_table').bootstrapTable('refresh');
		
	});
	
    $('#testsel').change(function(e) {
        var idt=$('#testsel').val();
        if(idt==="all"){
            $( ".addButton_all" ).hide();
            $( ".delButton_all" ).hide();
            $('#test_table').bootstrapTable('filterBy', {});
            $('#com').empty();
		}
        else{
            $( ".addButton_all" ).show();
            $( ".delButton_all" ).show();
            $('#test_table').bootstrapTable('filterBy', {idtest: idt});
            $('#com').html(com_array[$('#testsel').val()]);
            $('#com').prepend("Commentaires :");
		}
	});
	
});

function addTasClick(e){
    $(".se-pre-con").fadeIn("fast",function(){
        var idrss=e.target.id;
        var myData = 'idrss=' + idrss; //build a post data structure
        jQuery.ajax({
            type: "POST", // HTTP method POST or GET
            url: "req/response.php", //Where to make Ajax calls
            data:myData, //Form variables
            success:function(response){
                $('#test_table').bootstrapTable('refreshOptions', {url: 'req/tabtestsGetTable.php'});
                $('#testmulti_table').bootstrapTable('refreshOptions', {url: 'req/tabtestsGetTableMulti.php'});
                $('#testtas_table').bootstrapTable('refreshOptions', {url: 'req/tabtestsGetTas.php'});
                return false;
			},
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError);
			}
		});
	});
};

function addTasClick_all(e){
    $(".se-pre-con").fadeIn("fast",function(){
        var idt=$('#testsel').val();
        var checkValues = $('input[name=checkboxlist]:checked').map(function()
		{
			return "'"+$(this).val()+"'";
		}).get();
        var myData = 'idtest=' + idt+'&cv='+encodeURIComponent(checkValues); //build a post data structure
        jQuery.ajax({
            type: "POST", // HTTP method POST or GET
            url: "req/response.php", //Where to make Ajax calls
            data:myData, //Form variables
            success:function(response){
                $('.cbs').prop('checked', true);
                $('#test_table').bootstrapTable('refreshOptions', {url: 'req/tabtestsGetTable.php'});
                $('#testmulti_table').bootstrapTable('refreshOptions', {url: 'req/tabtestsGetTableMulti.php'});
                $('#testtas_table').bootstrapTable('refreshOptions', {url: 'req/tabtestsGetTas.php'});
                alert("Nb de séjours insérés : "+response); 
                return false;
			},
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError);
			}
		});
	});
};
function delTasClick_all(e){
    $(".se-pre-con").fadeIn("fast",function(){
        var idt=$('#testsel').val();
        var checkValues = $('input[name=checkboxlist]:checked').map(function()
		{
			return "'"+$(this).val()+"'";
		}).get();
        var myData = 'delidtest=' + idt+'&cv='+encodeURIComponent(checkValues); //build a post data structure
        jQuery.ajax({
            type: "POST", // HTTP method POST or GET
            url: "req/response.php", //Where to make Ajax calls
            data:myData, //Form variables
            success:function(response){
                $('.cbs').prop('checked', true);
                $('#test_table').bootstrapTable('refreshOptions', {url: 'req/tabtestsGetTable.php'});
                $('#testmulti_table').bootstrapTable('refreshOptions', {url: 'req/tabtestsGetTableMulti.php'});
                $('#testtas_table').bootstrapTable('refreshOptions', {url: 'req/tabtestsGetTas.php'});
                alert("Nb de séjours retirés : "+response); 
                return false;
			},
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError);
			}
		});
	});
};

function delTasClick(e){
    $(".se-pre-con").fadeIn("fast",function(){
        var idrss=e.target.id; 
        var myData = 'delidrss=' + idrss; //build a post data structure
        jQuery.ajax({
            type: "POST", // HTTP method POST or GET
            url: "req/response.php", //Where to make Ajax calls
            data:myData, //Form variables
            success:function(response){
                $('#test_table').bootstrapTable('refreshOptions', {url: 'req/tabtestsGetTable.php'});
                $('#testmulti_table').bootstrapTable('refreshOptions', {url: 'req/tabtestsGetTableMulti.php'});
                $('#testtas_table').bootstrapTable('refreshOptions', {url: 'req/tabtestsGetTas.php'});
                return false;
			},
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError);
			}
		});
	});
};

function hideTasClick(e){
    $(".se-pre-con").fadeIn("fast",function(){
        var idrss=e.target.id; 
        var myData = 'hideidrss=' + idrss; //build a post data structure
        jQuery.ajax({
            type: "POST", // HTTP method POST or GET
            url: "req/response.php", //Where to make Ajax calls
            data:myData, //Form variables
            success:function(response){
                $('#test_table').bootstrapTable('refreshOptions', {url: 'req/tabtestsGetTable.php'});
                $('#testmulti_table').bootstrapTable('refreshOptions', {url: 'req/tabtestsGetTableMulti.php'});
                $('#testtas_table').bootstrapTable('refreshOptions', {url: 'req/tabtestsGetTas.php'});
                return false;
			},
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError);
			}
		});
	});
};
function valTasClick(e){
    $(".se-pre-con").fadeIn("fast",function(){
        var myData = 'valtas=1'; //build a post data structure
        jQuery.ajax({
            type: "POST", // HTTP method POST or GET
            url: "req/response.php", //Where to make Ajax calls
            data:myData, //Form variables
            success:function(response){
                $('#test_table').bootstrapTable('refreshOptions', {url: 'req/tabtestsGetTable.php'});
                $('#testmulti_table').bootstrapTable('refreshOptions', {url: 'req/tabtestsGetTableMulti.php'});
                $('#testtas_table').bootstrapTable('removeAll');
                $('#testtas_table').bootstrapTable('refreshOptions', {url: 'req/tabtestsGetTas.php'});
                return false;
			},
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError);
			}
		});
	});
};

function euroSorter(a, b) {
    a = parseFloat(a.replace(",",".").slice(0,-2).replace(" ","").replace(",",".")); // remove $
    b = parseFloat(b.slice(0,-2).replace(" ","").replace(",",".")); // remove $
    if (a > b) return 1;
    if (a < b) return -1;
    return 0;
}
function pad(n) { return ("0" + n).slice(-2); }
function dateFormatter(value) {
    var date = new Date(value);
    return date.toLocaleDateString("fr")+" "+pad(date.getHours())+":"+pad(date.getMinutes());
}

function queryParams() {
    var idt=$('#testsel').val();
    var checkValues = $('input[name=checkboxlist]:checked').map(function()
	{
		return "'"+$(this).val()+"'";
	}).get();
    var cv=checkValues;
    return {
        type: 'owner',
        sort: 'updated',
        direction: 'desc',
        per_page: 10,
        page: 1,
        cv: cv
	};
}
function queryParams2() {
    var checkValues = $('input[name=checkboxlist2]:checked').map(function()
	{
		return "'"+$(this).val()+"'";
	}).get();
    var cv=checkValues;
    return {
        type: 'owner',
        sort: 'updated',
        direction: 'desc',
        per_page: 5,
        page: 1,
        cv: cv
	};
}
function queryParams3() {
    var checkValues = $('input[name=checkboxlist3]:checked').map(function()
	{
		return "'"+$(this).val()+"'";
	}).get();
    var cv=checkValues;
    return {
        type: 'owner',
        sort: 'updated',
        direction: 'desc',
        per_page: 5,
        page: 1,
        cv: cv
	};
}

function smallFontCS(value, row, index, field) {
    return {
        css: {"font-size": "10px"}
	};
}
