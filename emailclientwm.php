<?php
/*
Plugin Name: Email Client WM
Plugin URI: http://profound-english.com
Description: The Email Client WM WordPress plugin allows you to use Webmail Lite email client inside of the admin area.
Version: 2.0
Author: PG
Author URI: http://profound-english.com
*/

/*  Copyright 2014  http://profound-english.com  (email : info@profound-english.com)
   
*/
?><?php

// some definition we will use
define( 'EMAILCLIENTWM_PUGIN_NAME', 'Email Client WM');
define( 'EMAILCLIENTWM_PLUGIN_DIRECTORY', 'email-client');
define( 'EMAILCLIENTWM_CURRENT_VERSION', '2.0' );
define( 'EMAILCLIENTWM_CURRENT_BUILD', '3' );
define( 'EMAILCLIENTWM_LC', 'ca9186101695c5e9922e84745d6ba708' );
define( 'EMAILCLIENTWM_DEBUG', false);		# never use debug mode on productive systems
if (!defined('EMU2_I18N_DOMAIN')) define('EMU2_I18N_DOMAIN', 'emailclientwm');

add_action( 'admin_init', 'emailclientwm_register_settings' );
function emailclientwm_register_settings() {
	//register settings
	register_setting( 'emailclientwm-settings-group', 'emailclientwm_lc' );	
	register_setting( 'emailclientwm-settings-group', 'emailclientwm_date' );	
	register_setting( 'emailclientwm-settings-group', 'emailclientwm_default' );	
	register_setting( 'emailclientwm-settings-group', 'emailclientwm_email' );	
	register_setting( 'emailclientwm-settings-group', 'emailclientwm_pass' );	
}


register_activation_hook(__FILE__, 'emailclientwm_activate');
register_deactivation_hook(__FILE__, 'emailclientwm_deactivate');
register_uninstall_hook(__FILE__, 'emailclientwm_uninstall');

// activating the default values
function emailclientwm_activate() {
	$datum = date('Y-m-d');	
	add_option('emailclientwm_lc', '');
	add_option('emailclientwm_date', $datum);
	add_option('emailclientwm_default', 0);
	add_option('emailclientwm_email', '');
	add_option('emailclientwm_pass', '');
}

// deactivating
function emailclientwm_deactivate() {
	// needed for proper deletion of every option	
	delete_option('emailclientwm_lc');	
	delete_option('emailclientwm_default');
	delete_option('emailclientwm_email');
	delete_option('emailclientwm_pass');	
}

// uninstalling
function emailclientwm_uninstall() {
	# delete all data stored	
	delete_option('emailclientwm_lc');	
	delete_option('emailclientwm_default');
	delete_option('emailclientwm_email');
	delete_option('emailclientwm_pass');	
}

// create custom plugin settings menu
add_action( 'admin_menu', 'emailclientwm_create_menu' );
function emailclientwm_create_menu() {

	// create new top-level menu
	add_menu_page( 
	__('Email', EMU2_I18N_DOMAIN),
	__('Email', EMU2_I18N_DOMAIN),
	0,
	EMAILCLIENTWM_PLUGIN_DIRECTORY.'/admin_side/emailclientwm_settings_page.php',
	'',	
	plugins_url('/img/icon.png', __FILE__));
	
	add_submenu_page( 
	EMAILCLIENTWM_PLUGIN_DIRECTORY.'/admin_side/emailclientwm_settings_page.php',
	__("Admin Panel", EMU2_I18N_DOMAIN),
	__("Admin Panel", EMU2_I18N_DOMAIN),
	0,
	EMAILCLIENTWM_PLUGIN_DIRECTORY.'/admin_side/emailclientwm_settings_page2.php'
	);	
	
	add_submenu_page( 
	EMAILCLIENTWM_PLUGIN_DIRECTORY.'/admin_side/emailclientwm_settings_page.php',
	__("Configuration", EMU2_I18N_DOMAIN),
	__("Configuration", EMU2_I18N_DOMAIN),
	0,
	EMAILCLIENTWM_PLUGIN_DIRECTORY.'/admin_side/emailclientwm_settings_page3.php'
	);				
}



$lc = md5(get_option('emailclientwm_lc')); 
if($lc == EMAILCLIENTWM_LC || strtotime(get_option('emailclientwm_date')) > strtotime('yesterday -3 day')){
add_action('admin_bar_menu', 'add_toolbar_items', 100);}
function add_toolbar_items($admin_bar){
    $admin_bar->add_menu( array(
        'id'    => 'my-item',
        'title' => '<div class="wrapperer"><span class="emo"></span><div class="unread_holder"></div></div>',
        'href'  => 'admin.php?page=email-client/admin_side/emailclientwm_settings_page.php',		
        'meta'  => array(
            'title' => __('My Item'), 
        ),
    ));    
}

// create custom plugin settings menu
if($lc == EMAILCLIENTWM_LC || strtotime(get_option('emailclientwm_date')) > strtotime('yesterday -3 day')){
add_action( 'admin_footer', 'emailclientwm_email_unread' );}
function emailclientwm_email_unread() {
	wp_register_style( 'custom-style', plugins_url( '/css/styles.css', __FILE__ ), array(), '20120208', 'all' );  	
	wp_enqueue_style( 'custom-style' );	 
	
	$options = get_option('emailclientwm_default'); 
	$email_info = get_option('emailclientwm_email'); 
	$pass_info = get_option('emailclientwm_pass'); 	  



	session_start();	
	if($options == 1 AND $_SESSION['email']==$email_info || !isset($_SESSION['email'])){		
	echo '<script>	
	jQuery( document ).ready(function() {	
	// use defualt email
	var Email = "'.$email_info.'";
	var Password = "'.$pass_info.'";
	
	jQuery.post(
		"'. plugins_url( 'admin_side/webmailing/respond-frame.php', __FILE__ ) .'",
		{ Email:Email,Password:Password},
		function(event) {    
			    //location.reload();			
			}    
		);				
	});
	</script>';			
	}
	echo '<script>	
	jQuery( document ).ready(function() {	
	// load unread data
	jQuery( ".unread_holder" ).load( "'. plugins_url( '/admin_side/webmailing/load.php', __FILE__ )  .' .unread" ); 
	jQuery( ".emo" ).load( "'. plugins_url( '/admin_side/webmailing/load.php', __FILE__ )  .' .cur_emo" );  
	 setInterval(function(){ 
	 jQuery( ".unread_holder" ).append("<img src=\"'. plugins_url( '/admin_side/webmailing/img/loader.gif', __FILE__ )  .'\" style=\"position:relative;top:2px;left:5px\" />").load( "'. plugins_url( '/admin_side/webmailing/load.php', __FILE__ )  .' .unread" ); 
	 jQuery( ".emo" ).load( "'. plugins_url( '/admin_side/webmailing/load.php', __FILE__ )  .' .cur_emo" );   
	 }, 15000);	

	
	//logout webmail when loggout OC
	jQuery("#wp-admin-bar-user-actions .ab-item").click(function (event) { 	
	event.preventDefault();	
	jQuery.post(
		"'. plugins_url( 'admin_side/webmailing/killsession.php', __FILE__ ) .'",
		{ },
		function(event) {        
			window.location.href = "'.wp_logout_url( $redirect ).'";
			}    
	);				
	})	});
	</script>';	
}

