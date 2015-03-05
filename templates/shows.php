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
			<div class="col-md-10"><?php echo $file->title; ?></div>
			<div class="col-md-2">
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
		$shows = array();
		foreach($list as $file)
		{
			if(!isset($shows[$file->feed]))
				$shows[$file->feed] = array();
			$shows[$file->feed][$file->title] = $file;
		}
		foreach($shows as $feed => &$files)
			ksort($files);
		ksort($shows);
?>
<ul class="list-group">
<?php
		foreach($shows as $show => $files)
		{
?>
	<li class="list-group-item">
		<div class="row">
			<div class="col-md-12 show-head"><?php echo $show.' ('.count($files).')'; ?></div>
		</div>
		<div class="row show-list">
			<div class="col-md-12">
				<ul class="list-group">
<?php
			foreach($files as $file)
			{
?>
	<li class="list-group-item">
		<div class="row">
			<div class="col-md-10"><?php echo $file->title; ?></div>
			<div class="col-md-2">
				<a class="btn btn-xs btn-primary" href="play?name=<?php echo urlencode($file->torrent); ?>">Play</a>
				<a class="btn btn-xs btn-success" href="watched?name=<?php echo urlencode($file->torrent); ?>">Done</a>
			</div>
		</div>
	</li>
<?php
			}
?>
				</ul>
			</div>
		</div>
	</li>
<?php
		}
?>
</ul>
<?php
	}
?>
<script type="text/javascript">
	$(function(){ $('.row .show-head').click(function(){ $(this).parent().siblings('.show-list').toggle(); }); });
</script>
