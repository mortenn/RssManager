<?xml version="1.0" encoding="UTF-8"?>
<playlist version="1" xmlns="http://xspf.org/ns/0/">
	<trackList>
<?php
	foreach($files as $file)
	{
		if($folder == '.')
			$path = $root . $file;
		else
			$path = $root . $folder . '/' . $file;
		if($broken_unicode)
			$path = utf8_encode($path);
?>
		<track><location><?php echo $path; ?></location></track>
<?php
	}
?>
	</trackList>
</playlist>
