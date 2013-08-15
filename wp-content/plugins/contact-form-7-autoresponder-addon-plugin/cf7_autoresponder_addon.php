<?php
/*
 Plugin Name: Contact Form 7 AutoResponder Addon Plugin
 Plugin URI: http://wpsolutions-hq.com
 Description: Allows you to add your visitors to your Mailchimp AutoResponder list when they submit a message using Contact Form 7
 Author: WPSolutions-HQ
 Version: 1.5
 Author URI: http://wpsolutions-hq.com
 */
define( 'CF7ADDON_PATH', dirname(__FILE__) . '/' );
if (!class_exists('MCAPI')) {
	include_once ( CF7ADDON_PATH . 'inc/MCAPI.class.php' );
}

add_action('plugins_loaded', 'cf7_addon_execute_plugins_loaded_operations');

function cf7_addon_execute_plugins_loaded_operations() {
	if(!function_exists('wpcf7_install')){
		add_action('admin_notices', 'cf7_addon_conflict_check');		
		return;
	}	
	// Add a menu for our options page
	add_action('admin_menu', 'cf7_autoresp_addon_add_page');
}

function cf7_addon_conflict_check(){
	echo '<div class="error fade"><p>Attention! You do not have the <a href="http://contactform7.com/" target="_blank">Contact Form 7 plugin</a> active! The Contact Form 7 AutoResponder Addon Plugin can only work if Contact Form 7 is active.</p></div>';
}

function cf7_autoresp_addon_add_page() {
	add_options_page( 'CF7 AutoResp Addon', 'CF7 AutoResp Addon', 'manage_options', 'cf7_autoresp_addon', 'cf7_autoresp_addon_option_page' );
}

// Draw the admin page
function cf7_autoresp_addon_option_page() {
	$mc_enabled = 0;
	$mc_api_key = '';
	$mc_list_name = '';

	//process form submission
	if (isset($_POST['Submit'])){
		if ($_POST['mc-api'] != "") {
			$_POST['mc-api'] = filter_var($_POST['mc-api'], FILTER_SANITIZE_STRING);
			if ($_POST['mc-api'] == "") {
				$errors .= 'Please enter a valid api key.<br/><br/>';
			}
		} else {
			$errors .= 'Please enter your MailChimp API key.<br/>';
		}
		 
		if ($_POST['mc-list-name'] != "") {
			$_POST['mc-list-name'] = filter_var($_POST['mc-list-name'], FILTER_SANITIZE_STRING);
			if ($_POST['mc-list-name'] == "") {
				$errors .= 'Please enter a valid mailchimp list name.<br/>';
			}
		} else {
			$errors .= 'Please enter a MailChimp list name.<br/>';
		}
		if (!$errors)
		{
			if (isset($_POST['enable-mc'])) {
				$mc_enabled = 1;
			} else {
				$mc_enabled = 0;
			}

			if (isset($_POST['disable-double-opt'])) {
				$mc_disable_double_opt = false; //this means that we want to disable double optin emails
			} else {
				$mc_disable_double_opt = true;
			}
			
			//add the data to the wp_options table
			$options = array(
				'mc_enabled' => $mc_enabled,
				'mc_api_key' => $_POST['mc-api'],
				'mc_list_name' => $_POST['mc-list-name'],
				'mc_disable_double_opt' => $_POST['disable-double-opt']
			);
			update_option('cf7_autoresp_addon', $options); //store the results in WP options table
			echo '<div id="message" class="updated fade">';
			echo '<p>Settings Saved</p>';
			echo '</div>';
		}
		else
		{
			echo '<div style="color: red">' . $errors . '<br/></div>';
		}
	}
	if (get_option('cf7_autoresp_addon'))
	{
		$mc_settings = get_option('cf7_autoresp_addon');
		$mc_enabled = $mc_settings['mc_enabled'];
		$mc_api_key = $mc_settings['mc_api_key'];
		$mc_list_name = $mc_settings['mc_list_name'];
		$mc_disable_double_opt = $mc_settings['mc_disable_double_opt'];
	}
	?>
<div class="wrap">
<div id="poststuff"><div id="post-body">
<h2>Contact Form 7 AutoResponder Addon</h2>
<div class="postbox">
<h3>Enter Your MailChimp Account Details</h3>
<form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="POST"
	onsubmit="">
<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="enable-mc"> Enable Mailchimp List
		Insertion: </label></th>
		<td><input type="checkbox" name="enable-mc"
		<?php if($mc_enabled) echo ' checked="checked"'; ?> /></td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="MCAPIKey"> Enter MailChimp API Key:</label>
		</th>
		<td><input size="50" name="mc-api" value="<?php echo $mc_api_key; ?>" /></td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="MCListName"> Enter MailChimp List Name:</label>
		</th>
		<td><input size="50" name="mc-list-name"
			value="<?php echo $mc_list_name; ?>" /></td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="disable-double-opt"> Disable Double Opt-in Email: </label></th>
		<td><input type="checkbox" name="disable-double-opt"
		<?php if($mc_disable_double_opt) echo ' checked="checked"'; ?> />
		<span class="description"> When enabling this checkbox the plugin will ask MailChimp NOT to send a confirmation (double opt-in) email</span></td>
	</tr>
</table>
</div>
<input name="Submit" type="submit" value="Save Settings"
	class="button-primary" /></form>
</div></div>
<div style="border-bottom: 1px solid #dedede; height: 10px"></div>
<br />
<h5>Please support me by buying any of the following amazing plugins:</h5>
<a href="http://www.tipsandtricks-hq.com/wordpress-estore-plugin-complete-solution-to-sell-digital-products-from-your-wordpress-blog-securely-1059?ap_id=wpshq"
	target="_blank"> <img
	src="https://s3.amazonaws.com/product_banners/eStore_banner_468_60.gif"
	alt="WordPress Shopping Cart" border="0" /></a> <br />
<br />
<a href="http://www.tipsandtricks-hq.com/wordpress-emember-easy-to-use-wordpress-membership-plugin-1706?ap_id=wpshq"
	target="_blank"> <img
	src="https://s3.amazonaws.com/product_banners/wp_emember_banner_468x60.gif"
	alt="WordPress Membership Plugin" border="0" /></a></div>
		<?php
}

