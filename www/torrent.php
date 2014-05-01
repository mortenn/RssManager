<?php
	require('../bootstrap.php');

	$site->title = 'Nyaa Torrents';
	$site->content = new TorrentInbox($schema);
	echo $site;
?>
