<?php
	require('../bootstrap.php');
	$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
	switch($path)
	{
		default:
			redirect('/index.php/feeds');
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
		case '/restart':
			$site->title = 'Re-add torrents';
			$site->page = 'restart';
			$site->content = new TorrentRestart($schema);
			break;
		case '/watch':
			$site->title = 'Torrent watchlist';
			$site->page = 'watch';
			$site->content = new WatchList($schema);
			break;
		case '/shows':
			$site->title = 'Show listing';
			$site->page = 'shows';
			$site->content = new ShowList($schema);
			break;
		case '/watched':
			if(isset($_GET['name']))
			{
				$torrent = $schema->torrents->getTorrent($_GET['name']);
				$torrent->watched();
			}
			if(isset($_SERVER['HTTP_REFERER']))
				redirect($_SERVER['HTTP_REFERER']);
			redirect('watch');
			break;
		case '/play':
			if(isset($_GET['file']))
				$torrent = $schema->torrents->getTorrent($_GET['name'], $_GET['file']);
			else
				$torrent = $schema->torrents->getTorrent($_GET['name']);
			header('Content-Type: application/xspf+xml');
			header('Content-Disposition: '.($embed?'inline':'attachment').'; filename="'.$torrent->title.'.xspf');
			echo $torrent->playlist();
			die();
	}
	$site->menu = array(
		'feeds' => 'Active feeds',
		'new' => 'New feed',
		'inbox' => 'New torrents',
		'restart' => 'Re-add torrents',
		'watch' => 'Torrent watchlist',
		'shows' => 'Show listing'
	);
	echo $site;
?>
