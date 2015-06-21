<ul>
<?php
	$template = new KW_Template('torrent');
	foreach($torrents as $torrent)
	{
		$template->torrent = $torrent;
		echo $template;
	}
?>
	<li class="list-group-item">
		<div class="row">
			<div class="col-md-10">&nbsp;</div>
			<div class="col-md-2">
				<a class="btn btn-xs btn-primary" href="play?feed=<?php echo $torrent->feed; ?>&done=0">Play new</a>
				<a class="btn btn-xs btn-primary" href="play?feed=<?php echo $torrent->feed; ?>&done=1">Play all</a>
			</div>
		</div>
	</li>
</ul>
