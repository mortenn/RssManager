<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="device-width, initial-scale=1">
		<title><?php echo $title; ?></title>
		<link rel="icon" type="image/x-icon" href="/favicon.ico">
		<link rel="icon" type="image/png" href="/favicon.png">
		<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<?php
	if($theme)
	{
?>
		<link rel="stylesheet" href="https://bootswatch.com/<?php echo $theme; ?>/bootstrap.min.css">
<?php
	}
	else
	{
?>
		<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
<?php
	}
?>
		<link rel="stylesheet" href="/css/local.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<nav class="navbar navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav"><?php
	foreach($menu as $action => $label)
	{
		printf('<li%s><a href="/index.php/%s">%s</a></li>', $action == $page ? ' class="active"' : '', $action, $label);
	}
?></ul>
<?php
	if($transmission)
	{
?>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="<?php echo $transmission; ?>" target="_blank"><img src="<?php echo $transmission; ?>images/favicon.png"></a></li>
					</ul>
<?php
	}
?>
				</div>
			</div>
		</nav>
		<div class="container">
			<br /><br /><br />
			<p><?php echo $content; ?></p>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	</body>
</html>
