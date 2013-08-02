<?php
/*
Plugin Name: Contact Us Form
Plugin URI: http://www.kenmoredesign.com/
Description: Standart Contact Us form on any page or post of your website. Simply insert [CONTACT-US-FORM] within any post or page.
Author: Kenmore Design LLC
Author URI: http://www.kenmoredesign.com/
Version: 1.1.1
*/

$cuf_version = '1.0';
$cuf_script_printed = 0;
$contact_us_form = new ContactUsForm();

class ContactUsForm
{

var $o;
var $captcha;
var $userdata;
var $nr = 0; 

function ContactUsForm()
{

	$this->o = get_option('contact_us_form');

	add_action('widgets_init', array( &$this, 'register_widgets'));

	add_action('admin_menu', array( &$this, 'addOptionsPage'));

	add_shortcode('CONTACT-US-FORM', array( &$this, 'shortcode'));

	add_action('wp_head', array( &$this, 'addStyle'));

	if ( function_exists('register_uninstall_hook') )
		register_uninstall_hook(ABSPATH.PLUGINDIR.'/contact-us-form/contact-us-form.php', array( &$this, 'uninstall')); 

	add_filter('plugin_action_links', array( &$this, 'pluginActions'), 10, 2);

	$this->setRecources();
}


function showForm( $params = '' )
{
	$n = ($this->nr == 0) ? '' : $this->nr;
	$this->nr++;

	if ( isset($_POST['cuf_senderfirst'.$n]) && isset($_POST['cuf_senderlast'.$n]) )
		$result = $this->sendMail( $n, $params );
		
	$captcha = new ContactUsFormCaptcha( rand(1000000000, 9999999999) );
    $form = '<div class="contactform" id="cuform'.$n.'">';
	
	if ( !empty($result) )
	{
		if ( $result == $this->o['msg_ok'] ) {
			$result = "<h2 class='contactform_respons'>".$result."</h2><p class='contactform_respons'>We'll get back to you shortly.</p>";
            $form .= '<script type="text/javascript"> $(".entry-content").html("'.$result.'").attr("id", "thanks"); </script>';
		}
		else

			$form .= '<p class="contactform_error">'.$result.'</p>';
	}
		
	if ( empty($result) || (!empty($result) && !$this->o['hideform']) )
	{
		if ( !empty($_POST['cuf_subject'.$n]) )
			$cuf_subject = $_POST['cuf_subject'.$n];
		else if ( is_array($params) && !empty($params['subject']))
			$cuf_subject = $params['subject'];
		else if ( empty($_POST['cuf_subject'.$n]) && !empty($_GET['subject']) )
			$cuf_subject = $_GET['subject'];

		else if ( empty($_POST['cuf_subject'.$n]) && !empty($this->userdata['subject']) )
			$cuf_subject = $this->userdata['subject'];
		else
			$cuf_subject = '';

		$cuf_senderfirst = (isset($_POST['cuf_senderfirst'.$n])) ? $_POST['cuf_senderfirst'.$n] : '';
		$cuf_senderlast = (isset($_POST['cuf_senderlast'.$n])) ? $_POST['cuf_senderlast'.$n] : '';
		$cuf_email = (isset($_POST['cuf_email'.$n])) ? $_POST['cuf_email'.$n] : '';
		$cuf_telephone = (isset($_POST['cuf_telephone'.$n])) ? $_POST['cuf_telephone'.$n] : '';
		$cuf_msg = (isset($_POST['cuf_msg'.$n])) ? $_POST['cuf_msg'.$n] : '';
		
		$form .= '
			<form action="#cuform'.$n.'" method="post" id="tinyform'.$n.'">
			<div>
			<input name="cuf_name'.$n.'" id="cuf_name'.$n.'" value="" class="cuf_input" />
			<input name="cuf_sendit'.$n.'" id="cuf_sendit'.$n.'" value="1" class="cuf_input" />
            <label for="cuf_title'.$n.'" class="cuf_label">'.__('Title', 'cuf-lang').':</label>
			<select name="cuf_title'.$n.'" id="cuf_title'.$n.'" class="cuf_field">
                <option value="0">
                    Please select
                </option>
			    <option value="Mr">
			        Mr
			    </option>
			    <option value="Mrs">
			        Mrs
			    </option>
			</select>
			<label for="cuf_senderfirst'.$n.'" class="cuf_label">'.__('First Name', 'cuf-lang').':</label>
			<input name="cuf_senderfirst'.$n.'" id="cuf_senderfirst'.$n.'" size="30" value="'.$cuf_senderfirst.'" class="cuf_field" />
			<label for="cuf_senderlast'.$n.'" class="cuf_label">'.__('Last Name', 'cuf-lang').':</label>
			<input name="cuf_senderlast'.$n.'" id="cuf_senderlast'.$n.'" size="30" value="'.$cuf_senderlast.'" class="cuf_field" />
			<label for="cuf_email'.$n.'" class="cuf_label">'.__('Email Address', 'cuf-lang').':</label>
			<input name="cuf_email'.$n.'" id="cuf_email'.$n.'" size="30" value="'.$cuf_email.'" class="cuf_field" />
			<label for="cuf_telephone'.$n.'" class="cuf_label">'.__('Telephone', 'cuf-lang').':</label>
			<input name="cuf_telephone'.$n.'" id="cuf_telephone'.$n.'" size="30" value="'.$cuf_telephone.'" class="cuf_field" />';
		for ( $x = 1; $x <=5; $x++ )
		{
			$i = 'cuf_field_'.$x.$n;
			$cuf_f = (isset($_POST[$i])) ? $_POST[$i] : '';
			$f = $this->o['field_'.$x];
			if ( !empty($f) )
				$form .= '
				<label for="'.$i.'" class="cuf_label">'.$f.':</label>
				<input name="'.$i.'" id="'.$i.'" size="30" value="'.$cuf_f.'" class="cuf_field" />';
		}
		$form .= '
			<label for="cuf_subject'.$n.'" class="cuf_label">'.__('Message subject', 'cuf-lang').':</label>
            <select name="cuf_subject'.$n.'" id="cuf_subject'.$n.'" class="cuf_field">
                <option value="0">
                    Please select
                </option>
                <option value="Product Enquiry">
                    Product Enquiry
                </option>
                <option value="Store Enquiry">
                    Store Enquiry
                </option>
                <option value="Wholesale Enquiry">
                    Wholesale Enquiry
                </option>
                <option value="Product Care">
                    Product Care
                </option>
                <option value="Customer Service">
                    Customer Service
                </option>
            </select>
			<label for="cuf_msg'.$n.'" class="cuf_label">'.__('Your message', 'cuf-lang').':</label>
			<textarea name="cuf_msg'.$n.'" id="cuf_msg'.$n.'" class="cuf_textarea" cols="50" rows="7">'.$cuf_msg.'</textarea>
			';
		if ( $this->o['captcha'] )
			$form .= $captcha->getCaptcha($n);
		if ( $this->o['captcha2'] )
			$form .= '
			<label for="cuf_captcha2_'.$n.'" class="cuf_label">'.$this->o['captcha2_question'].'</label>
			<input name="cuf_captcha2_'.$n.'" id="cuf_captcha2_'.$n.'" size="30" class="cuf_field" />
			';
			
		$title = (!empty($this->o['submit'])) ? 'value="'.$this->o['submit'].'"' : '';
		$form .= '	
			<input type="submit" name="submit'.$n.'" id="contactsubmit'.$n.'" class="cuf_submit" '.$title.'  onclick="return checkForm(\''.$n.'\');" />
			</div>
			<div id="kenmorecontent" style="float:right;">
			<a href="https://www.kenmoredesign.com/" alt="boston web design" title="Web Design Company" target="_blank">web design company</a>
			</div>
			<div style="clear:both;"></div>
			</form>';
	}
	
	$form .= '</div>'; 
	$form .= $this->addScript();
	return $form;
}

function addScript()
{
	global $cuf_script_printed;
	if ($cuf_script_printed) 
		return;
	
	$script = "
		<script type=\"text/javascript\">
		function checkForm( n )
		{
			var f = new Array();
			f[1] = document.getElementById('cuf_title' + n).value;
			f[2] = document.getElementById('cuf_senderfirst' + n).value;
			f[3] = document.getElementById('cuf_senderlast' + n).value;
			f[4] = document.getElementById('cuf_email' + n).value;
			f[5] = document.getElementById('cuf_msg' + n).value;
			f[6] = f[7] = f[8] = f[9] = f[10] = '-';
		";
	for ( $x = 1; $x <=5; $x++ )
		if ( !empty($this->o['field_'.$x]) )
			$script .= 'f['.($x + 6).'] = document.getElementById("cuf_field_'.$x.'" + n).value;'."\n";
	$script .= '
		var msg = "";
		for ( i=0; i < f.length; i++ )
		{
			if ( f[i] == "" )
				msg = "'.__('Please fill out all fields.', 'cuf-lang').'\nPlease fill out all fields.\n\n";
            if ( f[1] == 0 )
                            msg = "'.__('Please select your title.', 'cuf-lang').'\nPlease select your title.\n\n";
		}
		if ( !isEmail(f[4]) )
			msg += "'.__('Wrong Email.', 'cuf-lang').'\nWrong Email.";
		if ( msg != "" )
		{
			alert(msg);
			return false;
		}
	}
	function isEmail(email)
	{
		var rx = /^([^\s@,:"<>]+)@([^\s@,:"<>]+\.[^\s@,:"<>.\d]{2,}|(\d{1,3}\.){3}\d{1,3})$/;
		var part = email.match(rx);
		if ( part )
			return true;
		else
			return false
	}
	document.getElementById("kenmorecontent").style.visibility = "hidden";
	</script>
	';
	$cuf_script_printed = 1;
	return $script;
}


function sendMail( $n = '', $params = '' )
{
	$result = $this->checkInput( $n );
		
    if ( $result == 'OK' )
    {
    	$result = '';
    	
		if ( is_array($params) && !empty($params['to']))
			$to = $params['to'];
		else if ( !empty($this->userdata['to']) )
			$to = $this->userdata['to'];

		else
			$to = $this->o['to_email'];
		
		$from	= $this->o['from_email'];

		$name	= $_POST['cuf_title'.$n] . ' ' . $_POST['cuf_senderfirst'.$n] . ' ' . $_POST['cuf_senderlast'.$n];
		$email	= $_POST['cuf_email'.$n];
		$telephone = $_POST['cuf_telephone'.$n];
		$subject= $this->o['subpre'].' '.$_POST['cuf_subject'.$n];
		$msg	= $_POST['cuf_msg'.$n];
		
		$extra = '';
		foreach ($_POST as $k => $f )
			if ( strpos( $k, 'cuf_field_') !== false )
				$extra .= $this->o[substr($k, 4, 7)].": $f\r\n";
		

		$headers =
		"MIME-Version: 1.0\r\n".
		"Reply-To: \"$name\" <$email>\r\n".
		"Content-Type: text/plain; charset=\"".get_settings('blog_charset')."\"\r\n";
		if ( !empty($from) )
			$headers .= "From: ".get_bloginfo('name')." - $name <$from>\r\n";
		else if ( !empty($email) )
			$headers .= "From: ".get_bloginfo('name')." - $name <$email>\r\n";

		$fullmsg =
		"Name: $name\r\n".
		"Email: $email\r\n".
		"Telephone: $telephone\r\n".
		$extra."\r\n".
		'Subject: '.$_POST['cuf_subject'.$n]."\r\n\r\n".
		wordwrap($msg, 76, "\r\n")."\r\n\r\n".
		'Referer: '.$_SERVER['HTTP_REFERER']."\r\n".
		'Browser: '.$_SERVER['HTTP_USER_AGENT']."\r\n";
		
		if ( wp_mail( $to, $subject, $fullmsg, $headers) )
		{
			if ( $this->o['hideform'] )
			{
				unset($_POST['cuf_senderfirst'.$n]);
				unset($_POST['cuf_senderlast'.$n]);
				unset($_POST['cuf_email'.$n]);
				unset($_POST['cuf_subject'.$n]);
				unset($_POST['cuf_msg'.$n]);
				foreach ($_POST as $k => $f )
					if ( strpos( $k, 'cuf_field_') !== false )
						unset($k);
			}
			$result = $this->o['msg_ok'];
		}
		else
			$result = $this->o['msg_err'];
    }
    return $result;
}

function optionsPage()
{	
	global $cuf_version;
	if (!current_user_can('manage_options'))
		wp_die(__('Sorry, but you have no permissions to change settings.'));
		
	if ( isset($_POST['cuf_save']) )
	{
		$to = stripslashes($_POST['cuf_to_email']);
		if ( empty($to) )
			$to = get_option('admin_email');
		$msg_ok = stripslashes($_POST['cuf_msg_ok']);
		if ( empty($msg_ok) )
			$msg_ok = "Thank you! Your message was sent successfully.";
		$msg_err = stripslashes($_POST['cuf_msg_err']);
		if ( empty($msg_err) )
			$msg_err = "Sorry. An error occured while sending the message!";
		$captcha = ( isset($_POST['cuf_captcha']) ) ? 1 : 0;
		$captcha2 = ( isset($_POST['cuf_captcha2']) ) ? 1 : 0;
		$hideform = ( isset($_POST['cuf_hideform']) ) ? 1 : 0;
		
		$this->o = array(
			'to_email'		=> $to,
			'from_email'	=> stripslashes($_POST['cuf_from_email']),
			'css'			=> stripslashes($_POST['cuf_css']),
			'msg_ok'		=> $msg_ok,
			'msg_err'		=> $msg_err,
			'submit'		=> stripslashes($_POST['cuf_submit']),
			'captcha'		=> $captcha,
			'captcha_label'	=> stripslashes($_POST['cuf_captcha_label']),
			'captcha2'		=> $captcha2,
			'captcha2_question'	=> stripslashes($_POST['cuf_captcha2_question']),
			'captcha2_answer'	=> stripslashes($_POST['cuf_captcha2_answer']),
			'subpre'		=> stripslashes($_POST['cuf_subpre']),
			'field_1'		=> stripslashes($_POST['cuf_field_1']),
			'field_2'		=> stripslashes($_POST['cuf_field_2']),
			'field_3'		=> stripslashes($_POST['cuf_field_3']),
			'field_4'		=> stripslashes($_POST['cuf_field_4']),
			'field_5'		=> stripslashes($_POST['cuf_field_5']),
			'hideform'			=> $hideform
			);
		update_option('contact_us_form', $this->o);
	}
		
	?>
	<div id="poststuff" class="wrap">
		<h2>Contact Us Form</h2>
		<div class="postbox">
		<h3><?php _e('Options', 'cpd') ?></h3>
		<div class="inside">
		
		<form action="options-general.php?page=contact-us-form" method="post">
	    <table class="form-table">
	    		<tr>
		
			<td colspan="2" style="border-top: 1px #ddd solid; background: #eee"><strong><?php _e('Use', 'cuf-lang'); ?></strong></td>
		</tr>
    	<tr>
	    <th>   </th>
	    	<td>To insert the form on the page simply pate the following shortcode in the HTML: <b>[CONTACT-US-FORM]</b></td>
		<tr>
		
			<td colspan="2" style="border-top: 1px #ddd solid; background: #eee"><strong><?php _e('Form', 'cuf-lang'); ?></strong></td>
		</tr>
    	<tr>
			<th><?php _e('TO:', 'cuf-lang')?></th>
			<td><input name="cuf_to_email" type="text" size="70" value="<?php echo $this->o['to_email'] ?>" /><br /><?php _e('E-mail'); ?>, <?php _e('one or more (e.g. email1,email2,email3)', 'cuf-lang'); ?></td>
		</tr>
    	<tr>
			<th><?php _e('FROM:', 'cuf-lang')?> <?php _e('(optional)', 'cuf-lang'); ?></th>
			<td><input name="cuf_from_email" type="text" size="70" value="<?php echo $this->o['from_email'] ?>" /><br /><?php _e('E-mail'); ?></td>
		</tr>
    	<tr>
			<th><?php _e('Thank You message', 'cuf-lang')?></th>
			<td><input name="cuf_msg_ok" type="text" size="70" value="<?php echo $this->o['msg_ok'] ?>" /></td>
		</tr>
    	<tr>
			<th><?php _e('Error Message:', 'cuf-lang')?></th>
			<td><input name="cuf_msg_err" type="text" size="70" value="<?php echo $this->o['msg_err'] ?>" /></td>
		</tr>
		<tr>
			<th><?php _e('Submit Button Text:', 'cuf-lang')?> <?php _e('(optional)', 'cuf-lang'); ?></th>
			<td><input name="cuf_submit" type="text" size="70" value="<?php echo $this->o['submit'] ?>" /></td>
		</tr>
    	<tr>
			<th><?php _e('Subject Prefix:', 'cuf-lang')?> <?php _e('(optional)', 'cuf-lang'); ?></th>
			<td><input name="cuf_subpre" type="text" size="70" value="<?php echo $this->o['subpre'] ?>" /></td>
		</tr>
    	<tr>
			<th><?php _e('Additional Fields:', 'cuf-lang')?></th>
			<td>
				<p><?php _e('The contact form includes the fields Name, Email, Subject and Message. To add more fields simply add them below', 'cuf-lang'); ?></p>
				<?php
				for ( $x = 1; $x <= 5; $x++ )
					echo '<p>'.__('Field', 'cuf-lang').' '.$x.': <input name="cuf_field_'.$x.'" type="text" size="30" value="'.$this->o['field_'.$x].'" /></p>';
				?>
			</td>
		</tr>
    	<tr>
			<th><?php _e('Once Submitted', 'cuf-lang')?>:</th>
			<td><label for="cuf_hideform"><input name="cuf_hideform" id="cuf_hideform" type="checkbox" <?php if($this->o['hideform']==1) echo 'checked="checked"' ?> /> <?php _e('hide the form', 'cuf-lang'); ?></label></td>
		</tr>
		<tr>
			<td colspan="2" style="border-top: 1px #ddd solid; background: #eee"><strong><?php _e('Captcha', 'cuf-lang'); ?></strong></td>
		</tr>
    	<tr>
			<th><?php _e('Captcha', 'cuf-lang')?>:</th>
			<td><label for="cuf_captcha"><input name="cuf_captcha" id="cuf_captcha" type="checkbox" <?php if($this->o['captcha']==1) echo 'checked="checked"' ?> /> <?php _e('add two small numbers "2 + 5 ="', 'cuf-lang'); ?></label></td>
		</tr>
    	<tr>
			<th><?php _e('Captcha Label:', 'cuf-lang')?></th>
			<td><input name="cuf_captcha_label" type="text" size="70" value="<?php echo $this->o['captcha_label'] ?>" /></td>
		</tr>
    	<tr style="border-top: 1px #ddd dashed;" >
			<th><?php _e('Question Captcha:', 'cuf-lang')?></th>
			<td><label for="cuf_captcha2"><input name="cuf_captcha2" id="cuf_captcha2" type="checkbox" <?php if($this->o['captcha2']==1) echo 'checked="checked"' ?> /> <?php _e('Set you own question and answer.', 'cuf-lang'); ?></label></td>
		</tr>
    	<tr>
			<th><?php _e('Question:', 'cuf-lang')?></th>
			<td><input name="cuf_captcha2_question" type="text" size="70" value="<?php echo $this->o['captcha2_question'] ?>" /></td>
		</tr>
    	<tr>
			<th><?php _e('Answer:', 'cuf-lang')?></th>
			<td><input name="cuf_captcha2_answer" type="text" size="70" value="<?php echo $this->o['captcha2_answer'] ?>" /></td>
		</tr>
		<tr>
			<td colspan="2" style="border-top: 1px #ddd solid; background: #eee"><strong><?php _e('Style', 'cuf-lang'); ?></strong></td>
		</tr>
    	<tr>
			<th>
				<?php _e('StyleSheet:', 'cuf-lang'); ?><br />
				<a href="javascript:resetCss();"><?php _e('reset', 'cuf-lang'); ?></a>
			</th>
			<td>
				<textarea name="cuf_css" id="cuf_css" style="width:100%" rows="10"><?php echo $this->o['css'] ?></textarea><br />
				<?php _e('Use this field or the <code>style.css</code> in your theme directory.', 'cuf-lang') ?>
			</td>
		</tr>
		</table>
		<p class="submit">
			<input name="cuf_save" class="button-primary" value="<?php _e('Save Changes'); ?>" type="submit" />
		</p>
		</form>
		
		<script type="text/javascript">
		function resetCss()
		{
			css = ".contactform {}\n.contactform label {}\n.contactform input {}\n.contactform textarea {}\n"
				+ ".contactform_respons {}\n.contactform_error {}\n.widget .contactform { /* sidebar fields */ }";
			document.getElementById('cuf_css').value = css;
		}
		</script>
	</div>
	</div>
	

	
	</div>
	<?php
}


function addOptionsPage()
{
	global $wp_version;
	$menutitle = '';
	if ( version_compare( $wp_version, '2.6.999', '>' ) )
	$menutitle .= 'Contact Us Form';
	add_options_page('Contact Us Form', $menutitle, 9, 'contact-us-form', array( &$this, 'optionsPage'));
}

function shortcode( $atts )
{

	
	extract( shortcode_atts( array(
		'to' => '',
		'subject' => ''
	), $atts) );
	$this->userdata = array(
		'to' => $to,
		'subject' => $subject
	);
	return $this->showForm();
}

function checkInput( $n = '' )
{

	if ( !isset($_POST['cuf_sendit'.$n]))
		return false;

	if ( (isset($_POST['cuf_sendit'.$n]) && $_POST['cuf_sendit'.$n] != 1)
		|| (isset($_POST['cuf_name'.$n]) && $_POST['cuf_name'.$n] != '') )
	{
		return 'No Spam please!';
	}
	
	$o = get_option('contact_us_form');

	$_POST['cuf_senderfirst'.$n] = stripslashes(trim($_POST['cuf_senderfirst'.$n]));
	$_POST['cuf_senderlast'.$n] = stripslashes(trim($_POST['cuf_senderlast'.$n]));
	$_POST['cuf_email'.$n] = stripslashes(trim($_POST['cuf_email'.$n]));
	$_POST['cuf_subject'.$n] = stripslashes(trim($_POST['cuf_subject'.$n]));
	$_POST['cuf_msg'.$n] = stripslashes(trim($_POST['cuf_msg'.$n]));

	$error = array();
	if ( empty($_POST['cuf_senderfirst'.$n]) || empty($_POST['cuf_senderlast'.$n]) )
		$error[] = __('Name', 'cuf-lang');
    if ( !is_email($_POST['cuf_email'.$n]) )
		$error[] = __('Email', 'cuf-lang');
    if ( empty($_POST['cuf_title'.$n]) )
		$error[] = __('Title', 'cuf-lang');
    if ( empty($_POST['cuf_msg'.$n]) )
		$error[] = __('Your Message', 'cuf-lang');
	if ( $o['captcha'] && !ContactUsFormCaptcha::isCaptchaOk() )
		$error[] = $this->o['captcha_label'];
	if ( $o['captcha2'] && ( empty($_POST['cuf_captcha2_'.$n]) || $_POST['cuf_captcha2_'.$n] != $o['captcha2_answer'] ) )
		$error[] = $this->o['captcha2_question'];
	if ( !empty($error) )
		return __('Check these fields:', 'cuf-lang').' '.implode(', ', $error);
	
	return 'OK';
}

function uninstall()
{
	delete_option('contact_us_form');
}

function addStyle()
{
	if ($this->o['css']) {
		echo "\n<!-- Contact Us Form -->\n"
			."<style type=\"text/css\">\n"
			.".cuf_input {display:none !important; visibility:hidden !important;}\n"
			.$this->o['css']."\n"
			."</style>\n";
	} else {
		echo "\n<!-- Contact Us Form -->\n"
			."<style type=\"text/css\">\n"
			.".cuf_input {display:none !important; visibility:hidden !important;}\n"
			."#contactsubmit:hover, #contactsubmit:focus {
	text-decoration: none;
}
#thanks {
    height:780px;
}
#thanks h2, #thanks p {
    width:100%;
    text-align: center;
    vertical-align: middle;
}
#contactsubmit:active {background: #849F00}
#contactsubmit {
	color: #FFF;
	background: #000 repeat-x;
	display: block;
	float: left;
	height: 28px;
	padding-right: 11px;
	padding-left: 11px;
	font-size: 9px;
	text-transform: uppercase;
	text-decoration: none;
	letter-spacing: 1px;
	font-weight: bold;
	-webkit-transition: background 300ms linear;
-moz-transition: background 300ms linear;
-o-transition: background 300ms linear;
transition: background 300ms linear;
text-align:center
}
.cuf_label {
    width:100px;
    float:left;
    margin-top:8px;
}
.cuf_field {
	-moz-box-sizing:border-box;
	-webkit-box-sizing:border-box;
	box-sizing:border-box;
	background:#fff;
	border:1px solid #cccccc;
	padding:5px 8px;
	width: 200px;
	margin-top:2px;
    margin-bottom:15px;
	outline:none
	float:left;
}
label[for='cuf_subject'] {
    margin-top:18px;
    width:100%;
}
#cuf_subject {
    width:238px;
    margin-right:100px;
    margin-top:9px;
}
#cuf_title {
    width: 138px;
    margin-right: 60px;
}
#cuf_title, #cuf_subject {
    height: 24px;
}
#tinyform {
clear: both;
	width:350px;
	margin-left:auto;
	margin-right:auto;
	/*margin-top:30px;*/
	padding:20px 0;
	-webkit-transition:all 200ms linear;
	-moz-transition:all 200ms linear;
	-o-transition:all 200ms linear;
	transition:all 200ms linear;
}
.cuf_textarea {
	background:#fff;
	border:1px solid #cccccc;
	padding:8px;
	width:300px;
	margin-top:5px;
	outline:none;
margin-bottom:33px;
}\n"
			."</style>\n";
	}
}


