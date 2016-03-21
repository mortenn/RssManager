<?php
	class FeedsTable extends KW_CacheAwareCRUDService
	{
		public function __construct(KW_SchemaManager $schema, ICacheState $state, IErrorHandler $error)
		{
			parent::__construct($schema, $state, $error);
		}

		public function getOrigin()
		{
			return 'https://nyaa.runsafe.no';
		}

		public function getKey()
		{
			return 'name';
		}

		public function hasAutoKey()
		{
			return false;
		}

		public function getValues()
		{
			return ['uri','active','term','autostart'];
		}

		public function getName()
		{
			return 'feeds';
		}

		public function getVersion()
		{
			return 4;
		}

		public function getNewObject($data)
		{
			return new Feed($this, $data);
		}

		public function process($object)
		{
			//... get active/inactive feeds
			if(isset($_GET['active']))
				return $this->search('active')->equals($_GET['active'] == 0 ? 0 : 1)->execute();

			//... search for feed by name
			if(isset($_GET['search']))
				return $this->search('name')->like('%'.trim($_GET['search']).'%')->execute();

			if(isset($_GET['feed']))
			{
				$feed = $this->read($_GET['feed']);

				if(isset($_GET['activate']) && !$feed->active)
					$feed->activate();

				else if(isset($_GET['deactivate']) && $feed->active)
					$feed->deactivate();

				else if(isset($_GET['autostart']))
					$feed->toggle();

				return $feed;
			}

			return parent::process($object);
		}

		public function prepare()
		{
			$this->deactivate = $this->db->prepare('UPDATE `feeds` SET `active`=0 WHERE `name`=:name');
			$this->activate = $this->db->prepare('UPDATE `feeds` SET `active`=1 WHERE `name`=:name');
			$this->autostart = $this->db->prepare('UPDATE `feeds` SET `autostart`=:value WHERE `name`=:name');
			parent::prepare();
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
