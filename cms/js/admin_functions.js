// JavaScript Document
$(document).ready(function(){
	
	doPreview();	// Initialize the function

	/**
	* Window modal for Change Password 
	*/
	$("#popUp").click(function(){  

		//centering with css  
		 centerPopup();  
		 //load popup  
		 loadPopup();  
	 });

	//CLOSING POPUP
	//Click the x event!
	$("#popupContactClose").click(function(){
		disablePopup();
	});
	
	
	//Click out event!
	$("#backgroundPopup").click(function(){
		disablePopup();
	});
	
		
	/**
	* submit the admin ADD form
	* do proper validation with the email
	* ajax submit the data
	*/
	$("form#admin_form").submit(function(){
		//do the validation
		var mm_action = $("#mm_action").val();
		var fname = $("#fname").val();
		var email = $("#email").val();
		var username = $("#username").val();
		var error = '';

		/* validate for adding */		
		if (!jQuery.trim(fname)){ 
			error += "- Please enter admin name\n"; 
		}
		if (!jQuery.trim(email)){ 
			error += "- Please enter admin email address\n"; 
			} else {
				//check for validity of email address
			var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			if(reg.test(jQuery.trim(email)) == false) {
			error += "- Invalid Email Address";
			}
		}
		if (!jQuery.trim(username)) { 
			error += "- Please enter admin username\n"; 
		}
		
		if (error) {
			alert("Please check errors:\n" + error);
			return false;
		}	
				
		var dataStr = $("form#admin_form").serialize();
		//alert(dataStr); return false;
		
		if (jQuery.trim(mm_action) == 'doEdit')	{
			var ajax_url = "manage-admin.php?type=edit";	
			} else if (jQuery.trim(mm_action) == 'doAddAdmin') {
				var ajax_url = "manage-admin.php?type=add";	
				} else {
					alert("Invalid Data Submitted");
					return false;
		}
		
		$.ajax({
		type: "post",
		data: dataStr,
		url : ajax_url,
		success : function(data){
			if (jQuery.trim(data)) {
				if(ajax_url == "manage-admin.php?type=add") {
					alert("New admin has been successfully created.\n An email with the password has been sent to the email address provided");
					}
					if(ajax_url == "manage-admin.php?type=edit") {
						alert("Admin details have been changed successfully");
					}
					window.location = "manage-admin.php";
					return false;
					} else {
						return false;
				}
			}		
		});
	
	return false;
	});
	
	
	//alert("Ima ready");
	// Portfolio Image Add Form
	$("form#portf_form").submit(function() {
						
		var imageId = jQuery.trim($("#portf_id").val());
		var imageName = jQuery.trim($("#portf_img").val());
		var category = jQuery.trim($("#portf_categ").val());
		var portf_desc = jQuery.trim($("#portf_desc").val());
		var error = '';
		// Basic Validation
		if(!imageId){
			if(!imageName){ error += " \t- Please Select an image for portfolio.\n"; }
		}
		if(!category){ error += " \t- Please Select portfolio category.\n"; }
		if(!portf_desc){ error += " \t- Please enter the portfolio description.\n"; }
		if(error){ alert("Check the following error(s):\n" + error); return false; }
		
	});
	
	// Invoke the check all function 
	selectAll();
	
});

this.doPreview = function() {	
	/* CONFIG */
	xOffset = 10;
	yOffset = 30;
		
	// these 2 variable determine popup's distance from the cursor
	// you might want to adjust to get the right result
		
	/* END CONFIG */
	$("a.preview").hover(function(e) {							  
				
		var image_name = this.id;			
		$("body").append("<p id='preview'><img src='"+ image_name +"' alt='Image preview' height='250' /></p>");						 
		$("#preview")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px")
			.fadeIn("slow");						
    },
	function(){
		//this.title = this.t;	
		$("#preview").remove();
    });	
	$("img.preview").mousemove(function(e){
		$("#preview")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
	});			
};


/**
* javascript function to delete portfolio
**/
function portf_delete(id){
	
	//on click first higlite it with red
	$("#row_"+id).css({"background":'#FFEAEA'});
	//alert(id); return false;
	var t = confirm("Are you sure you want to delete this portfolio?");
	if (t)
		{
			$.post("portfolio.php?type=delete", { id: id },
			  function(data){
				   if (jQuery.trim(data) == "success")
					{
						$("#row_"+id).animate({'opacity':'0'},1000,function(){
						$("#row_"+id).remove();
						window.location = "portfolio.php";
							});
					} else {
						alert("Cannot delete portfolio.");	
						return false;
						}
			});
			
			return false;

	} else {
			$("#row_"+id).css({"background":'#FFF'});
			return false;
			}
}




