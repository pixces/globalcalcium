// JavaScript Document
$(document).ready(function(){
	//alert("I am ready");
	

});


/***
* functiont to toggle
*/
function toggleMe(id){
	$("#row_"+id).load("quote_list.php?quoteId="+id);
	$("#row_"+id).toggle("slow")
	return false;
}

