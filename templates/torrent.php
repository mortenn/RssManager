<?php
	$targetfile = $torrent->locateTarget();
	$real = $torrent->getSubfiles();
	$status = $torrent->status();
	$done = false;
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	if(file_exists(TARGET.$torrent->feed.'/'.$targetfile))
		$done = true;
	if($status != null && $done)
		$done = isset($status->haveValid) && $status->haveValid == $status->totalSize;
?>
<li class="list-group-item">
	<div class="row">
		<div class="col-md-9"><?php if(empty($targetfile)) echo $torrent->title; else echo $targetfile; ?></div>
		<div class="col-md-3">
			<a style="width:50px" class="btn btn-xs btn-primary<?php if(!$done) echo ' disabled'; ?>" href="play?name=<?php echo urlencode($torrent->torrent); ?>"><?php echo $real ? 'P.All' : 'Play'; ?></a>
			<a style="width:50px" class="btn btn-xs btn-success<?php if($torrent->watched || !$done) echo ' disabled'; ?>" href="watched?name=<?php echo urlencode($torrent->torrent); ?>">Done</a>
		</div>
<?php
	if($real)
	{
		foreach($real as $content)
		{
			if(file_exists(TARGET.$targetfile.'/'.$content))
				$mime = finfo_file($finfo, TARGET.$targetfile.'/'.$content);
			else
				$mime = '-';
?>
	</div>
	<div class="row subfile">
		<div class="col-md-9"><?php echo $content; ?></div>
		<div class="col-md-3">
			<a style="width:50px" class="btn btn-xs btn-primary<?php if($mime == 'text/plain' || preg_match('/.part$/', $content)) echo ' disabled'; ?>" href="play?name=<?php echo urlencode($torrent->torrent); ?>&file=<?php echo urlencode($content); ?>">Play</a>
		</div>
<?php
		}
	}
?>
	</div>
</li>
