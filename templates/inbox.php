<?php
	if(count($torrents) == 0)
		echo 'There are no new torrents';
	else
	{
?>
<ul class="list-group history">
<?php
		foreach($torrents as $torrent)
		{
?>
	<li class="list-group-item">
		<div class="row">
			<div class="col-md-10"><?php echo $torrent->title; ?></div>
			<div class="col-md-2">
				<a class="btn btn-xs btn-primary" href="?start=<?php echo urlencode($torrent->torrent); ?>">Start</a>
				<a class="btn btn-xs btn-success" href="?skip=<?php echo urlencode($torrent->torrent); ?>">Skip</a>
			</div>
		</div>
	</li>
<?php
		}
	}
?>
</ul>
