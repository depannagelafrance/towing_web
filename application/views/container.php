<!DOCTYPE html>
<?php header("Content-type: text/html; charset=utf-8");?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
    <title><?= $title ?></title>
   <?php
	if (isset($css)) {
		foreach ($css as $file) {
			print link_tag('css/' . $file);
		}
	}
	if (!empty($js)) {
		foreach ($js as $file) {
			print '<script type="text/javascript" src="' . site_url($file) . '"></script>';
		}
	}
	?>

</head>
<body>
<div class="container">
    <?php echo $content; ?>
</div>

</body>
</html>