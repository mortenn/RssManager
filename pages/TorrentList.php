<?php
	class TorrentList extends KW_Module
	{
		public function __construct($schema, $feed)
		{
			$this->schema = $schema;
			$this->feed = $feed;
		}

		public function renderModule()
		{
			$template = new KW_Template('torrentlist');
			$torrents = array();
			foreach($this->feed->getTorrents() as $torrent => $status)
				$torrents[] = $this->schema->torrents->getTorrent($torrent);
			$template->torrents = $torrents;
			return $template;
		}

		private $schema;
		private $feed;
	}
?>
