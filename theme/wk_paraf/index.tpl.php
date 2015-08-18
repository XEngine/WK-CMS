<?php
/**
* Index
*
* @package Webkokteyli CMS
* @author Webkokteyli Lab / http://www.webkokteyli.com
* @copyright 2015
* @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
*/

if (!defined("_VALID_PHP"))
die('Direct access to this location is not allowed.');
?>
<!doctype html>
<html class="no-js" lang="tr">
  <head>
    <?php echo $content->getMeta(); ?>
    <script type="text/javascript">var SITEURL = "<?php echo SITEURL; ?>";</script>
    <base href="<?php echo SITEURL; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">

    <!-- Font -->
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Arimo:400,700,400italic,700italic'>

    <link rel="stylesheet" href="<?php echo THEMEURL; ?>/assets/css/font-awesome.css">
    <link rel="stylesheet" href="<?php echo THEMEURL; ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo THEMEURL; ?>/assets/css/style.css">
    <script src="<?php echo THEMEURL; ?>/assets/js/jquery.min.js"></script>
    <script src="<?php echo THEMEURL; ?>/assets/js/bootstrap.min.js"></script>
    <?php $content->getPluginAssets($assets);?>
    <?php $content->getModuleAssets();?>
  </head>
  <body class="">
  <header class="header header-two">
    <?php include(TPLDIR. "header.tpl.php");?>
  </header>
<?php if ($widgettop): ?>
<!-- Top Widgets -->
<div id="topwidget">
  <?php include(TPLDIR . "/top_widget.tpl.php");?>
</div>
<!-- Top Widgets /-->
<?php endif;?>
<?php if(!$row->home_page):?>
<div class="subheader"<?php echo Content::getSubheaderBg();?>>
  <div class="wk-grid">
    <div class="wk-content">
      <?php if($content->slug and $core->showcrumbs):?>
      <div class="wk breadcrumb"><i class="icon home"></i> <a href="<?php echo SITEURL;?>/" class="section"><?php echo Lang::$word->_HOME;?></a>
        <div class="divider"></div>
        <div class="active section"><?php echo $content->getBreadcrumbs();?></div>
      </div>
      <?php endif;?>
      <h1><?php echo $row->{'title' . Lang::$lang};?>
        <?php if($row->{'caption' . Lang::$lang}):?>
        <small><?php echo $row->{'caption' . Lang::$lang};?></small>
        <?php endif;?>
      </h1>
    </div>
  </div>
</div>
<?php endif;?>
<?php switch(true): case $widgetleft and $widgetright :?>
<!-- Left and Right Layout -->
<div id="page">
  <div class="wk-grid">
    <div class="columns">
      <div class="screen-60 tablet-50 phone-100">
        <?php include(TPLDIR . "/main.tpl.php");?>
      </div>
      <div class="screen-20 tablet-25 phone-100">
        <?php include(TPLDIR . "/left_widget.tpl.php");?>
      </div>
      <div class="screen-20 tablet-25 phone-100">
        <?php include(TPLDIR . "/right_widget.tpl.php");?>
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
        <?php include(TPLDIR . "/left_widget.tpl.php");?>
      </div>
      <div class="screen-70 tablet-60 phone-100">
        <?php include(TPLDIR . "/main.tpl.php");?>
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
        <?php include(TPLDIR . "/main.tpl.php");?>
      </div>
      <div class="screen-30 tablet-40 phone-100">
        <?php include(TPLDIR . "/right_widget.tpl.php");?>
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
    <?php include(TPLDIR . "/full.tpl.php");?>
  </div>
</div>
<!-- Full Layout /-->
<?php break;?>
<?php endswitch;?>
<?php if ($widgetbottom): ?>
<!-- Bottom Widgets -->
<div id="botwidget">
  <div class="wk-grid">
    <?php include(TPLDIR . "/bottom_widget.tpl.php");?>
  </div>
</div>
<!-- Bottom Widgets /-->
<?php endif;?>
<?php include(TPLDIR . "footer.tpl.php");?>