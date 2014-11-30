#!/usr/bin/php
<?php
	require('bootstrap.php');
	$active = array();
	$autostart = array();
	$uri = array();
	$feeds = $schema->feeds->getActiveFeeds();
	foreach($feeds as $f)
	{
		$f->scrape();
		$active[$f->name] = true;
		$autostart[$f->name] = $f->autostart;
	}

	if($autoadd)
	{
		foreach($schema->torrents->getNew() as $torrent)
		{
			if(!isset($active[$torrent->feed]))
			{
				$torrent->skip();
			}
			else if($autostart[$torrent->feed])
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
	}
?>
