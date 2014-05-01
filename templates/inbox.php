<?php
	if(count($torrents) == 0)
		echo 'There are no new torrents';
	else
		foreach($torrents as $torrent)
		{
			printf(
				'%1$s - [<a href="/torrent.php?start=%2$s">Start</a>] [<a href="/torrent.php?skip=%2$s">Skip</a>]<br>',
				$torrent->title,
				urlencode($torrent->torrent)
			);
		}
?>
