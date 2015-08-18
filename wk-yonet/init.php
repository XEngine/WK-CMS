<?php
  /**
   * Init
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php //error_reporting(E_ALL);

  if (substr(PHP_OS, 0, 3) == "WIN") {
      $BASEPATH = str_replace("wk-yonet\\init.php", "", realpath(__file__));
  } else {
      $BASEPATH = str_replace("wk-yonet/init.php", "", realpath(__file__));
  }
  define("BASEPATH", $BASEPATH.'application\\');
  define("THEMEPATH", $BASEPATH);

  $configFile = BASEPATH . "lib/config.ini.php";
  if (file_exists($configFile)) {
      require_once ($configFile);
  } else {
      header("Location: setup/");
  }

  require_once (BASEPATH . "lib/class_db.php");

  require_once (BASEPATH . "lib/class_registry.php");
  Registry::set('Database', new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE));
  $db = Registry::get("Database");
  $db->connect();

  //Start Url Class 
  require_once (BASEPATH . "lib/class_url.php");
  Registry::set('Url',new Url());
  
  //Include Functions
  require_once (BASEPATH . "lib/functions.php");
  require_once (BASEPATH . "lib/fn_seo.php");
  
  require_once(BASEPATH . "lib/class_filter.php");
  $request = new Filter();
  
  //Start Core Class 
  require_once (BASEPATH . "lib/class_core.php");
  Registry::set('Core', new Core());
  $core = Registry::get("Core");

  //Start Language Class 
  require_once(BASEPATH . "lib/class_language.php");
  Registry::set('Lang',new Lang());
  
  //StartUser Class 
  require_once (BASEPATH . "lib/class_user.php");
  Registry::set('Users', new Users());
  $user = Registry::get("Users");
  
  //Load Content Class
  require_once (BASEPATH . "lib/class_content.php");
  Registry::set('Content', new Content());
  $content = Registry::get("Content");

  //Load Membership Class
  require_once(BASEPATH . "lib/class_membership.php");
  Registry::set('Membership', new Membership());
  $member = Registry::get("Membership");
  
  //Load Security Class
  require_once(BASEPATH . "lib/class_security.php");
  Registry::set('Security', new Security($core->attempt, $core->flood));
  $wksec = Registry::get("Security");

  //Start Paginator Class 
  require_once(BASEPATH . "lib/class_paginate.php");
  $pager = Paginator::instance();

  //Start Ini Parse Class
  require_once(BASEPATH . "/lib/class_iniparser.php");
  
  //Start Minify Class
  require_once (BASEPATH . "lib/class_minify.php");
  Registry::set('Minify', new Minify());
  
  if (isset($_SERVER['HTTPS'])) {
      $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
  } else {
      $protocol = 'http';
  }
  $dir = (Registry::get("Core")->site_dir) ? '/' . Registry::get("Core")->site_dir : '';
  $url = preg_replace("#/+#", "/", $_SERVER['HTTP_HOST'] . $dir);
  $site_url = $protocol . "://" . $url;
  
  define("SITEURL", $site_url);
  define("ADMINURL", $site_url."/wk-yonet");
  define("UPLOADS", THEMEPATH . "uploads/");
  define("UPLOADURL", SITEURL . "/uploads/");
  define("MODPATH", THEMEPATH."wk-yonet/modules/");
  define("PLUGPATH", THEMEPATH."wk-yonet/plugins/");
  define("THEMEURL", SITEURL."/theme/".$core->theme);
  define("THEME", THEMEPATH . "wk-yonet/assets");
  define("THEMEU", SITEURL . "/wk-yonet/assets");
  
  setlocale(LC_TIME, $core->setLocale());
?>