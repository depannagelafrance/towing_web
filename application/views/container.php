<?php
	echo doctype('html5');
	header("Content-type: text/html; charset=utf-8");
?>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="/public/bower_components/chosen/chosen.min.css" />
  <link rel="stylesheet" type="text/css" href="/public/assets/stylesheets/towing.style.css" />
  <script src="/public/bower_components/jquery/dist/jquery.min.js"></script>
  <script src="/public/bower_components/chosen/chosen.jquery.min.js"></script>
  <script type="application/javascript">
    $(document).ready(function() {
      $('select').chosen();
    });
  </script>

  <title><?php print $title ?></title>
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
  <div class="l-topbar topbar">
    <div class="l-topbar-content topbar-content">
      <div class="l-branding">
        <div class="logo"></div>
      </div>
      <div class="l-main-navigation">
        <nav class="main-navigation">
          <?php if(isset($available_modules) && !empty($available_modules)) : ?>
            <ul>
              <?php foreach($available_modules as $module) : ?>
                <?php print sprintf('<li><a href="/%s/index">%s</a></li>', strtolower($module->code), $module->name); ?>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </nav>
      </div>
      <div class="l-user-navigation">
        <div class="user-navigation bright">
          <div class="l-user-action"><a href="#" class="icon--user"></a></div>
          <div class="l-user-action"><a href="#" class="icon--settings"></a></div>
          <div class="l-user-action"><a href="#" class="icon--off"></a></div>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="layout-full">
      <div class="layout-center">
        <?php print $content; ?>
      </div>
    </div>
  </div>

</body>
</html>
