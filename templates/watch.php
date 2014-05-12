<?php
	if(count($list) == 0)
		echo 'There is nothing to watch';
	else
	{
?>
<ul class="list-group">
<?php
		foreach($list as $file)
			printf('<li class="list-group-item"><div class="row"><div class="col-md-11">%s</div><div class="col-md-1"><a class="btn btn-xs btn-success" href="watched?name=%s">Done</a></div></li>', $file->title, urlencode($file->torrent));
?>
</ul>
<?php
	}
?>
