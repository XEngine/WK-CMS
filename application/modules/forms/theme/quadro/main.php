<?php
  /**
   * Visual Forms
   *
   * @package wk:cms
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  require_once(MODPATH . "forms/admin_class.php");
  Registry::set('Forms',new Forms());
?>
<?php $conf = Registry::get("Core")->getRowById(Forms::mTable, $content->module_data);?>
<?php if($conf):?>
<div class="wk secondary form segment">
  <h3><?php echo $conf->{'title' . Lang::$lang};?></h3>
  <form id="wk_form" name="wk_form" method="post">
    <?php print cleanOut($conf->{'html' . Lang::$lang});?>
    <input name="id" type="hidden" value="<?php echo $conf->id;?>" />
    <?php if($conf->captcha):?>
    <div class="field">
      <label class="label"><?php echo Lang::$word->_MOD_VF_CAPTCHA;?></label>
      <div class="inline-group">
        <label class="input"> <img src="<?php echo SITEURL;?>/captcha.php" alt="" class="captcha-append" /> <i class="icon-prepend icon unhide"></i>
          <input name="captcha" placeholder="Captcha" type="text">
        </label>
      </div>
    </div>
    <input name="has_captcha" type="hidden" value="1" />
    <?php endif;?>
    <div class="wk thin attached divider"></div>
    <button data-url="/modules/forms/controller.php" name="dosubmit" type="button" class="wk positive button"><?php echo $conf->{'sbutton' . Lang::$lang};?></button>
    <input name="processForm" type="hidden" value="1">
  </form>
</div>
<div id="msgholder"></div>
<?php endif;?>