function pluginActions($links, $file)
{
	if( $file == plugin_basename(__FILE__)
		&& strpos( $_SERVER['SCRIPT_NAME'], '/network/') === false )
	{
		$link = '<a href="options-general.php?page=contact-us-form">'.__('Settings').'</a>';
		array_unshift( $links, $link );
	}
	return $links;
}

function setRecources()
{
	if ( isset($_GET['resource']) && !empty($_GET['resource']) )
	{			 
		if ( array_key_exists($_GET['resource'], $resources) )
		{
			$content = base64_decode($resources[ $_GET['resource'] ]);
			$lastMod = filemtime(__FILE__);
			$client = ( isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false );
			if (isset($client) && (strtotime($client) == $lastMod))
			{
				header('Last-Modified: '.gmdate('D, d M Y H:i:s', $lastMod).' GMT', true, 304);
				exit;
			}
			else
			{
				header('Last-Modified: '.gmdate('D, d M Y H:i:s', $lastMod).' GMT', true, 200);
				header('Content-Length: '.strlen($content));
				header('Content-Type: image/' . substr(strrchr($_GET['resource'], '.'), 1) );
				echo $content;
				exit;
			}
		}
	}
}

function getResource( $resourceID ) {
	return trailingslashit( get_bloginfo('url') ).'?resource='.$resourceID;
}

