<?php
	class Feed extends KW_DataContainer
	{
		public static function Search($term)
		{
			$feed = new self();
			return $feed->read($term);
		}

		public function __construct($dal = null, $data = null)
		{
			if($data != null)
				parent::__construct($data->getAsArray());
			$this->dal = $dal;
		}

		public function activate()
		{
			$this->dal->activate->name = $this->name;
			$this->dal->activate->execute();
		}

		public function dectivate()
		{
			$this->dal->activate->name = $this->name;
			$this->dal->activate->execute();
		}

		public function toggle()
		{
			$this->dal->autostart->name = $this->name;
			$this->dal->autostart->value = !$this->autostart;
			$this->dal->autostart->execute();
		}

		public function save()
		{
			$this->uri = sprintf(RSS_URL, urlencode($this->term));
			$this->dal->saveFeed($this);
		}

		public function read($term = null)
		{
			$feed = new SimplePie();
			$feed->set_feed_url(sprintf(RSS_URL, urlencode($term == null ? $this->term : $term)));
			$feed->init();
			$feed->handle_content_type();
			return $feed->get_items();
		}

		public function scrape()
		{
			$scraped = $this->getTorrents();
			foreach($this->read() as $item)
			{
				$torrent = html_entity_decode($item->get_permalink());
				if(!isset($scraped[$torrent]))
					$this->addTorrent($item);
			}
		}

		public function getTorrents()
		{
			global $schema;
			$schema->torrents->getByFeed->feed = $this->name;
			$torrents = array();
			foreach($schema->torrents->getByFeed->execute()->getRows() as $torrent)
				$torrents[$torrent->torrent] = $torrent->status;
			return $torrents;
		}

		public function addTorrent($data)
		{
			global $schema;
			$url = html_entity_decode($data->get_permalink());
			$torrent = $schema->torrents->getTorrent($url);
			if($torrent)
				return $torrent;
			$torrent = new Torrent($schema->torrents);
			$torrent->feed = $this->name;
			$torrent->torrent = $url;
			$torrent->title = $data->get_title();
			$torrent->status = TORRENT_STATUS_NEW;
			$torrent->save();
			return $torrent;
		}
	}
?>
