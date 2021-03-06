<?php
// Define the path to the forum root
define('FORUM_ROOT', './board/');
require FORUM_ROOT.'include/common.php';
include('algorithm.php');

$user_language = 'English';
$user_timezone = 0;
$user_dst = 0;
$secretkey = 'Ishare+';

($hook = get_hook('rg_start')) ? eval($hook) : null;

// Load the profile.php language file
require FORUM_ROOT.'lang/'.$forum_user['language'].'/profile.php';

// PunBB config
$punbb_url = $base_url;
$form_sent = 1;

if ($form_sent == 1 && isset($_SESSION['userwd']) && isset($_SESSION['erkp']) && isset($_SESSION['erem']))
{
	($hook = get_hook('rg_register_form_submitted')) ? eval($hook) : null;

	// Check that someone from this IP didn't register a user within the last hour (DoS prevention)
	/*
	$query = array(
		'SELECT'	=> 'COUNT(u.id)',
		'FROM'		=> 'users AS u',
		'WHERE'		=> 'u.registration_ip=\''.$forum_db->escape(get_remote_address()).'\' AND u.registered>'.(time() - 3600)
	);

	($hook = get_hook('rg_register_qr_check_register_flood')) ? eval($hook) : null;
	$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
	if ($forum_db->result($result) > 0)
	{
		$errors[] = $lang_profile['Registration flood'];
		echo 'ERROR: '.$lang_profile['Registration flood'];
	}
	*/

	// Did everything go according to plan so far?
	if (empty($errors))
	{
		$username = forum_trim($_SESSION['userwd']);
		
		$decrypted_email = ssl_decrypt($secretkey, $_SESSION['erem']);
		$email1 = strtolower(forum_trim($decrypted_email));

		if ($forum_config['o_regs_verify'] == '1')
		{
			$password1 = random_key(8, true);
			$password2 = $password1;
		}
		else
		{
      $decrypted_keypass = ssl_decrypt($secretkey, $_SESSION['erkp']);
			$password1 = forum_trim($decrypted_keypass);
			$password2 = ($forum_config['o_mask_passwords'] == '1') ? forum_trim($decrypted_keypass) : $password1;
		}

		// Validate the username
		//$errors = array_merge($errors, validate_username($username));

		// ... and the password
		if (utf8_strlen($password1) < 4) {
			$errors[] = $lang_profile['Pass too short'];
			echo 'ERROR: '.$lang_profile['Pass too short'];
			echo '<br /><a href="board/">Back to Board Index</a>';
		}
		else if ($password1 != $password2) {
			$errors[] = $lang_profile['Pass not match'];
			echo 'ERROR: '.$lang_profile['Pass not match'];
			echo '<br /><a href="board/">Back to Board Index</a>';
    }
		// ... and the e-mail address
		if (!defined('FORUM_EMAIL_FUNCTIONS_LOADED')) {
			require FORUM_ROOT.'include/email.php';
    }
		if (!is_valid_email($email1)) {
			$errors[] = $lang_profile['Invalid e-mail'];
			echo 'ERROR: '.$lang_profile['Invalid e-mail'];
			echo '<br /><a href="board/">Back to Board Index</a>';
    }
		// Check if it's a banned e-mail address
		$banned_email = is_banned_email($email1);
		if ($banned_email && $forum_config['p_allow_banned_email'] == '0') {
			$errors[] = $lang_profile['Banned e-mail'];
			echo 'ERROR: '.$lang_profile['Banned e-mail'];
			echo '<br /><a href="board/">Back to Board Index</a>';
    }
		// Clean old unverified registrators - delete older than 72 hours
		$query = array(
			'DELETE'	=> 'users',
			'WHERE'		=> 'group_id='.FORUM_UNVERIFIED.' AND activate_key IS NOT NULL AND registered < '.(time() - 259200)
		);
		($hook = get_hook('rg_register_qr_delete_unverified')) ? eval($hook) : null;
		$forum_db->query_build($query) or error(__FILE__, __LINE__);

		// Check if someone else already has registered with that e-mail address
		$dupe_list = array();

		$query = array(
			'SELECT'	=> 'u.username',
			'FROM'		=> 'users AS u',
			'WHERE'		=> 'u.email=\''.$forum_db->escape($email1).'\''
		);

		($hook = get_hook('rg_register_qr_check_email_dupe')) ? eval($hook) : null;
		$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);

		while ($cur_dupe = $forum_db->fetch_assoc($result))
		{
			$dupe_list[] = $cur_dupe['username'];
		}

		if (!empty($dupe_list) && empty($errors))
		{
			if ($forum_config['p_allow_dupe_email'] == '0')
				$errors[] = $lang_profile['Dupe e-mail'];
				echo 'ERROR: '.$lang_profile['Dupe e-mail'];
				echo '<br /><a href="board/">Back to Board Index</a>';
		}

		($hook = get_hook('rg_register_end_validation')) ? eval($hook) : null;

		// Did everything go according to plan so far?
		if (empty($errors))
		{
			// Make sure we got a valid language string
			if ($user_language)
			{
				$language = preg_replace('#[\.\\\/]#', '', $user_language);
				if (!file_exists(FORUM_ROOT.'lang/'.$language.'/common.php'))
					message($lang_common['Bad request']);
			}
			else
				$language = $forum_config['o_default_lang'];

			$initial_group_id = ($forum_config['o_regs_verify'] == '0') ? $forum_config['o_default_user_group'] : FORUM_UNVERIFIED;
			$salt = random_key(12);
			$password_hash = forum_hash($password1, $salt);

			// Validate timezone and DST
			$timezone = ($user_timezone) ? floatval($user_timezone) : $forum_config['o_default_timezone'];

			// Validate timezone � on error use default value
			if (($timezone > 14.0) || ($timezone < -12.0)) {
				$timezone = $forum_config['o_default_timezone'];
			}

			// DST
			$dst = (isset($user_dst) && intval($user_dst) === 1) ? 1 : $forum_config['o_default_dst'];


			// Insert the new user into the database. We do this now to get the last inserted id for later use.
			$user_info = array(
				'username'				=>	$username,
				'group_id'				=>	$initial_group_id,
				'salt'					=>	$salt,
				'password'				=>	$password1,
				'password_hash'			=>	$password_hash,
				'email'					=>	$email1,
				'email_setting'			=>	$forum_config['o_default_email_setting'],
				'timezone'				=>	$timezone,
				'dst'					=>	$dst,
				'language'				=>	$language,
				'style'					=>	$forum_config['o_default_style'],
				'registered'			=>	time(),
				'registration_ip'		=>	get_remote_address(),
				'activate_key'			=>	($forum_config['o_regs_verify'] == '1') ? '\''.random_key(8, true).'\'' : 'NULL',
				'require_verification'	=>	($forum_config['o_regs_verify'] == '1'),
				'notify_admins'			=>	($forum_config['o_regs_report'] == '1')
			);

			($hook = get_hook('rg_register_pre_add_user')) ? eval($hook) : null;
			add_user($user_info, $new_uid);

			// If we previously found out that the e-mail was banned
			if ($banned_email && $forum_config['o_mailing_list'] != '')
			{
				$mail_subject = 'Alert - Banned e-mail detected';
				$mail_message = 'User \''.$username.'\' registered with banned e-mail address: '.$email1."\n\n".'User profile: '.forum_link($forum_url['user'], $new_uid)."\n\n".'-- '."\n".'Forum Mailer'."\n".'(Do not reply to this message)';

				($hook = get_hook('rg_register_banned_email')) ? eval($hook) : null;

				forum_mail($forum_config['o_mailing_list'], $mail_subject, $mail_message);
			}

			// If we previously found out that the e-mail was a dupe
			if (!empty($dupe_list) && $forum_config['o_mailing_list'] != '')
			{
				$mail_subject = 'Alert - Duplicate e-mail detected';
				$mail_message = 'User \''.$username.'\' registered with an e-mail address that also belongs to: '.implode(', ', $dupe_list)."\n\n".'User profile: '.forum_link($forum_url['user'], $new_uid)."\n\n".'-- '."\n".'Forum Mailer'."\n".'(Do not reply to this message)';

				($hook = get_hook('rg_register_dupe_email')) ? eval($hook) : null;

				forum_mail($forum_config['o_mailing_list'], $mail_subject, $mail_message);
			}

			($hook = get_hook('rg_register_pre_login_redirect')) ? eval($hook) : null;

			// Must the user verify the registration or do we log him/her in right now?
			if ($forum_config['o_regs_verify'] == '1')
			{
				message(sprintf($lang_profile['Reg e-mail'], '<a href="mailto:'.forum_htmlencode($forum_config['o_admin_email']).'">'.forum_htmlencode($forum_config['o_admin_email']).'</a>'));
			}
			else
			{
				// Remove cache file with forum stats
				if (!defined('FORUM_CACHE_FUNCTIONS_LOADED'))
				{
					require FORUM_ROOT.'include/cache.php';
				}

				clean_stats_cache();
			}

			$expire = time() + $forum_config['o_timeout_visit'];

			forum_setcookie($cookie_name, base64_encode($new_uid.'|'.$password_hash.'|'.$expire.'|'.sha1($salt.$password_hash.forum_hash($expire, $salt))), $expire);

			redirect(forum_link($forum_url['index']), $lang_profile['Reg complete']);
		}
	}
	unset($_SESSION['erkp']);
	unset($_SESSION['erem']);
}
else
{
  header('Location: 404.php');
}

?>