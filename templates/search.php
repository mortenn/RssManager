<form method="get" action="/index.php/search">
	<input type="text" name="term"<?php if(isset($term)) echo ' value="'.$term.'"'; ?>>
	<input type="submit" value="Search">
</form>
<?php
	if(isset($items))
		foreach($items as $item)
		{
			$desc = $item->get_description();
			$class = '';
			if(preg_match('/A+/', $desc))
				$class = ' aplus';
			else if(preg_match('/Trusted/', $desc))
				$class = ' trusted';
			else if(preg_match('/Remake/', $desc))
				$class = ' remake';
?>
<div class="hit<?php echo $class; ?> row">
	<div class="col-md-11">
		<?php echo $item->get_title(); ?><br>
		<?php echo $item->get_description(); ?>: <?php echo $item->get_permalink(); ?>
	</div>
	<div class="col-md-1">
		<a class="btn btn-xs btn-primary" href="add?torrent=<?php echo base64_encode(serialize(new WireTorrent($item))); ?>" style="margin: 10px 0 0 20px">Add</a>
	</div>
</div>
<?php
		}
?>
