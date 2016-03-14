<?php
	chdir(dirname(__FILE__));

	require_once('lib/functions.php');
	require_once('config.php');
	require_once('lib/KrameWork/KrameWork/KrameSystem.php');
	require_once('lib/simplepie_1.3.1.compiled.php');
	require_once('lib/PHP-Transmission-Class/class/TransmissionRPC.class.php');

	if(!preg_match($allow_from, $_SERVER['REMOTE_ADDR']))
	{
		header('HTTP/1.1 403 Forbidden');
		die();
	}

	$system = new KrameSystem(KW_DEFAULT_FLAGS & ~KW_ENABLE_SESSIONS);
	if($alertmail)
		$system->getErrorHandler()->addEmailOutputRecipient($alertmail);
	$system->addAutoLoadPath('pages');
	$system->addAutoLoadPath('dal');
	$system->addAutoLoadPath('dto');

	$db = new KW_DatabaseConnection('mysql:dbname='.$db_name.';host='.$db_server, $db_username, $db_password);
	$system->addBinding('ISchemaTable', 'FeedsTable');
	$system->addBinding('ISchemaTable', 'TorrentTable');
	$system->addBinding('IDatabaseConnection', $db);
	$system->addBinding('ISchemaManager', 'KW_SchemaManager');
	$schema = $system->getComponent('ISchemaManager');
	$schema->update();

	$site = new KW_Template('site');
	$site->title = 'New page';
	$site->content = '';
?>
