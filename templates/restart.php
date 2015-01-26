<form method="get" action="restart">
	<input name="query" type="text" value="<?php echo $query; ?>" />
	<input type="submit" value="Search" />
</form>
<?php
	if($query)
	{
		if(count($torrents) == 0)
			echo 'There are no matching torrents';
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
				<a class="btn btn-xs btn-primary" href="?query=<?php echo $query; ?>&start=<?php echo urlencode($torrent->torrent); ?>">Readd</a>
			</div>
		</div>
	</li>
<?php
			}
		}
	}
?>
</ul>
