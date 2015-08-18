<?php
  /**
   * Configuration
   *
   * @package wk:cms
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
   
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  require_once("admin_class.php");
  Registry::set('Forms',new Forms());
  $formrows = Registry::get("Forms")->getForms();
?>
<label><?php echo Lang::$word->_MOD_VF_CATTFORM;?></label>
<select name="module_data">
  <option value="0"><?php echo Lang::$word->_MOD_VF_CSELFORM;?></option>
  <?php if($formrows):?>
  <?php foreach($formrows as $fmrow):?>
  <?php $sel = ($fmrow->id == $module_data) ? ' selected="selected"' : '' ;?>
  <option value="<?php echo $fmrow->id;?>"<?php echo $sel;?>><?php echo $fmrow->{'title'.Lang::$lang};?></option>
  <?php endforeach;?>
  <?php unset($grow);?>
  <?php endif;?>
</select>