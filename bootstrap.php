<?php
	chdir(dirname(__FILE__));

	require_once('lib/functions.php');
	require_once('config.php');
	require_once('lib/KrameWork/KrameWork/KrameSystem.php');
	require_once('lib/simplepie_1.3.1.compiled.php');
	require_once('lib/PHP-Transmission-Class/class/TransmissionRPC.class.php');

	$system = new KrameSystem(KW_DEFAULT_FLAGS & ~KW_ENABLE_SESSIONS);
	if($alertmail)
		$system->getErrorHandler()->addEmailOutputRecipient($alertmail);
	$system->addAutoLoadPath('pages');
	$system->addAutoLoadPath('dal');
	$system->addAutoLoadPath('dto');

	$db = new KW_DatabaseConnection('mysql:dbname='.$db_name.';host='.$db_server, $db_username, $db_password);
	$schema = new KW_SchemaManager($db);
	$schema->addTable(new FeedsTable());
	$schema->addTable(new TorrentTable());
	$schema->update();

	$site = new KW_Template('site');
	$site->title = 'New page';
	$site->content = '';
?>
