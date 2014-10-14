<?php
	define('TORRENT_STATUS_NEW', 0);
	define('TORRENT_STATUS_ADDED', 1);
	define('TORRENT_STATUS_SKIPPED', 2);
	class TorrentTable extends KW_Repository
	{
		public function prepare()
		{
			$this->get = $this->db->prepare('SELECT * FROM `torrents` WHERE `torrent`=:torrent');
			$this->getByFeed = $this->db->prepare('SELECT * FROM `torrents` WHERE `feed`=:feed');
			$this->getByStatus = $this->db->prepare('SELECT * FROM `torrents` WHERE `status`=:status');
			$this->getWatchList = $this->db->prepare('SELECT * FROM `torrents` WHERE (`watched` IS NULL OR `watched` = 0) AND `status`='.TORRENT_STATUS_ADDED.' ORDER BY `added`');
			$this->getWatchedList = $this->db->prepare('SELECT * FROM `torrents` WHERE `watched`=1 ORDER BY `modified` DESC, `added` DESC LIMIT 2');
			$this->setWatched = $this->db->prepare('UPDATE `torrents` SET `watched`=1 WHERE `torrent`=:torrent');
			$this->add = $this->db->prepare('INSERT INTO `torrents` (`feed`,`torrent`,`title`,`status`,`added`) VALUES (:feed,:torrent,:title,:status,NOW())');
			$this->setStatus = $this->db->prepare('UPDATE `torrents` SET `status`=:status WHERE `torrent`=:torrent');
			$this->statistics = $this->db->prepare('
SELECT
	`feed`,
	COUNT(CASE WHEN `status`='.TORRENT_STATUS_NEW.' THEN `torrent` END) AS `new`,
	COUNT(CASE WHEN `status`='.TORRENT_STATUS_ADDED.' THEN `torrent` END) AS `added`,
	COUNT(CASE WHEN `status`='.TORRENT_STATUS_SKIPPED.' THEN `torrent` END) AS `skipped`
FROM `torrents`
GROUP BY `feed`');
		}

		public function getTorrent($torrent)
		{
			$this->get->torrent = $torrent;
			$data = $this->get->execute()->getRows();
			if(count($data) == 1)
				return new Torrent($this, $data[0]);
		}

		public function watchList()
		{
			$torrents = array();
			foreach($this->getWatchList->getRows() as $torrent)
				$torrents[] = new Torrent($this, $torrent);
			return $torrents;
		}

		public function watchedList()
		{
			$torrents = array();
			foreach($this->getWatchedList->getRows() as $torrent)
				$torrents[] = new Torrent($this, $torrent);
			return $torrents;
		}

		public function getNew()
		{
			$this->getByStatus->status = TORRENT_STATUS_NEW;
			$torrents = array();
			foreach($this->getByStatus->getRows() as $data)
				$torrents[] = new Torrent($this, $data);
			return $torrents;
		}

		public function getName()
		{
			return 'torrents';
		}

		public function getVersion()
		{
			return 5;
		}

		public function getQueries()
		{
			return array(
				1 => array('
CREATE TABLE `torrents` (
	`feed` VARCHAR(50),
	`torrent` VARCHAR(200),
	`status` TINYINT,
	PRIMARY KEY(`torrent`)
)'
				),
				2 => array('ALTER TABLE `torrents` ADD COLUMN `title` VARCHAR(100)'),
				3 => array('ALTER TABLE `torrents` ADD COLUMN `watched` BOOLEAN'),
				4 => array('ALTER TABLE `torrents` ADD COLUMN `added` DATETIME'),
				5 => array('ALTER TABLE `torrents` ADD COLUMN `modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP')
			);
		}
	}
?>
