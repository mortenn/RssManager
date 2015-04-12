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
?>
<ul class="list-group">
<?php
		foreach($list as $file)
		{
			$real = false;
			if(is_dir(TARGET.$file->feed.'/'.$file->title))
			{
				$real = array();
				$dir = opendir(TARGET.$file->feed.'/'.$file->title);
				while($e = readdir($dir))
					if(is_file(TARGET.$file->feed.'/'.$file->title.'/'.$e))
						$real[] = $e;
				sort($real);
			}
			$status = $file->status();
			if($status != null)
				$done = isset($status->haveValid) && $status->haveValid == $status->totalSize;
			else
				$done = true;
?>
	<li class="list-group-item">
		<div class="row">
			<div class="col-md-10"><?php echo $file->title; ?></div>
			<div class="col-md-2">
				<a class="btn btn-xs btn-primary<?php if($real || !$done) echo ' disabled'; ?>" href="play?name=<?php echo urlencode($file->torrent); ?>">Play</a>
				<a class="btn btn-xs btn-success<?php if(!$done) echo ' disabled'; ?>" href="watched?name=<?php echo urlencode($file->torrent); ?>">Done</a>
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
				<a class="btn btn-xs btn-primary<?php if(preg_match('/.part$/', $content)) echo ' disabled'; ?>" href="play?name=<?php echo urlencode($file->torrent); ?>&file=<?php echo urlencode($content); ?>">Play</a>
			</div>
<?php
					}
				}
?>
		</div>
	</li>
<?php
		}
?>
</ul>
<?php
	}
?>
