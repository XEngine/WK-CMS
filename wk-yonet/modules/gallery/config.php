<?php
  /**
   * Configuration
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  require_once("admin_class.php");
  Registry::set('Gallery', new Gallery());
  $gal = Registry::get("Gallery");
  $galrow = $gal->getGalleries();
?>
<label><?php echo Lang::$word->_PG_GAL;?></label>
<select name="module_data">
  <option value="0"><?php echo Lang::$word->_PG_GAL_SEL;?></option>
  <?php if($galrow):?>
  <?php foreach($galrow as $grow):?>
  <?php $sel = ($grow->id == $module_data) ? ' selected="selected"' : '' ;?>
  <option value="<?php echo $grow->id;?>"<?php echo $sel;?>><?php echo $grow->{'title'.Lang::$lang};?></option>
  <?php endforeach;?>
  <?php unset($grow);?>
  <?php endif;?>
</select>