<?php
echo doctype('html5');
header("Content-type: text/html; charset=utf-8");
?>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="/public/assets/stylesheets/towing.style.css" />
  <script src="/public/assets/js/jquery/jquery.min.js"></script>

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
<div class="login_container">
  <div class="login_messages">
    <?php print isset($error) ? '<div class="msg msg__error">' . $error . '</div>' : ''; ?>
  </div>
  <?php print $content; ?>
</div>
</body>
</html>
