Feed for <?php echo $feed->name; ?>:<br>
<form method="post" action="/edit.php">
	<input type="hidden" name="name" value="<?php echo $feed->name; ?>">
	<input type="hidden" name="term" value="<?php echo $feed->term; ?>">
	<input type="submit" value="Save">
</form>
<form method="get" action="/edit.php">
	<input type="hidden" name="name" value="<?php echo $feed->name; ?>">
	<input type="text" name="term" value="<?php echo $feed->term; ?>" size="50">
	<input type="submit" value="Search">
</form>

<?php
	$items = $feed->read();
	if(is_array($items))
		foreach($items as $item)
			printf('%s<br>%s: %s<br>', $item->get_title(), $item->get_description(), $item->get_permalink());
?>
