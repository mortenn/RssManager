<?php
	require('../bootstrap.php');
	$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
	switch($path)
	{
		default:
		case '/feeds':
			$site->title = 'Active RSS Feeds';
			$site->page = 'feeds';
			$site->content = new FeedManager($schema);
			break;
		case '/new':
			$site->title = 'Add RSS Feed';
			$site->page = 'new';
			$site->content = new NewFeed($schema);
			break;
		case '/edit':
			$site->title = 'Edit RSS Feed';
			$site->page = 'feeds';
			$site->content = new EditFeed($schema);
			break;
		case '/toggle':
			if(isset($_GET['name']))
				$schema->feeds->getFeed($_GET['name'])->toggle();
			redirect('feeds');
			break;
		case '/deactivate':
			if(isset($_GET['name']))
				$schema->feeds->getFeed($_GET['name'])->deactivate();
			redirect('feeds');
			break;
		case '/inbox':
			$site->title = 'New torrents from RSS';
			$site->page = 'inbox';
			$site->content = new TorrentInbox($schema);
			break;
		case '/watch':
			$site->title = 'Torrent watchlist';
			$site->page = 'watch';
			$site->content = new WatchList($schema);
			break;
	}
	$site->menu = array(
		'feeds' => 'Active feeds',
		'new' => 'New feed',
		'inbox' => 'New torrents',
		'watch' => 'Torrent watchlist'
	);
	echo $site;
?>