/**
* Function to subscribe emails with all selected function
*/
function subscribeAll(){	
	var dataStr = $("#user_email_list").serialize();
	
	if(!dataStr){
		alert("Please select email id to subscribe");
		return false;
	}
	
	$.ajax({
		type: "post",
		data: dataStr,
		url : "subscribers.php?type=subxAll",
		success : function(data){
			alert("Selected emails are subscribed");
			$("#list_nav").load("email_list.php");
			return false;
		}		
	});
}


/**
* Function to unsubscribe emails with all selected function
*/
function unSubscribeAll(){
	var dataStr = $("#user_email_list").serialize();
	if(!dataStr){
		alert("Please select email id to unsubscribe");
		return false;
	}
	
	$.ajax({
		type: "post",
		data: dataStr,
		url : "subscribers.php?type=unsubxAll",
		success : function(data){
				alert("Selected emails are unsubscribed");
				$("#list_nav").load("email_list.php");
				return false;
		}		
	});
}


/**
* Function to delete emails with all selected functions
*/
function deleteAll(){
	
		var dataStr = $("#user_email_list").serialize();
		if(!dataStr){
			alert("Please select email id to delete");
			return false;
		}
		var delC = confirm("Are you sure want to delete selected emails ?");
		if(delC){	
				$.ajax({
					type: "post",
					data: dataStr,
					url : "subscribers.php?type=delAll",
					success : function(data){
							alert("Selected email id deleted successfully");
							$("#list_nav").load("email_list.php");
							return false;
							}		
					});
				} else {
				return false;
		}
}

/**
* Fucntion to check / uncheck the select boxes
*/
function selectAll(){
		$("#checkAll").click(function() {
			var checked_status = this.checked;
			if (checked_status)	{
				$('input[id=check]').attr('checked', 'checked');
				} else {
					$('input[id=check]').removeAttr('checked', 'checked');
			}
		 });
}


// Function for Validating the NewsLetter Form

function validateNewsLetter(){
	var error = "";
	var error2 = "";
	var email =$("#nlAddr").val();				
	var valid = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	
	if(!jQuery.trim( $("#nlSub").val())) {
		error += "Please enter the subject\n";
	}
	
	if(!jQuery.trim($("#nlMessage").val() )) {
		error += "Please enter the message\n";
	}
	
	if(jQuery.trim(email)) {
			if(valid.test(jQuery.trim(email)) == false)	{ 
					error+= "- Invalid Email Address";
			}	
	}
	
	if(error) {
		alert("Check error:\n" + error);
		return false;
		}
		else {
		return true;
	}
}


// Commom Function to delete subscriber / NewsLetter 

function deleteN(){
	var del = confirm("Are you sure to want to delete?");	
	if(del == true){
		return true;
		} else {
			return false;
	}
}

// Function to add one more Add Image button

var c = 1; 
function add_more() {
		var txt = '';
		
		txt+= "<tr id='row_"+c+"'><td width='50'></td><td><div align='left'><input type='file' name='content_image[]' id='content_image"+c+"'> &nbsp; ";
		txt+="<a href='javascript:add_more();'><img src='images/plus.jpg' width='16' height='16' border='0' /></a> &nbsp; ";
		txt+="<a href='javascript:remove_one("+c+");'><img src='images/remove.png' width='16' height='16' border='0' /></a></div>";
		txt+="</td></tr>";
		
		$("#contentTable tr:last").before(txt);
		c++;
	}

//Function to Remove Image button

function remove_one(trId){	
	$("#row_"+trId).remove();
}

// Funciton to add more tests specifications
var d = 1; 
function add_more_tests(){
	
	var txt = '';		
	txt += '<tr>';
	txt += '<td valign="top">';
	txt += '<div align="left">';
	txt += '<textarea name="product_test[]" id="product_test" cols="29" ></textarea>';
	txt += '</div>';
	txt += '</td>';
	txt += '<td valign="top" align="left">';
	txt += '<div align="left">';
	txt += '<textarea name="product_specification[]" id="product_specification" cols="25" ></textarea>';
	txt += '</div>';
	txt += '</td>';
	txt += '<td valign="top" align="left">';
	txt += '<div align="left">';
	txt += '<textarea name="product_reference[]" id="product_reference" cols="25" ></textarea>';
	txt += '</div>';
	txt += '</td>';
	txt += '<td align="left">';
	txt += '<a href="javascript:add_more_tests();"><img src="images/ico_add_doc.png" width="16" height="16" border="0" /></a>&nbsp;';
    txt += '<a href="javascript:remove_tests({$productTestDet[tests].id});"><img src="images/ico_remove_doc.png" width="16" height="16" border="0" /></a>';
	txt += '</td>';
	txt += '</tr>';

	$("#productTests tr:last").before(txt);
	d++;
}

function remove_tests(id){
	$("#row_test_"+id).remove();
}

