<?php
	if(count($feeds) == 0)
		echo 'There are no feeds';
	else
	{
		foreach($feeds as $feed)
		{
			printf(
				'%2$s: %1$s [%4$d/%5$d/%6$d] <a href="/edit.php?name=%3$s">Edit</a> <a href="/?deactivate=%3$s">Deactivate</a><br>',
				$feed->uri,
				$feed->name,
				urlencode($feed->name),
				$statistics[$feed->name]->new,
				$statistics[$feed->name]->added,
				$statistics[$feed->name]->skipped
			);
		}
	}
?>
