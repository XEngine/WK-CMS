<?php
  /**
   * Comments Form
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<h4><i class="warning chat icon"></i> <?php echo Lang::$word->_MOD_CM_REPLY;?></h4>
<p><em><small><?php echo Lang::$word->_MOD_CM_E_NOT_V;?></small></em></p>
<div class="wk secondary segment form">
  <form id="wk_form" name="wk_form" method="post">
    <div class="two fields">
      <div class="field">
        <label><?php echo Lang::$word->_MOD_CM_NAME;?></label>
        <label class="input"><i class="icon-append icon asterisk"></i>
          <input name="username" placeholder="<?php echo Lang::$word->_MOD_CM_NAME;?>" type="text" value="<?php if ($user->logged_in) echo $user->username;?>">
        </label>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_MOD_CM_EMAIL;?></label>
        <label class="input">
          <?php if(Registry::get("Comments")->email_req) echo '<i class="icon-append icon asterisk"></i>';?>
          <input name="email" placeholder="<?php echo Lang::$word->_MOD_CM_EMAIL;?>" type="text" value="<?php if ($user->logged_in) echo $user->email;?>">
        </label>
      </div>
    </div>
    <div class="two fields">
      <div class="field">
        <label><?php echo Lang::$word->_MOD_CM_WEB;?></label>
        <input name="www" placeholder="<?php echo Lang::$word->_MOD_CM_WEB;?>" type="text">
      </div>
      <div class="field">
        <?php if(Registry::get("Comments")->show_captcha):?>
        <label><?php echo Lang::$word->_MOD_CM_CAPTCHA_N;?></label>
        <label class="input"><img src="<?php echo SITEURL;?>/captcha.php" alt="" class="captcha-append" /> <i class="icon-prepend icon unhide"></i>
          <input type="text" name="captcha">
        </label>
        <?php endif;?>
      </div>
    </div>
    <div class="field">
      <label><?php echo Lang::$word->_MOD_CM_COMMENT;?></label>
      <label class="textarea"><i class="icon-append icon asterisk"></i>
        <textarea id="combody" placeholder="<?php echo Lang::$word->_MOD_CM_COMMENT;?>" name="body"></textarea>
      </label>
      <p class="wk note" id="counter"></p>
    </div>
    <div class="field">
      <button data-url="/modules/comments/controller.php" type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_MOD_CM_ADDCOMMENT;?></button>
    </div>
    <input name="page_id" type="hidden" value="<?php echo $row->id;?>">
    <input name="processComment" type="hidden" value="1">
  </form>
</div>
<div id="msgholder"></div>
