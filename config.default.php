<?php
  define('KW_TEMPLATE_DIR', 'templates/');
  define('RSS_URL', 'http://www.nyaa.se/?page=rss&cats=1_37&term=%s');
  define('TARGET', '/torrent/');

  /* Transmission connection details */
  define('TRANSMISSION_URL', 'http://localhost:9091/transmission/rpc');
  define('TRANSMISSION_USERNAME', '');
  define('TRANSMISSION_PASSWORD', '');

  $alertmail = '';
  $embed = true;
  $autoadd = false;
  $share = 'smb://server/torrent/';
  $broken_unicode = false;

  /* Database connection details */
  $db_username = '';
  $db_password = '';
  $db_server = 'localhost';
  $db_name = 'nyaa_feeds';

?>