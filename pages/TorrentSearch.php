<?php
	class TorrentSearch extends KW_Module
	{
		public function __construct($schema)
		{
			$this->schema = $schema;
		}

		public function renderModule()
		{
			$template = new KW_Template('search');
			if(isset($_GET['term']))
			{
				$template->term = $_GET['term'];
				$template->items = Feed::Search($_GET['term']);
			}
			return $template;
		}

		private $schema;
	}
?>
