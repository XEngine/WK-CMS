<?php
  /**
   * Rss
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  if(!$user->getAcl("rss")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
  
  Registry::set('rss', new rss());
  $row = Registry::get("rss");
?>
<div class="wk icon heading message orange"> <a class="helper wk top right info corner label" data-help="rss"><i class="icon help"></i></a> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PLG_RSS_TITLE1;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo $content->getPluginName(Filter::$plugname);?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PLG_RSS_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_PLG_RSS_SUBTITLE1;?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_RSS_URL;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->url;?>" name="url">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_RSS_TITLETRIM;?></label>
          <label class="input">
            <input class="slrange" type="text" value="<?php echo $row->title_trim;?>" name="title_trim">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_RSS_DATEFORMAT;?></label>
          <select name="dateformat">
            <?php echo rss::getDateFormat($row->dateformat);?>
          </select>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_RSS_BODYTRIM;?></label>
          <label class="input">
            <input class="slrange" type="text" value="<?php echo $row->body_trim;?>" name="body_trim">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <div class="two fields">
            <div class="field">
              <label><?php echo Lang::$word->_PLG_RSS_SHOW_BODY;?></label>
              <div class="inline-group">
                <label class="radio">
                  <input name="show_body" type="radio" value="1" <?php getChecked($row->show_body, 1); ?>>
                  <i></i><?php echo Lang::$word->_YES;?></label>
                <label class="radio">
                  <input name="show_body" type="radio" value="0" <?php getChecked($row->show_body, 0); ?>>
                  <i></i><?php echo Lang::$word->_NO;?></label>
              </div>
            </div>
            <div class="field">
              <label><?php echo Lang::$word->_PLG_RSS_SHOW_DATE;?></label>
              <div class="inline-group">
                <label class="radio">
                  <input name="show_date" type="radio" value="1" <?php getChecked($row->show_date, 1); ?>>
                  <i></i><?php echo Lang::$word->_YES;?></label>
                <label class="radio">
                  <input name="show_date" type="radio" value="0" <?php getChecked($row->show_date, 0); ?>>
                  <i></i><?php echo Lang::$word->_NO;?></label>
              </div>
            </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_RSS_ITEMS;?></label>
          <label class="input">
            <input class="slrange" type="text" value="<?php echo $row->perpage;?>" name="perpage">
          </label>
        </div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_PLG_RSS_UPDATE;?></button>
      <a href="index.php?do=plugins" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processConfig" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    $("input[name=title_trim]").ionRangeSlider({
		min: 0,
		max: 50,
        step: 2,
		postfix: " ch",
        type: 'single',
        hasGrid: true
    });
	
    $("input[name=body_trim]").ionRangeSlider({
		min: 0,
		max: 200,
        step: 5,
		postfix: " ch",
        type: 'single',
        hasGrid: true
    });

    $("input[name=perpage]").ionRangeSlider({
		min: 5,
		max: 20,
        step: 1,
		postfix: " pp",
        type: 'single',
        hasGrid: true
    });
});
// ]]>
</script>