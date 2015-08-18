<?php
  /**
   * Controller
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2012
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  define("_VALID_PHP", true);
  
  require_once("../../init.php");

  require_once(MODPATH . "adblock/admin_class.php");
  Registry::set('AdBlock', new AdBlock());
?>
<?php 
  /* Proccess AdClick */
  if (isset($_GET['adC'])):
      $fname = substr($_GET['f'],42);
  	  Filter::$id= (isset($_GET['adC'])) ? $_GET['adC'] : 0; 
  	  if($fname != md5(sha1(Filter::$id))) die('err');
  	  Registry::get("AdBlock")->incrementClicksNumber();
  endif;
?>