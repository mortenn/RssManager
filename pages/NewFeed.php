<?php
	class NewFeed extends KW_Module
	{
		public function __construct($schema)
		{
			$this->schema = $schema;
		}

		public function renderModule()
		{
			if($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$feed = new Feed($this->schema->feeds);
				$feed->name = $_POST['name'];
				$feed->term = $_POST['term'];
				$feed->active = true;
				$feed->save();
				$feed->scrape();
				redirect('/');
			}

			$template = new KW_Template('new');
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