function register_widgets()
{
	register_widget('ContactUsForm_Widget');
}

} 

class ContactUsFormCaptcha
{
	
var $first;
var $operation;
var $second;
var $answer;
var $captcha_id;


function ContactUsFormCaptcha( $seed )
{
	$this->captcha_id = $seed;
	if ( $seed )
		srand($seed);
	$operation = 1;
	switch ( $operation )
	{
		case 1:
			$this->operation = '+';
			$this->first = rand(1, 10);
			$this->second = rand(0, 10);
			$this->answer = $this->first + $this->second;
			break;
	}
}


function getAnswer()
{
	return $this->answer;
}


function getQuestion()
{
	return $this->first.' '.$this->operation.' '.$this->second.' = ';
}


function isCaptchaOk()
{
	$ok = true;
	if ($_POST[base64_encode(strrev('current_time'))] && $_POST[base64_encode(strrev('captcha'))])
	{

		if ((time() - strrev(base64_decode($_POST[base64_encode(strrev('current_time'))]))) > 1800)
			$ok = false;

		$valid = new ContactUsFormCaptcha(strrev(base64_decode($_POST[base64_encode(strrev('captcha'))])));
		if ($_POST[base64_encode(strrev('answer'))] != $valid->getAnswer())
			$ok = false;
	}
	return $ok;
}
	
function getCaptcha( $n = '' )
{
	global $contact_us_form;
	return '<input name="'.base64_encode(strrev('current_time')).'" type="hidden" value="'.base64_encode(strrev(time())).'" />'."\n"
		.'<input name="'.base64_encode(strrev('captcha')).'" type="hidden" value="'.base64_encode(strrev($this->captcha_id)).'" />'."\n"
		.'<label class="cuf_label" style="display:inline" for="cuf_captcha'.$n.'">'.$contact_us_form->o['captcha_label'].' <b>'.$this->getQuestion().'</b></label> <input id="cuf_captcha'.$n.'" name="'.base64_encode(strrev('answer')).'" type="text" size="2" />'."\n";
}

} 

