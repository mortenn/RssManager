<?php
	class EditFeed extends KW_Module
	{
		public function __construct($schema)
		{
			$this->schema = $schema;
		}

		public function renderModule()
		{
			if($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$feed = $this->schema->feeds->getFeed($_POST['name']);
				if($feed)
				{
					$feed->term = $_POST['term'];
					$feed->save();
					$feed->scrape();
				}
				redirect('/');
			}

			$feed = $this->schema->feeds->getFeed($_GET['name']);
			if(isset($_GET['term']))
				$feed->term = $_GET['term'];

			$template = new KW_Template('edit');
			$template->feed = $feed;
			return $template;
		}

		private $schema;
	}
?>
