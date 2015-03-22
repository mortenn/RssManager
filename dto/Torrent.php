<?php
	class Torrent extends KW_DataContainer
	{
		public function __construct($dal, $data = null)
		{
			if($data != null)
				parent::__construct($data->getAsArray());
			$this->dal = $dal;
		}

		public function save()
		{
			$this->dal->add->feed = $this->feed;
			$this->dal->add->torrent = $this->torrent;
			$this->dal->add->title = $this->title;
			$this->dal->add->status = $this->status;
			$this->dal->add->execute();
		}

		public function start()
		{
			$rpc = new TransmissionRPC('http://10.0.100.105:9091/transmission/rpc');
			$result = $rpc->add($this->torrent, TARGET.$this->feed);
			if($result->result == 'success')
			{
				$this->dal->setStatus->status = TORRENT_STATUS_ADDED;
				$this->dal->setStatus->torrent = $this->torrent;
				$this->dal->setStatus->execute();
				return true;
			}
			return false;
		}

		public function skip()
		{
			$this->dal->setStatus->torrent = $this->torrent;
			$this->dal->setStatus->status = TORRENT_STATUS_SKIPPED;
			$this->dal->setStatus->execute();
		}

		public function watched()
		{
			$this->dal->setWatched->torrent = $this->torrent;
			$this->dal->setWatched->execute();
		}

		public function playlist()
		{
			global $share, $broken_unicode;
			$playlist = new KW_Template('playlist');
			$playlist->broken_unicode = $broken_unicode;
			$playlist->root = $share;
			$playlist->folder = $this->feed;
			$playlist->file = $this->title;
			return $playlist;
		}
	}
?>
