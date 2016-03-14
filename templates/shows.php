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
				<a style="width:50px" class="btn btn-xs btn-primary" href="play?name=<?php echo urlencode($file->torrent); ?>">Play</a>
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
		$shows = array();
		foreach($list as $file)
		{
			if(isInvisible($file->feed))
			{
				$shows[$file->title] = $file;
				continue;
			}
			if(!isset($shows[$file->feed]))
				$shows[$file->feed] = array();
			$shows[$file->feed][$file->title] = $file;
		}
		foreach($shows as $feed => $files)
		{
			if(is_array($files))
				ksort($shows[$feed]);
		}
		ksort($shows);
?>
<ul class="list-group">
<?php
		foreach($shows as $show => $files)
		{
			if(!is_array($files))
			{
				$template->torrent = $files;
				echo $template;
				continue;
			}
?>
	<li class="list-group-item">
		<div class="row">
			<div class="col-md-9 show-head">
				<a href="torrents?feed=<?php echo urlencode($show); ?>"><?php echo $show; ?></a>
				<span class="badge"><?php echo count($files); ?></span>
			</div>
			<div class="col-md-3">
				<a class="btn btn-xs btn-primary" style="width:50px" href="play?feed=<?php echo urlencode($show); ?>&done=0">P.All</a>
				<a class="btn btn-xs btn-info" style="width:50px" href="watched?feed=<?php echo urlencode($show); ?>">D.All</a>
			</div>
		</div>
		<div class="row show-list">
			<div class="col-md-12">
				<ul class="list-group">
<?php
			foreach($files as $file)
			{
				$template->torrent = $file;
				echo $template;
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
