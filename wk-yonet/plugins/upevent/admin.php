<?php
  /**
   * latestTwitts
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  if(!$user->getAcl("upevent")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
  
  Registry::set('upEvent', new upEvent());
  
  require_once(BASEPATH . "/admin/modules/events/admin_class.php");
  Registry::set('eventManager', new eventManager());
  $eventrow = Registry::get("eventManager")->getEvents();
?>
<div class="wk icon heading message orange"> <a class="helper wk top right info corner label" data-help="upevent"><i class="icon help"></i></a> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PLG_UE_TITLE1;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo $content->getPluginName(Filter::$plugname);?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PLG_UE_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_PLG_UE_SUBTITLE1;?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <select name="event_id" >
            <?php if($eventrow):?>
            <?php foreach($eventrow as $row):?>
            <?php $sel = (Registry::get("upEvent")->event_id == $row->id) ? ' selected="selected"' : '';?>
            <option value="<?php echo $row->id;?>"<?php echo $sel;?>><?php echo $row->{'title'.Lang::$lang};?></option>
            <?php endforeach;?>
            <?php else:?>
            <option value=""><?php echo Lang::$word->_PLG_UE_NOEVENT;?></option>
            <?php endif;?>
          </select>
        </div>
        <div class="field">&nbsp;</div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_PLG_UE_UPDATE;?></button>
      <a href="index.php?do=plugins" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processConfig" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>