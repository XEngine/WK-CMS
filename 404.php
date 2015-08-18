<?php
  /**
   * 404
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  define("_VALID_PHP", true);
  require_once("init.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>404 Error! | <?php echo $core->site_name;?></title>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet" type="text/css">
<link href="<?php echo THEMEURL;?>/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php require_once (THEMEDIR . "/templates/404.tpl.php");;?>
</body>
</html>