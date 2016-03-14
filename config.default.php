<?php
	define('KW_TEMPLATE_DIR', 'templates/');
	define('RSS_URL', 'http://www.nyaa.se/?page=rss&cats=1_37&term=%s');
	define('TARGET', '/torrent/');
	$allow_from = '/^(10\.|192\.168\.)/';
	$invisible = array('.');
	$transmission_link = 'http://127.0.0.1:9091/transmission/web/';
	$rpc_server = 'http://127.0.0.1:9091/transmission/rpc';
	$alertmail = '';
	$embed = true;
	$autoadd = false;
	$share = 'smb://server/torrent/';
	$broken_unicode = false;
	$db_username = '';
	$db_password = '';
	$db_server = 'localhost';
	$db_name = 'nyaa_feeds';
?>
