<?php
  /**
   * Right Sidebar Layout
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>

<div class="wk-content-full clearfix">
  <?php if($content->getAccess()):?>
  <?php echo Content::getContentPlugins($row->{'body' . Lang::$lang});?>
  <?php if ($page = Content::getAccesPages($row)):?>
  <?php include($page);?>
  <?php endif;?>
  <?php if($row->module_name and $modfile = Content::getModuleTheme($row->module_name)) :?>
  <?php require($modfile); ?>
  <?php endif;?>
  <?php if ($content->jscode) echo cleanOut($content->jscode);?>
  <?php endif;?>
</div>