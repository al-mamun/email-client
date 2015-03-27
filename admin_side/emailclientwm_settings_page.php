<h2><?php print EMAILCLIENTWM_PUGIN_NAME ." ". EMAILCLIENTWM_CURRENT_VERSION; ?></h2>
 <?php
		settings_fields( 'emailclientwm-settings-group' );		
		$lc = md5(get_option('emailclientwm_lc')); 
		if ($lc == EMAILCLIENTWM_LC || strtotime(get_option('emailclientwm_date')) > strtotime('yesterday -3 day')){
	?>
<?php //if the installer folder exists 

	    $filename = plugin_dir_path(__FILE__) .'webmailing/install/';		
		
		if(file_exists($filename)) { 

		echo '<iframe src="'.plugins_url('webmailing/install/', __FILE__).'" style="width:100%;height:800px;border:none;"></iframe>';

		} else {

	    echo '<iframe src="'.plugins_url('webmailing/embed-frame.php', __FILE__).'" style="width:100%;height:800px;border:none;"></iframe>';

	    }     
?>
		<?php } else { ?>

<div class="disclaimer">To obtain the licence key you need to purchase a license. This fee is for the plugin, not the WebMail lite, which is for free.<br> If you need support with the set-up, please contact us at <a href="mailto:info@profound-english.com">info@profound-english.com</a>

<p>The cost of the license is $10. After you pay you will receive the license key into your email which will enable you to use the Email Client WM going forward.<br> It might take 1 - 3 bussiness days.</p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="4XREVXGG8E7XE">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

</div>

		<?php } ?>