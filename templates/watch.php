<?php
	if(count($last) > 0)
	{
?>
<ul class="list-group history">
<?php
		foreach(array_reverse($last) as $file)
		{
?>
	<li class="list-group-item">
		<div class="row">
			<div class="col-md-9"><?php echo $file->title; ?></div>
			<div class="col-md-3">
				<a class="btn btn-xs btn-primary" href="play?name=<?php echo urlencode($file->torrent); ?>">Play</a>
			</div>
		</div>
	</li>
<?php
		}
?>
</ul>
<?php
	}
	if(count($list) == 0)
		echo 'There is nothing to watch';
	else
	{
		$template = new KW_Template('torrent');
?>
<ul class="list-group">
<?php
		foreach($list as $file)
		{
			$template->torrent = $file;
			echo $template;
		}
?>
</ul>
<?php
	}
?>
