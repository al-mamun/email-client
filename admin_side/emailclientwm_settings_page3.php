<h2><?php print EMAILCLIENTWM_PUGIN_NAME ." ". EMAILCLIENTWM_CURRENT_VERSION; ?></h2>

<form method="post" action="options.php">   
<?php
		settings_fields( 'emailclientwm-settings-group' );
?>
    <table class="form-table">
		<?php		
		$lc = md5(get_option('emailclientwm_lc')); 
		if ($lc != EMAILCLIENTWM_LC AND strtotime(get_option('emailclientwm_date')) > strtotime('yesterday -3 day')){
		echo '<div style="background:#fdd8d8;padding:5px;float:left;border:1px solid #f68888">3 Day Trial Period from '.get_option('emailclientwm_date').'</div>';		
		} ?>
        <tr valign="top" class="lic">
        <th scope="row">Licence Key</th>
        <input type="hidden" name="emailclientwm_date" value="<?php echo get_option('emailclientwm_date'); ?>" />        
        <td><input type="text" name="emailclientwm_lc" value="<?php echo get_option('emailclientwm_lc'); ?>" /></td>
        </tr> 
		
		<tr valign="top">
        <th scope="row">Default Email</th>
        <td><input type='checkbox' name='emailclientwm_default' value='1' <?php $options = get_option('emailclientwm_default');  if ( 1 == $options ) echo 'checked="checked"'; ?> />(Check if you want 1 email to be signed when logged in to WP)</td>
        </tr>
		
        <tr valign="top">
        <th scope="row">Email Address</th>
        <td><input type="text" name="emailclientwm_email" class="emailclientwm_email" value="<?php echo get_option('emailclientwm_email'); ?>" /></td>
        </tr>
		
		<tr valign="top">
        <th scope="row">Email password</th>
        <td><input type="password" name="emailclientwm_pass" value="<?php echo get_option('emailclientwm_pass'); ?>" /></td>
        </tr>
    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>