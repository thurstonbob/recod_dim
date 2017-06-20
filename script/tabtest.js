$(document).ready(function (e) {
	$(".main").load("tabtests.php");
	$("ul.navbar-nav li a").click( function(e){
		$(".main").load($(this).attr("data-page")+".php");
	});
	$(window).load(function() {
		$(".se-pre-con").fadeOut("slow");
	});
});
/*
	
*/

