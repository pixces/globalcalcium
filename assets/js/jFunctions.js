// JavaScript Document

$(function(){
	
	/* submit search form */
	$("#productSearch").submit(function(){
								
		var error = "";
		if ($("#search-box").val() == ''){
			error += "- Search term not found\n";	
		}
		
		if (error){
			alert("Check errors :\n"+error);
			return false;
		}
		
	});
	
	$('#newsList').innerfade({
		animationtype: 'fade',
		speed: 1000,
		timeout: 5000,
		type: 'random',
		containerheight: '1em'
	});
	
});








/*
* Function to get the testimonials
*/

function showTestimonial(id){
	
	var id = jQuery.trim(id);
	//$("#testimonial").html('<div class="ajax_loader"><img src="assets/images/ajax-loader-2.gif" /> Loading</div>');	
	$("#testimonial").load("ajax.common.php?type=testimonial&id="+id);
}

function remove_notice(){
	$('#messageBox').animate({opacity: 1.0}, 8000).fadeOut('slow');
	$('#errorBox').animate({opacity: 1.0}, 8000).fadeOut('slow');
};
