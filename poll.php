#!/usr/bin/php
<?php
	require('bootstrap.php');
	$active = array();
	$uri = array();
	$feeds = $schema->feeds->getActiveFeeds();
	foreach($feeds as $f)
	{
		$f->scrape();
		$active[$f->name] = true;
	}

	if($autoadd)
	{
		foreach($schema->torrents->getNew() as $torrent)
		{
			try
			{
				echo 'Adding torrent for '.$torrent->title.': '.($torrent->start() ? 'OK' : 'Error');
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
			}
		}
	}
?>
