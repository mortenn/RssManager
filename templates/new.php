<form method="get" action="/index.php/new">
	<input type="text" name="term"<?php if(isset($term)) echo ' value="'.$term.'"'; ?>>
	<input type="submit" value="Search">
</form>
<?php
	if(isset($term) && isset($items) && count($items) > 0)
	{
?>
<form method="post" action="/index.php/new">
	<input type="hidden" name="term" value="<?php echo $term; ?>">
	<input type="text" name="name" value="">
	<input type="submit" value="Add">
</form>
<?php
	}
	if(isset($items))
		foreach($items as $item)
			printf('%s<br>%s: %s<br>', $item->get_title(), $item->get_description(), $item->get_permalink());
?>
