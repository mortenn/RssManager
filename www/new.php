<?php
	require('../bootstrap.php');

	$site->title = 'Add nyaa RSS Feed';
	$site->content = new NewFeed($schema);
	echo $site;
?>
