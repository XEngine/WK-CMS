<?php
  /**
   * User
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  define("_VALID_PHP", true);
  require_once("../init.php");
?>
<?php
  /* == Registration == */
  if (isset($_POST['doRegister'])):
      $user->register();
  endif;

  /* == Password Reset == */
  if (isset($_POST['passReset'])):
      $user->passReset();
  endif;

  /* == Account Acctivation == */
  if (isset($_POST['accActivate'])):
      $user->activateUser();
  endif;
?>