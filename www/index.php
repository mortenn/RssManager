<?php
	require('../bootstrap.php');

	$site->title = 'Nyaa RSS Feed manager';
	$site->content = new FeedManager($schema);
	echo $site;
?>
