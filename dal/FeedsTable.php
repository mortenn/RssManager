<?php
	class FeedsTable extends KW_Repository
	{
		public function prepare()
		{
			$this->get = $this->db->prepare('SELECT * FROM `feeds` WHERE `name`=:name');
			$this->loadActive = $this->db->prepare('SELECT * FROM `feeds` WHERE `active`=1');
			$this->loadInactive = $this->db->prepare('SELECT * FROM `feeds` WHERE `active`=0');
			$this->deactivate = $this->db->prepare('UPDATE `feeds` SET `active`=0 WHERE `name`=:name');
			$this->activate = $this->db->prepare('UPDATE `feeds` SET `active`=1 WHERE `name`=:name');
			$this->autostart = $this->db->prepare('UPDATE `feeds` SET `autostart`=:value WHERE `name`=:name');
			$this->search = $this->db->prepare('SELECT * FROM `feeds` WHERE name LIKE :query');
			$this->save = $this->db->prepare('
INSERT INTO feeds (`name`,`uri`,`term`,`active`) VALUES (:name,:uri,:term,:active)
	ON DUPLICATE KEY UPDATE `term`=VALUES(`term`),`uri`=VALUES(`uri`),`active`=VALUES(`active`)');
		}

		public function getFeed($name)
		{
			$this->get->name = $name;
			$this->get->execute();
			$result = $this->get->getRows();
			if(count($result) == 1)
				return new Feed($this, $result[0]);
			return null;
		}

		public function getActiveFeeds()
		{
			$feeds = array();
			foreach($this->loadActive->getRows() as $feed)
				$feeds[] = new Feed($this, $feed);
			return $feeds;
		}

		public function getInActiveFeeds()
		{
			$feeds = array();
			foreach($this->loadInactive->getRows() as $feed)
				$feeds[] = new Feed($this, $feed);
			return $feeds;
		}

		public function getFeeds($query)
		{
			$feeds = array();
			$this->search->query = '%'.trim($query).'%';
			foreach($this->search->getRows() as $feed)
				$feeds[] = new Feed($this, $feed);
			return $feeds;
		}

		public function saveFeed($feed)
		{
			$this->save->name = $feed->name;
			$this->save->uri = $feed->uri;
			$this->save->term = $feed->term;
			$this->save->active = $feed->active;
			$this->save->execute();
		}

		public function getName()
		{
			return 'feeds';
		}

		public function getVersion()
		{
			return 4;
		}

		public function getQueries()
		{
			return array(
				1 => array('
CREATE TABLE `feeds` (
	`name` VARCHAR(50),
	`uri` VARCHAR(500),
	`active` BOOL,
	PRIMARY KEY(`name`)
)'
				),
				2 => array('ALTER TABLE `feeds` ADD COLUMN (`term` VARCHAR(100))'),
				3 => array('ALTER TABLE `feeds` ADD COLUMN (`autostart` BOOL)'),
				4 => array('ALTER TABLE `feeds` MODIFY COLUMN `name` VARCHAR(100)')
			);
		}
	}
?>
