<?php
function error_page ($message, $error_title) { ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>

<!-- Make all declarations-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="author" content="Light Is Everything">
<meta name="copyright" content="&copy; 2009 Light Is Everything">
<meta name="keywords" content="framwork,php">
<title><?php echo $error_title ?></title>
</head>
<body>
  <h1><?php echo $error_title ?></h1>
  <p><?php echo htmlspecialchars($message)?></p>
</body>
</html>
  <?php
  exit;
} ?>