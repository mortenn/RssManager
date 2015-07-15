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
			global $rpc_server;
			$rpc = new TransmissionRPC($rpc_server);
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
				global $rpc_server;
				$rpc = new TransmissionRPC($rpc_server);
				$result = $rpc->get((int)$this->id);
				if($result->result == 'success' && isset($result->arguments->torrents))
					return $result->arguments->torrents[0];
				else
				{
					$this->dal->setStatus->status = $this->status;
					$this->dal->setStatus->torrent = $this->torrent;
					$this->dal->setStatus->id = 0;
					$this->dal->setStatus->execute();
				}
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

		public function locateTarget()
		{
			$targetfile = $this->title;
			$target = TARGET . $this->feed;
			if(!is_dir($target) && is_dir(utf8_encode($target)))
				$target = utf8_encode($target);
			$target .= '/' . $targetfile;
			if(is_file($target) || is_dir($target))
				return $targetfile;
			$files = glob(TARGET.$this->feed.'/*');
			foreach($files as $filename)
			{
				$filename = str_replace(TARGET.$this->feed.'/', '', $filename);
				if($this->feed == '.' || !is_file(TARGET.$this->feed.'/'.$filename))
					continue;
				if(stristr($filename, $this->title) !== false)
					return $filename;
			}
			foreach($files as $filename)
			{
				$filename = str_replace(TARGET.$this->feed.'/', '', $filename);
				if($this->feed == '.' && is_file(TARGET.$filename))
					continue;
				if(stristr($this->title, $filename) !== false)
					return $filename;
			}
			return $this->title;
		}

		public function validTarget()
		{
			$target = TARGET.$this->feed;
			if(!is_dir($target) && is_dir(utf8_encode($target)))
				$target = utf8_encode($target);
			$realTarget = $this->locateTarget();
			if($realTarget)
				$target .= '/'.$realTarget;
			return $realTarget && (is_dir($target) || is_file($target)) && realpath($target) != realpath(TARGET);
		}

		public function getSubfiles()
		{
			$target = TARGET.$this->feed;
			if(!is_dir($target) && is_dir(utf8_encode($target)))
				$target = utf8_encode($target);
			$realTarget = $this->locateTarget();
			if($realTarget)
				$target .= '/'.$realTarget;
			if(!$realTarget || !is_dir($target) || realpath($target) == realpath(TARGET))
				return false;

			$real = array();
			$dir = opendir($target);
			while($e = readdir($dir))
				if(is_file($target.'/'.$e))
					$real[] = $e;
			sort($real);
			return $real;
		}

		public function playlist()
		{
			global $share, $broken_unicode;
			$playlist = new KW_Template('playlist');
			$playlist->broken_unicode = $broken_unicode;
			$playlist->root = $share;
			if(!is_dir(TARGET.$this->feed) && is_dir(utf8_encode(TARGET.$this->feed)))
				$playlist->folder = utf8_encode(TARGET.$this->feed);
			else
				$playlist->folder = $this->feed;
			$playlist->file = $this->locateTarget() . ($this->file ? '/' . $this->file : '');
			return $playlist;
		}
	}
?>
