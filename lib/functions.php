<?php
	function redirect($url)
	{
		header('HTTP/1.1 303 See Other');
		header('Location: '.$url);
		die();
	}
?>
