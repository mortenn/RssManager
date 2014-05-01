<?php
	class WatchList extends KW_Module
	{
		public function __construct($schema)
		{
			$this->schema = $schema;
		}

		public function renderModule()
		{
			if(isset($_GET['torrent']))
			{
				$torrent = $this->schema->torrents->getTorrent($_GET['torrent']);
				$torrent->watched();
				redirect('/watch.php');
			}
			$template = new KW_Template('watch');
			$template->list = $this->schema->torrents->watchList();
			return $template;
		}

		private $schema;
	}
?>
