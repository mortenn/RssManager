<?php
	class FeedManager extends KW_Module
	{
		public function __construct($schema)
		{
			$this->schema = $schema;
		}

		public function renderModule()
		{
			if(isset($_GET['deactivate']))
			{
				$this->schema->feeds->getFeed($_GET['deactivate'])->deactivate();
				redirect('/');
			}
			$template = new KW_Template('feeds');
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
