<?php
	class TorrentRestart extends KW_Module
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
				redirect('/index.php/restart?query='.$_GET['query']);
			}
			$template = new KW_Template('restart');
			if(isset($_GET['query']) && trim($_GET['query']) != '')
				$query = $_GET['query'];
			else
				$query = null;

			$template->query = $query;
			$template->torrents = $query ? $this->schema->torrents->getMatching($query) : array();
			return $template;
		}

		private $schema;
	}
?>
