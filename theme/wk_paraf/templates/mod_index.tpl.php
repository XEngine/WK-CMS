<?php
  /**
   * Module Index
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php include("header.tpl.php");?>
<?php if ($widgettop): ?>
<!-- Top Widgets -->
<div id="topwidget">
  <?php include(THEMEDIR . "/top_widget.tpl.php");?>
</div>
<!-- Top Widgets /-->
<?php endif;?>
<div class="subheader">
  <div class="wk-grid">
    <div class="wk-content">
      <?php if($content->modalias and $core->showcrumbs):?>
      <div class="wk breadcrumb"><i class="icon home"></i> <a href="<?php echo SITEURL;?>/" class="section"><?php echo Lang::$word->_HOME;?></a>
        <span class="divider"></span>
        <?php echo $content->getBreadcrumbs();?>
      </div>
      <?php endif;?>
      <h1><?php echo $content->moduledata->{'title' . Lang::$lang};?>
        <?php if($content->moduledata->{'info' . Lang::$lang}):?>
        <small><?php echo $content->moduledata->{'info' . Lang::$lang};?></small>
        <?php endif;?>
      </h1>
    </div>
  </div>
</div>
<?php switch(true): case $widgetleft and $widgetright :?>
<!-- Left and Right Layout -->
<div id="page">
  <div class="wk-grid">
    <div class="columns">
      <div class="screen-60 tablet-50 phone-100">
        <?php include(THEMEDIR . "/mod_main.tpl.php");?>
      </div>
      <div class="screen-20 tablet-25 phone-100">
        <?php include(THEMEDIR . "/left_widget.tpl.php");?>
      </div>
      <div class="screen-20 tablet-25 phone-100">
        <?php include(THEMEDIR . "/right_widget.tpl.php");?>
      </div>
    </div>
  </div>
</div>
<!-- Left and Right Layout /-->
<?php break;?>
<?php case $widgetleft :?>
<!-- Left Layout -->
<div id="page">
  <div class="wk-grid">
    <div class="columns">
      <div class="screen-30 tablet-40 phone-100">
        <?php include(THEMEDIR . "/left_widget.tpl.php");?>
      </div>
      <div class="screen-70 tablet-60 phone-100">
        <?php include(THEMEDIR . "/mod_main.tpl.php");?>
      </div>
    </div>
  </div>
</div>
<!-- Left Layout /-->
<?php break;?>
<?php case $widgetright :?>
<!-- Right Layout -->
<div id="page">
  <div class="wk-grid">
    <div class="columns">
      <div class="screen-70 tablet-60 phone-100">
        <?php include(THEMEDIR . "/mod_main.tpl.php");?>
      </div>
      <div class="screen-30 tablet-40 phone-100">
        <?php include(THEMEDIR . "/right_widget.tpl.php");?>
      </div>
    </div>
  </div>
</div>
<!-- Right Layout /-->
<?php break;?>
<?php default:?>
<!-- Full Layout -->
<div id="page">
  <div class="wk-grid">
    <?php include(THEMEDIR . "/mod_main.tpl.php");?>
  </div>
</div>
<!-- Full Layout /-->
<?php break;?>
<?php endswitch;?>
<?php if ($widgetbottom): ?>
<!-- Bottom Widgets -->
<div id="botwidget">
  <div class="wk-grid">
    <?php include(THEMEDIR . "/bottom_widget.tpl.php");?>
  </div>
</div>
<!-- Bottom Widgets /-->
<?php endif;?>
<?php include("footer.tpl.php");?>