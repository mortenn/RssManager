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
			else
				$this->new = true;
			$this->dal = $dal;
		}

		public function playlist($all = false)
		{
			global $share, $broken_unicode, $schema;
			$playlist = new KW_Template('playlist.feed');
			$playlist->broken_unicode = $broken_unicode;
			$playlist->root = $share;
			if(!is_dir(TARGET.$this->feed) && is_dir(utf8_encode(TARGET.$this->name)))
				$playlist->folder = utf8_encode(TARGET.$this->name);
			else
				$playlist->folder = $this->name;

			$files = array();
			$schema->torrents->getByFeed->feed = $this->name;
			foreach($schema->torrents->getByFeed->execute()->getRows() as $torrent)
			{
				if(!$torrent->watched || $all)
				{
					$dto = new Torrent($schema->torrents, $torrent);
					$target = $dto->locateTarget();
					if(is_dir(TARGET.$this->name.'/'.$target))
					{
						foreach(glob(TARGET.$this->name.'/*') as $file)
							$files[] = str_replace(TARGET.$this->name.'/','',$file);
					}
					else
						$files[] = $target;
				}
			}
			sort($files);
			$playlist->files = $files;
			return (string)$playlist;
		}

		public function activate()
		{
			$this->dal->activate->name = $this->name;
			$this->dal->activate->execute();
		}

		public function deactivate()
		{
			$this->dal->deactivate->name = $this->name;
			$this->dal->deactivate->execute();
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
			if($new)
				$this->dal->create($this);
			else
				$this->dal->update($this);
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
			$scraped = $this->getTorrents(false);
			foreach($this->read() as $item)
			{
				$torrent = preg_replace('/^[^:]*:\/\//','',html_entity_decode($item->get_permalink()));
				if(!isset($scraped[$torrent]))
					$this->addTorrent($item);
			}
		}

		public function getTorrents($protocol = true)
		{
			global $schema;
			$schema->torrents->getByFeed->feed = $this->name;
			$torrents = array();
			foreach($schema->torrents->getByFeed->execute()->getRows() as $torrent)
			{
				$tor = $torrent->torrent;
				if(!$protocol)
					$tor = preg_replace('/^[^:]*:\/\//','',$tor);
				$torrents[$tor] = $torrent->status;
			}
			return $torrents;
		}

		public function addTorrent($data)
		{
			global $schema;
			$url = html_entity_decode($data->get_permalink());
			$torrent = $schema->torrents->getTorrent($url);
			if($torrent)
			{
				if($torrent->feed != $this->name && $torrent->status == TORRENT_STATUS_NEW)
					$torrent->move($this->name);
				return $torrent;
			}
			$torrent = new Torrent($schema->torrents);
			$torrent->feed = $this->name;
			$torrent->torrent = $url;
			$torrent->title = $data->get_title();
			$torrent->status = TORRENT_STATUS_NEW;
			$torrent->save();
			return $torrent;
		}

		private $new = false;
	}
?>
