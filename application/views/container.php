<?php
	echo doctype('html5');
	header("Content-type: text/html; charset=utf-8");
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="public/assets/stylesheets/towing.style.css" />

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
<div class="l-topbar">
  <div class="logo"></div>
  <div class="menu">
  <?php
  if(isset($available_modules) && !empty($available_modules)) {
    echo "<ul>";

    foreach($available_modules as $module) {
        echo sprintf('<li><a href="/%s/index">%s</a></li>', strtolower($module->code), $module->name);
    }

    echo "</ul>";
  }
  ?>
  </div>
</div>
<div class="container">
    <?php echo $content; ?>
</div>

</body>
</html>
