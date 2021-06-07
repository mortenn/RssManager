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
		{
			$desc = $item->description;
			$class = '';
			if(preg_match('/A+/', $desc))
				$class = ' aplus';
			else if(preg_match('/Trusted/', $desc))
				$class = ' trusted';
			else if(preg_match('/Remake/', $desc))
				$class = ' remake';
			printf('<div class="hit%s">%s<br>%s: %s</div>', $class, $item->title, $item->description, $item->url);
		}
?>