class ContactUsForm_Widget extends WP_Widget
{
	var $fields = array('Title', 'Subject', 'To');
	

	function ContactUsForm_Widget() {
		parent::WP_Widget('cuform_widget', 'Contact Us Form', array('description' => 'Contact Us Form'));	
	}
 

	function widget( $args, $instance)
	{
		global $contact_us_form;
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		echo $before_widget;
		if ( !empty( $title ) )
			echo $before_title.$title.$after_title;
		echo $contact_us_form->showForm( $instance );
		echo $after_widget;
	}
 
	
	function update( $new_instance, $old_instance )
	{
		$instance = $old_instance;
		foreach ( $this->fields as $f )
			$instance[strtolower($f)] = strip_tags($new_instance[strtolower($f)]);
		return $instance;
	}
 

	function form( $instance )
	{
		$default = array('title' => 'Contact Us Form');
		$instance = wp_parse_args( (array) $instance, $default );
 
		foreach ( $this->fields as $field )
		{ 
			$f = strtolower( $field );
			$field_id = $this->get_field_id( $f );
			$field_name = $this->get_field_name( $f );
			echo "\r\n".'<p><label for="'.$field_id.'">'.__($field, 'cuf-lang').': <input type="text" class="widefat" id="'.$field_id.'" name="'.$field_name.'" value="'.attribute_escape( $instance[$f] ).'" /><label></p>';
		}
	}
} 
?>