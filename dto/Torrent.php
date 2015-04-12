<?php
	class Torrent extends KW_DataContainer
	{
		public function __construct($dal, $data = null, $file = null)
		{
			if($data != null)
				parent::__construct($data->getAsArray());
			$this->dal = $dal;
			$this->file = $file;
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
				if(isset($result->arguments->torrent_duplicate))
					$this->dal->setStatus->id = $result->arguments->torrent_duplicate->id;
				else if(isset($result->arguments->torrent_added))
					$this->dal->setStatus->id = $result->arguments->torrent_added->id;
				else
					$this->dal->setStatus->id = 0;
				$this->dal->setStatus->status = TORRENT_STATUS_ADDED;
				$this->dal->setStatus->torrent = $this->torrent;
				$this->dal->setStatus->execute();
				return true;
			}
			return false;
		}

		public function status()
		{
			if($this->id)
			{
				$rpc = new TransmissionRPC('http://10.0.100.105:9091/transmission/rpc');
				$result = $rpc->get((int)$this->id);
				if($result->result == 'success')
					return $result->arguments->torrents[0];
			}
		}

		public function skip()
		{
			$this->dal->setStatus->torrent = $this->torrent;
			$this->dal->setStatus->status = TORRENT_STATUS_SKIPPED;
			$this->dal->setStatus->id = $this->id;
			$this->dal->setStatus->execute();
		}

		public function watched()
		{
			$this->dal->setWatched->torrent = $this->torrent;
			$this->dal->setWatched->execute();
		}

		public function move($feed)
		{
			$this->dal->setFeed->feed = $feed;
			$this->dal->setFeed->torrent = $this->torrent;
			$this->dal->setFeed->execute();
		}

		public function playlist()
		{
			global $share, $broken_unicode;
			$playlist = new KW_Template('playlist');
			$playlist->broken_unicode = $broken_unicode;
			$playlist->root = $share;
			$playlist->folder = $this->feed;
			$playlist->file = $this->title . ($this->file ? '/' . $this->file : '');
			return $playlist;
		}
	}
?>
