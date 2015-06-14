<?php
	$targetfile = $torrent->locateTarget();
	$real = $torrent->getSubfiles();
	$status = $torrent->status();
	$done = false;
	if($status != null)
		$done = isset($status->haveValid) && $status->haveValid == $status->totalSize;
	else if(file_exists($targetfile))
		$done = true;
?>
<li class="list-group-item">
	<div class="row">
		<div class="col-md-10"><?php if(empty($targetfile)) echo $torrent->title; else echo $targetfile; ?></div>
		<div class="col-md-2">
			<a class="btn btn-xs btn-primary<?php if($real || !$done) echo ' disabled'; ?>" href="play?name=<?php echo urlencode($torrent->torrent); ?>">Play</a>
			<a class="btn btn-xs btn-success<?php if(!$done) echo ' disabled'; ?>" href="watched?name=<?php echo urlencode($torrent->torrent); ?>">Done</a>
		</div>
<?php
	if($real)
	{
		foreach($real as $content)
		{
?>
	</div>
	<div class="row subfile">
		<div class="col-md-10"><?php echo $content; ?></div>
		<div class="col-md-2">
			<a class="btn btn-xs btn-primary<?php if(preg_match('/.part$/', $content)) echo ' disabled'; ?>" href="play?name=<?php echo urlencode($torrent->torrent); ?>&file=<?php echo urlencode($content); ?>">Play</a>
		</div>
<?php
		}
	}
?>
	</div>
</li>
