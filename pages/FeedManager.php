<?php
	class FeedManager extends KW_Module
	{
		public function __construct($schema)
		{
			$this->schema = $schema;
		}

		public function renderModule()
		{
			$template = new KW_Template('feeds');
			if(isset($_GET['q']) && trim($_GET['q']) != '')
				$template->feeds = $this->schema->feeds->getFeeds(trim($_GET['q']));
			else
				$template->feeds = $this->schema->feeds->getActiveFeeds();
			$stats = array();
			foreach($this->schema->torrents->statistics->getRows() as $stat)
				$stats[$stat->feed] = $stat;
			$template->statistics = $stats;
			return $template;
		}

		public function getFeed($name)
		{
			return $this->schema->feeds->getFeed($name);
		}

		public function getTorrents($feed)
		{
			$this->schema->torrents->getByFeed->feed = $feed->name;
			$torrents = array();
			foreach($this->schema->torrents->getByFeed->execute()->getRows() as $torrent)
				$torrents[$torrent->torrent] = $torrent->status;
			return $torrents;
		}

		public function addTorrentFromFeed($feed, $item)
		{
			$feed->addTorrent($item);
		}

		private $schema;
	}
?>
