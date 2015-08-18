<?php
  /**
   * Controller
   *
   * @package wk:cms
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
   
  define("_VALID_PHP", true);
  
  require_once("../../init.php");
 
  require_once(MODPATH . "forms/admin_class.php");
  Registry::set('Forms',new Forms());
?>
<?php
  if (isset($_POST['processForm'])):
     Registry::get("Forms")->sendForm();
  endif;
?>