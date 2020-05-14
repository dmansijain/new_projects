/**********Open Menu**********/
$(document).ready(function () {
	$('#sidebar').click(function(){
		$('.sidenav, .main_cont').toggleClass("hidemenu");
	});
	
	$('.srch').click(function(){
		$('#searchinput').toggleClass("opensearch");
	});
});


/**********Nav Toggle**********/
$(document).ready(function(){
	$('.toggle-nv').click(function(){
		$('.tabs-left').toggleClass('shownav');	
	})
})


/**********sidenav scroll**********/
$(document).ready(function () {
	$(".sidenav").mCustomScrollbar({
		theme: "minimal"
	});
});


/**********Data Tables**********/
$(document).ready(function() {
    $('#to-be-assign').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#assign-loads').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#intransit').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#deliver').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#WaitingApproval').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#Approved-tbl').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#all-appointment').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#current-appointment').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#upcoming-appointment').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#recent-appointment').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#delayed-appointment').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#all-drivers').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#dispatch-drivers').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#recently-served-drivers').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#loads-in-transit').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#pending-loads').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#loads-delivered').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#empties-available').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#upcoming-schedule').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#exams').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#truck-vendor').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#air-vendor').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#ocean-vendor').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#availability-empty').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#availability-loads').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#past-dues').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#past-dues-breakup').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
	$('#per-diem').DataTable({"pageLength":8,"bLengthChange":false,"bInfo":false});
} );

/**********Link ON TR**********/
jQuery(document).ready(function($) {
    $(".linktable>tbody>tr").click(function() {
        window.location = $(this).data("href");
    });
});


/**********datepicker**********/
$(function () {
	$('#reminder').datetimepicker();
	$('#available-slot').datetimepicker();
});




