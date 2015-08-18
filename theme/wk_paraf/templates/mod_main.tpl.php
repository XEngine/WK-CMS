<?php
  /**
   * Full Module Page Layout
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
  <?php if($content->moduledata and $modfile = Content::getModuleTheme($content->modalias)) :?>
  <?php require($modfile); ?>
  <?php endif;?>
</div>