add_action( 'wpcf7_before_send_mail', 'contact7addonfunc' ); //use the cf7 hook

function contact7addonfunc($cf7) {
	$mailchimp_settings = get_option('cf7_autoresp_addon');
	$mc_api = $mailchimp_settings['mc_api_key']; //get api key from DB
	$mc_list = $mailchimp_settings['mc_list_name']; //get list name from DB
	$mc_enabled = $mailchimp_settings['mc_enabled']; //get global checkbox value for this feature
	$mc_disable_double_opt = $mailchimp_settings['mc_disable_double_opt'];
	
	//the following few lines will check if an "opt-in" checkbox has been added to the CF7 form
	$optin_box_exists = false; //assume by default a CF7 form will not have an "mc-subscribe" checkbox
	
	$form_id = $cf7->posted_data['_wpcf7']; //get form ID so we can search the post meta data table
	$form_meta_data = get_post_meta($form_id); //get the form meta-data so we can see if there is "mc-subscribe" checkbox
	
	$form_details = $form_meta_data['_form'][0];
	
	if (strpos($form_details, 'mc-subscribe') !== false)
	{
		$optin_box_exists = true;
	}
	
	if ($mc_enabled)
	{
		if (($optin_box_exists) && (!$cf7->posted_data['mc-subscribe']))
		{
			return; //do not subscribe if user has left opt-in box disabled
		}
		foreach($cf7->scanned_form_tags as $item) {
			if($item['type'] == 'submit') {
				if(strpos($item['raw_values'][0],"|")) {
					//error_log(print_r($item['raw_values'], true), 3, dirname( __FILE__ ).'/cf7_post.log' );
					$res = explode("|",$item['raw_values'][0]); //get the listname
					$mc_list = $res[1];
					break;
				}
			}
		}
		$email = $cf7->posted_data['your-email']; //get the submitted email address from CF7
		if (array_key_exists('your-name', $cf7->posted_data))
			$firstname = $cf7->posted_data['your-name']; //in case someone uses the standard default CF7 form
		else if (array_key_exists('your-first-name', $cf7->posted_data))
			$firstname = $cf7->posted_data['your-first-name']; //in case someone creates this field
			
		if (array_key_exists('your-last-name', $cf7->posted_data))
			$lastname = $cf7->posted_data["your-last-name"]; //in case someone creates this field
		else
			$lastname = '';

		$mergeVars = array(
			'FNAME'=>$firstname,
			'LNAME'=>$lastname,
		);
		
		$email_type = 'html'; //for some reason I need this in order to get the API to identify the disable_optin variable

		$api = new MCAPI($mc_api);
		$yourlists = $api->lists();
		foreach ($yourlists['data'] as $list){
			if($list['name'] == $mc_list)
			{
				$retval = $api->listSubscribe( $list['id'], $email, $mergeVars, $email_type, $mc_disable_double_opt); 	//add subscriber to mailchimp
			}
			if ($api->errorCode){
				error_log( "Unable to load listSubscribe()!\n", 3, dirname( __FILE__ ).'/cf7_autoresp.log' );
				error_log( "\tCode=".$api->errorCode."\n", 3, dirname( __FILE__ ).'/cf7_autoresp.log' );
				error_log( "\tMsg=".$api->errorMessage."\n", 3, dirname( __FILE__ ).'/cf7_autoresp.log' );
				return;
			} else {
			}
		}
	}
}
?>