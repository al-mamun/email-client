$( document ).ready(function() {	
	// load unread data
	$( ".unread_holder" ).load( "admin_side/webmailing/load.php' .unread" ); 
	$( ".emo" ).load( "../admin_side/webmailing/load.php .cur_emo" );  
	setInterval(function(){ 
	$( ".unread_holder" ).append("<img src=\"../admin_side/webmailing/img/loader.gif\" style=\"position:relative;top:2px;left:5px\" />").load( "/admin_side/webmailing/load.php .unread" ); 
	$( ".emo" ).load( "../admin_side/webmailing/load.php .cur_emo" );   
	}, 15000);	

	
	//logout webmail when loggout OC
	$(".ab-item").click(function (event) { 	
	event.preventDefault();
	alert("working");
	$.post(
		"../admin_side/webmailing/killsession.php",
		{ },
		function(event) {        
			window.location.href = "/wp-login.php?loggedout=true";
			}    
	);				
	})	});