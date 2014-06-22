<?php
	class WatchList extends KW_Module
	{
		public function __construct($schema)
		{
			$this->schema = $schema;
		}

		public function renderModule()
		{
			$template = new KW_Template('watch');
			$template->last = $this->schema->torrents->watchedList();
			$template->list = $this->schema->torrents->watchList();
			return $template;
		}

		private $schema;
	}
?>
