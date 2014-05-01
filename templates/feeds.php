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
				<div class="col-md-10">
					<div class="row">
						<?php echo $feed->name; ?>
						[<span class="feed-new-torrent"><?php 

			echo $statistics[$feed->name]->new; 

?></span>/<span class="feed-added-torrent"><?php

			echo $statistics[$feed->name]->added;

?></span>/<span class="feed-skipped-torrent"><?php

			echo $statistics[$feed->name]->skipped;

?></span>]
					</div>
					<div class="row">
						<span class="feed-url"><?php echo $feed->uri; ?></span>
					</div>
				</div>
				<div class="col-md-2">
					<a class="btn btn-xs btn-primary" href="/edit.php?name=<?php echo urlencode($feed->name); ?>">Edit</a>
					<a class="btn btn-xs btn-danger" href="/?deactivate=<?php echo urlencode($feed->name); ?>">Deactivate</a>
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