//  Function for validating the content form
function validateContentForm(){
	var error = "";
	
	if (!jQuery.trim( $("#linkList").val() ) ){
			error += "-Please select the link\n";
	}
	if (!jQuery.trim( $("#page_title").val() ) ){
			error += "-Please enter the page title\n";
	}
	if (!jQuery.trim( $("#sef_title").val() ) ){
			error += "-Please enter the SEF Title\n";
	}	
	if (error){
		alert("Check error:\n" + error);
		return false;
		} else {
			return true;
	}

	
}

// Function to validate the validateProductForm
function validateProductForm(){
	error = "";
	productName = $.trim($("#page_title").val());
	if(!productName){
		error += "-Enter the product name\n";
	}
	sefTitle = $.trim($("#sef_title").val());
	if(!sefTitle){
		error += "-Enter the SEF name\n";
	}
	
	if(error){
		alert("Please check the following errors\n"+error);
		return false;
		} else {
			return true;
	}
	
}

//  Function for DELETING  the content 
function deleteContent(varName){
	//$("#row_"+id).css({"background":'#FFEAEA'});
	var t = confirm("Are you sure want to delete content page ?");	
	if(t == true){
		return true;
		} else {
			return false;
	}
}

//	Function to limit the text in text area
function limtTextArea() {
	var textField = $("#portf_desc").val();	
	var charLength = textField.length;
	$('span#charCount').html(charLength + ' of 150 characters used');
	if(charLength > 150)	{
		$('span#charCount').html('You may only have up to 150 characters.');
		$("#portf_desc").val(textField.substring(0,150));
	}
}


/**
* Functions for Modal window
*/
 //0 means disabled; 1 means enabled;  
var popupStatus = 0; 

//loading popup with jQuery magic!
function loadPopup(){
	//loads popup only if it is disabled
	if(popupStatus==0){
		$("#popupform").load("change_password.php");	
		$("#backgroundPopup").css({"opacity": "0.7"});
		$("#backgroundPopup").fadeIn("slow");		
		$("#popupContact").fadeIn("slow");
		popupStatus = 1;
	}
}



//disabling popup with jQuery magic!
function disablePopup(){
	//disables popup only if it is enabled
	if(popupStatus==1){
		$("#backgroundPopup").fadeOut("slow");
		$("#popupContact").fadeOut("slow");
		popupStatus = 0;
	}
}

//centering popup
function centerPopup(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $("#popupContact").height();
	var popupWidth = $("#popupContact").width();
	//centering
	$("#popupContact").css({
	"position": "absolute",
	"top": windowHeight/2-popupHeight/2,
	"left": windowWidth/2-popupWidth/2
	});
	//only need force for IE6
	
	$("#backgroundPopup").css({
	"height": windowHeight
	});

}


// Function to validate the Add link Form
function validateForm(){
	var error = "";
	if (!jQuery.trim( $("#linkName").val() ) ) {
		error += "-Please enter link name\n";
	}
		
	if (error) {
		alert("Check error:\n" + error);
		return false;
		} else {
		return true;
	}
}

// Function to delete the Site link
function deletelink(varName){
	var t = confirm("Are you sure want to delete "+varName+" page ?");	
	if(t == true){
		return true;
		} else {
			return false;
	}
}


/**
* Function to show or hide Primary or secondary Check button
*/

function showOrHide(){
	var Classes = document.getElementById("parentLink")
	if(Classes.selectedIndex != 0) {
		document.getElementById("rd_primary").disabled = true;
		document.getElementById("rd_secondary").disabled = true;
      	}  else {
			document.getElementById("rd_primary").disabled = false;
			document.getElementById("rd_secondary").disabled = false;
	}	  
}

/**
// Function to Delete admin
**/
function deleteAdmin(){
	var deltC = confirm("Are you sure you want to delete 'this admin user'?");
	if(deltC){
		return true;
		} else {
			return false;
	}
}

// Function to add SEF URL
function addSefUrl(){		
	var page_title = jQuery.trim($('#page_title').val());	
	//$('#sef_title').val(page_title);
	//alert(page_title);
	$.ajax({
		type: "post",
		data: { title: page_title },
		url : "./ajax_sef.php",
		success : function(data){			
			if (jQuery.trim(data)) {
				$('#sef_title').val(data);
			}		
		}
		});
	return false;
}

// function to validate meta tag information
function validateMeta(){
	var error = '';
	if(!jQuery.trim( $("#page_title").val())){
		error += "\t Please enter the page title.\n";
	}
	if(!jQuery.trim( $("#metaDesc").val())){
		error += "\t Please enter the meta description.\n";
	}
	if(!jQuery.trim( $("#metaKey").val())){
		error += "\t Please enter the meta Key.\n";
	}
	if(error){
		alert("Please Check the following error(s)\n"+error);
		return false;
		} else {
		return true;
	}
}

