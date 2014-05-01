<?php
	if(count($feeds) == 0)
		echo 'There are no feeds';
	else
	{
?>
<div class="row">
	<ul class="list-group">
<?php
		foreach($feeds as $feed)
		{
?>
		<li class="list-group-item">
			<div class="row">
				<div class="col-md-8">
					<?php echo $feed->name; ?>
					[<?php echo $statistics[$feed->name]->new . '/' . $statistics[$feed->name]->added . '/' . $statistics[$feed->name]->skipped; ?>]
					<br />
					<?php echo $feed->uri; ?>
				</div>
				<div class="col-md-4">
					<a class="btn btn-primary" href="/edit.php?name=<?php echo urlencode($feed->name); ?>">Edit</a>
					<a class="btn btn-danger" href="/?deactivate=<?php echo urlencode($feed->name); ?>">Deactivate</a>
				</div>
			</div>
		</li>
<?php
		}
?>
	</ul>
</div>
<?php
	}
?>
