<?php
	require('../bootstrap.php');

	$site->title = 'Nyaa RSS Feed manager';
	$site->content = new WatchList($schema);
	echo $site;
?>
