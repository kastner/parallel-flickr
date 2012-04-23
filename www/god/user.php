<?php

	include("../include/init.php");

	loadlib("god");
	loadlib("flickr_photos");
	loadlib("flickr_faves");
	loadlib("flickr_users");
	loadlib("flickr_api");

	$id = request_str("user_id");

	if ($id){

		$user = users_get_by_id($id);

		if (! $user['id']){
			error_404();
		}

		$flickr_user = flickr_users_get_by_user_id($user['id']);

		$count_photos = flickr_photos_count_for_user($user, array('viewer_id' => $user['id']));
		$user['count_photos'] = $count_photos;

		$count_faves = flickr_faves_count_for_user($user, array('viewer_id' => $user['id']));
		$user['count_faves'] = $count_faves;

		$perms_map = flickr_api_authtoken_perms_map();
		$GLOBALS['smarty']->assign_by_ref("perms_map", $perms_map);

		$GLOBALS['smarty']->assign_by_ref("user", $user);
		$GLOBALS['smarty']->assign_by_ref("flickr_user", $flickr_user);
	}

	$GLOBALS['smarty']->display("page_god_user.txt");
	exit();
?>
