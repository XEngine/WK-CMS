<?php
  /**
   * Login Module
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<!-- Start Login Module -->
<?php if($user->logged_in):?>
<strong><?php echo Lang::$word->_WELCOME;?>:</strong>&nbsp; <a href="<?php echo Url::Page($core->account_page);?>"><?php echo $user->name;?></a> &bull; <a href="<?php echo SITEURL;?>/logout.php"><?php echo Lang::$word->_N_LOGOUT;?></a>
<?php else:?>
<form action="<?php echo Url::Page($core->login_page);?>" method="post" class="wk small form" name="login_form_mod">
  <div class="field">
    <input placeholder="<?php echo Lang::$word->_USERNAME;?>" name="username" type="text" maxlength="20">
  </div>
  <div class="field">
    <input placeholder="<?php echo Lang::$word->_PASSWORD;?>" name="password" type="password" maxlength="20">
  </div>
  <div class="field">
    <button name="submit" type="submit" class="wk button"><?php echo Lang::$word->_UA_LOGINNOW;?></button>
  </div>
  <input name="doLogin" type="hidden" value="1">
</form>
<?php endif;?>
<!-- End Login Module /-->