<?php
	if(count($list) == 0)
		echo 'There is nothing to watch';
	else
		foreach($list as $file)
			printf('%s <a href="watched?name=%s">Done</a><br>', $file->title, urlencode($file->torrent));
?>
