<?php
	function redirect($url)
	{
		header('HTTP/1.1 303 See Other');
		header('Location: '.$url);
		die();
	}

	function isInvisible($feed)
	{
		global $invisible;
		return in_array($feed, $invisible);
	}
?>
