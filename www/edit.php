<?php
	require('../bootstrap.php');

	$site->title = 'Edit nyaa RSS Feed';
	$site->content = new EditFeed($schema);
	echo $site;
?>
