<?php
  /**
   * Logout
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  define("_VALID_PHP", true);
  
  require_once("init.php");
  Security::writeLog(Lang::$word->_USER . ' ' . $user->username . ' ' . Lang::$word->_LG_LOGOUT, "user", "no", "user");
?>
<?php
  if ($user->logged_in)
      $user->logout();
	  
  redirect_to(SITEURL);
?>