<!DOCTYPE html>
<html>
	<head>
	
		<title><?php echo $titre; ?></title>
		
		<link rel="shortcut icon" type="image/png" href="/assets/design/images/favicon.png" />
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>" />

		<link rel="stylesheet" type="text/css" media="screen" href="/assets/design/css/styles.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="/assets/design/css/structure.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="/assets/design/css/general.css" />
<?php foreach($css as $url): ?>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $url; ?>" />
<?php endforeach; ?>

	</head>
	<body>

	<?php echo $speed; ?>
	
	<div id="conteneur">
		<div id="conteneur_entete">
			<?php echo $header; ?>
			<?php echo $menu; ?>
		</div>

		<div id="contenu">
			<?php echo $output; ?>
		</div>
		
		<div style="clear:both;"></div>

		<?php echo $footer; ?>
	</div>

	<script type="text/javascript" src="/assets/javascript/outils.js"></script>
<?php foreach($js as $url): ?>
	<script type="text/javascript" src="<?php echo $url; ?>"></script>
<?php endforeach; ?>

	</body>
</html>
