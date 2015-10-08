<?php 
// Define the path to the forum root
define('FORUM_ROOT', './board/');
require FORUM_ROOT.'include/common.php';
include('algorithm.php');

($hook = get_hook('li_start')) ? eval($hook) : null;

// Load the login.php language file
require FORUM_ROOT.'lang/'.$forum_user['language'].'/login.php';

// PunBB config
$punbb_url = $base_url;
$redirect_url = forum_htmlencode($punbb_url);
$form_action = forum_link($forum_url['login']);
$csrf_token = generate_form_token($form_action);
$form_sent = 1;
$secretkey = 'Ishare+';

// Initiate integration with PunBB database
if ($form_sent == 1 && isset($_SESSION['userwd']) && isset($_SESSION['ekp']))
{
	$form_username = $_SESSION['userwd'];
	//$decrypted_keypass = ssl_decrypt($secretkey, $_SESSION['ekp']);
	//$form_password = $decrypted_keypass;
	$form_password = $_SESSION['ekp']; // Not Safe. Hackable!
	$save_pass = 0;

	($hook = get_hook('li_login_form_submitted')) ? eval($hook) : null;

	// Get user info matching login attempt
	$query = array(
		'SELECT'	=> 'u.id, u.group_id, u.password, u.salt',
		'FROM'		=> 'users AS u'
	);

	if (in_array($db_type, array('mysql', 'mysqli', 'mysql_innodb', 'mysqli_innodb'))) {
		$query['WHERE'] = 'username=\''.$forum_db->escape($form_username).'\'';
	}	else {
		$query['WHERE'] = 'LOWER(username)=LOWER(\''.$forum_db->escape($form_username).'\')';
	}

	($hook = get_hook('li_login_qr_get_login_data')) ? eval($hook) : null;
	$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
	list($user_id, $group_id, $db_password_hash, $salt) = $forum_db->fetch_row($result);

	$authorized = false;
	if (!empty($db_password_hash))
	{
		$sha1_in_db = (strlen($db_password_hash) == 40) ? true : false;
		$form_password_hash = forum_hash($form_password, $salt);

		if ($sha1_in_db && $db_password_hash == $form_password_hash) {
			$authorized = true;
		}
		else if ((!$sha1_in_db && $db_password_hash == md5($form_password)) || ($sha1_in_db && $db_password_hash == sha1($form_password)))
		{
			$authorized = true;

			$salt = random_key(12);
			$form_password_hash = forum_hash($form_password, $salt);

			// There's an old MD5 hash or an unsalted SHA1 hash in the database, so we replace it
			// with a randomly generated salt and a new, salted SHA1 hash
			$query = array(
				'UPDATE'	=> 'users',
				'SET'		=> 'password=\''.$form_password_hash.'\', salt=\''.$forum_db->escape($salt).'\'',
				'WHERE'		=> 'id='.$user_id
			);

			($hook = get_hook('li_login_qr_update_user_hash')) ? eval($hook) : null;
			$forum_db->query_build($query) or error(__FILE__, __LINE__);
		}
	}

	($hook = get_hook('li_login_pre_auth_message')) ? eval($hook) : null;

	if (!$authorized) {
		$errors[] = sprintf($lang_login['Wrong user/pass']);
		echo 'ERROR: '.sprintf($lang_login['Wrong user/pass']);
		echo '<br /><a href="board/">Back to Board Index</a>';
  }

	// Did everything go according to plan?
	if (empty($errors))
	{
		// Update the status if this is the first time the user logged in
		if ($group_id == FORUM_UNVERIFIED)
		{
			$query = array(
				'UPDATE'	=> 'users',
				'SET'		=> 'group_id='.$forum_config['o_default_user_group'],
				'WHERE'		=> 'id='.$user_id
			);

			($hook = get_hook('li_login_qr_update_user_group')) ? eval($hook) : null;
			$forum_db->query_build($query) or error(__FILE__, __LINE__);

			// Remove cache file with forum stats
			if (!defined('FORUM_CACHE_FUNCTIONS_LOADED'))
			{
				require FORUM_ROOT.'include/cache.php';
			}

			clean_stats_cache();
		}

		// Remove this user's guest entry from the online list
		$query = array(
			'DELETE'	=> 'online',
			'WHERE'		=> 'ident=\''.$forum_db->escape(get_remote_address()).'\''
		);

		($hook = get_hook('li_login_qr_delete_online_user')) ? eval($hook) : null;
		$forum_db->query_build($query) or error(__FILE__, __LINE__);

		$expire = ($save_pass) ? time() + 1209600 : time() + $forum_config['o_timeout_visit'];
		forum_setcookie($cookie_name, base64_encode($user_id.'|'.$form_password_hash.'|'.$expire.'|'.sha1($salt.$form_password_hash.forum_hash($expire, $salt))), $expire);

		($hook = get_hook('li_login_pre_redirect')) ? eval($hook) : null;

		redirect(forum_htmlencode($punbb_url).((substr_count($redirect_url, '?') == 1) ? '&amp;' : '?').'login=1', $lang_login['Login redirect']);
	}
	unset($_SESSION['ekp']);
}
else
{
  header('Location: 404.php');
}
?>