<?php
	$template = new KW_Template('torrent');
	foreach($torrents as $torrent)
	{
		$template->torrent = $torrent;
		echo $template;
	}
?>
