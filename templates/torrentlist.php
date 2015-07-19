<?php
	$template = new KW_Template('torrent');
	$template->restart = true;
	$valid = 0;
	$lists = array();
	foreach($torrents as $torrent)
	{
		if($showAll || $torrent->validTarget())
		{
			$valid++;
			$template->torrent = $torrent;
			$list[$torrent->title] = (string)$template;
		}
	}
	if($valid)
	{
?>
<ul>
<?php
		ksort($list);
		echo join('', array_reverse($list));
?>
	<li class="list-group-item">
		<div class="row">
			<div class="col-md-9">&nbsp;</div>
			<div class="col-md-3">
				<a class="btn btn-xs btn-primary" style="width:50px" href="play?feed=<?php echo $torrent->feed; ?>&done=0">P.New</a>
				<a class="btn btn-xs btn-primary" style="width:50px"href="play?feed=<?php echo $torrent->feed; ?>&done=1">P.All</a>
				<a class="btn btn-xs btn-info" style="width:50px"href="watched?feed=<?php echo $torrent->feed; ?>">D.All</a>
			</div>
		</div>
	</li>
</ul>
	<script type="text/javascript">
		$(function(){ $('.row .show-head').click(function(){ $(this).parent().siblings('.show-list').toggle(); }); });
	</script>
<?php
	}
	if($valid)
		echo '</ul>';
	else
	{
?>
<h3>No files found for this feed, maybe they were moved or deleted?</h3>
<?php
	}
?>
