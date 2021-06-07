<?php
	class WireTorrent
	{
		public function __construct($data)
		{
			$this->uri = $data->uri;
			$this->title = $data->title;
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
