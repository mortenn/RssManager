<?php
	class WireTorrent
	{
		public function __construct($data)
		{
			$this->uri = $data->get_permalink();
			$this->title = $data->get_title();
		}

		public function get_permalink()
		{
			return $this->uri;
		}

		public function get_title()
		{
			return $this->title;
		}

		private $uri;
		private $title;
	}
?>
