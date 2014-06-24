<?php
	class TorrentInbox extends KW_Module
	{
		public function __construct($schema)
		{
			$this->schema = $schema;
		}

		public function renderModule()
		{
			if(isset($_GET['start']))
			{
				$torrent = $this->schema->torrents->getTorrent($_GET['start']);
				if($torrent)
					$torrent->start();
				redirect('/index.php/inbox');
			}
			if(isset($_GET['skip']))
			{
				$torrent = $this->schema->torrents->getTorrent($_GET['skip']);
				if($torrent->status == TORRENT_STATUS_NEW)
					$torrent->skip();
				redirect('/index.php/inbox');
			}
			$template = new KW_Template('inbox');
			$template->torrents = $this->schema->torrents->getNew();
			return $template;
		}

		private $schema;
	}
?>
