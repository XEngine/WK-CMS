<?php
  /**
   * Header
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2010
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
	 $totalEvents =  $core->countEvents();
	 $langlist = $core->langList();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $core->company;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet" type="text/css">
<link href="<?php echo THEMEU . '/cache/' . Minify::cache(array('css/base.css','css/button.css','css/image.css','css/icon.css','css/breadcrumb.css','css/popup.css','css/form.css','css/input.css','css/table.css','css/label.css','css/segment.css','css/message.css','css/divider.css','css/dropdown.css','css/list.css','css/progress.css','css/header.css','css/menu.css','css/datepicker.css','css/editor.css','css/utility.css','css/style.css'),'css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="globalAssets/jquery.js"></script>
<script type="text/javascript" src="globalAssets/jquery-ui.js"></script>
<script src="globalAssets/modernizr.mq.js"></script>
<script type="text/javascript" src="globalAssets/global.js"></script>
<?php if($core->editor == 2):?>
<script src="assets/tinymce/tinymce.min.js" type="text/javascript"></script>
<script src="assets/tinymce/jquery.tinymce.min.js" type="text/javascript"></script>
<?php else:?>
<script type="text/javascript" src="assets/js/editor.js"></script>
<?php endif;?>
<script src="globalAssets/jquery.ui.touch-punch.js"></script>
<script type="text/javascript" src="assets/js/master.js"></script>
<?php
  if (file_exists("plugins/" . Filter::$plugname . "/style.css"))
      echo "<link href=\"plugins/" . Filter::$plugname . "/style.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
  if (file_exists("modules/" . Filter::$modname . "/style.css"))
      echo "<link href=\"modules/" . Filter::$modname . "/style.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
?>
</head>
<body>
<div id="helpbar" class="wk wide floating info right sidebar"></div>
<!-- Header -->
<header id="header" class="clearfix">
  <div class="actbuttons">
    <div class="wk large icon buttons"> <a href="../index.php" data-placement="left" data-content="<?php echo Lang::$word->_N_VIEWS;?>" class="wk warning button"><i class="home icon"></i></a>
      <?php if($user->getAcl("events")):?>
      <a href="index.php?do=modules&amp;action=config&amp;mod=events" data-placement="left" data-content="<?php echo $totalEvents . ' ' . Lang::$word->_N_EVENTS;?>" class="wk positive button"><i class="icon calendar"></i></a>
      <?php endif;?>
      <a href="logout.php" data-placement="left" data-content="<?php echo Lang::$word->_N_LOGOUT;?>" class="wk info button"><i class="icon sign out"></i></a> </div>
  </div>
  <div class="usermenu">
    <ul>
      <li class="welavatar">
      <a href="index.php?do=users&amp;action=edit&amp;id=<?php echo $user->uid;?>">
        <?php if($user->avatar):?>
        <img src="<?php echo UPLOADURL;?>avatars/<?php echo $user->avatar;?>" alt="<?php echo $user->username;?>" class="wk image avatar"/>
        <?php else:?>
        <img src="<?php echo UPLOADURL;?>avatars/blank.png" alt="<?php echo $user->username;?>" class="wk image avatar"/>
        <?php endif;?>
        </a>
      </li>
      <li class="welcome"> <?php echo Lang::$word->_WELCOME.' '.$user->username;?>!<br>
        <?php echo Lang::$word->_UR_LASTLOGIN;?>: <?php echo Filter::doDate("short_date", $user->last);?> </li>
      <li class="langmenu">
        <div class="wk basic buttons">
          <div class="wk button"><?php echo Lang::$word->_LANGUAGE;?></div>
          <div class="wk floating top right pointing dropdown icon button"> <i class="dropdown icon"></i>
            <div class="menu langswitch">
              <?php foreach($langlist as $lang):?>
              <a href="index.php?<?php echo $_SERVER['QUERY_STRING'];?>" data-lang="<?php echo $lang->flag;?>" class="item"><i class="chat icon"></i><?php echo $lang->name;?></a>
              <?php endforeach;?>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
</header>
<!-- Header /--> 