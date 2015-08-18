<?php
  /**
   * Activation Template
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  if ($user->logged_in)
      redirect_to(Url::Page($core->account_page));
?>
<div class="columns">
  <div class="screen-50 phone-100 push-center">
    <p><i class="information icon"></i> <?php echo Lang::$word->_UA_INFO5;?></p>
    <div class="wk secondary segment form">
      <form id="wk_form" name="wk_form" method="post">
        <h3><?php echo Lang::$word->_UA_SUBTITLE5;?></h3>
        <div class="field">
          <label><?php echo Lang::$word->_UR_EMAIL;?> <i class="small icon asterisk"></i></label>
          <input name="email" placeholder="<?php echo Lang::$word->_UR_EMAIL;?>" value="<?php if(get('email')) echo sanitize($_GET['email']);?>" type="text">
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_UA_TOKEN;?> <i class="small icon asterisk"></i></label>
          <input name="token" placeholder="<?php echo Lang::$word->_UA_TOKEN;?>" value="<?php if(get('token')) echo sanitize($_GET['token']);?>" type="text">
        </div>
        <button data-url="/ajax/user.php" type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_UA_ACTIVATE_ACC;?></button>
        <input name="accActivate" type="hidden" value="1">
      </form>
    </div>
    <div id="msgholder"></div>
  </div>
</div>