<?php
  /**
   * Elastic Slider
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  if(!$user->getAcl("elastic")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
  
  Registry::set('Elastic', new Elastic());
?>
<?php switch(Filter::$paction): case "edit": ?>
<?php $row = Core::getRowById(Elastic::mTable, Filter::$id);?>
<div class="block-top-header">
<div class="wk icon heading message orange"> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PLG_ES_TITLE;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=elastic" class="section"><?php echo $content->getPluginName(Filter::$plugname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_PLG_ES_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PLG_ES_INFO2. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_PLG_ES_SUBTITLE2 . $row->{'title'.Lang::$lang};?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_ES_CAPTION;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->{'title'.Lang::$lang};?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_ES_DESC;?></label>
          <input type="text" value="<?php echo $row->{'body'.Lang::$lang};?>" name="body<?php echo Lang::$lang;?>">
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_ES_IMG_SEL;?></label>
          <label class="input">
            <input type="file" name="thumb" class="filefield">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_ES_IMGPR;?></label>
          <div class="wk normal image"> <a class="lightbox" href="<?php echo SITEURL . '/application/' . Elastic::imgPath . $row->thumb;?>"><img src="<?php echo SITEURL . '/application/' . Elastic::imgPath . $row->thumb;?>" alt="<?php echo $row->thumb;?>"></a> </div>
        </div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_PLG_ES_UPDATE;?></button>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=elastic" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="processSlide" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"add": ?>
<div class="block-top-header">
<div class="wk icon heading message orange"> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PLG_ES_TITLE;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=elastic" class="section"><?php echo $content->getPluginName(Filter::$plugname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_PLG_ES_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PLG_ES_INFO3. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_PLG_ES_SUBTITLE1;?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_ES_CAPTION;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_PLG_ES_CAPTION;?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_ES_DESC;?></label>
          <input type="text" placeholder="<?php echo Lang::$word->_PLG_ES_DESC;?>" name="body<?php echo Lang::$lang;?>">
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_ES_IMG_SEL;?></label>
          <label class="input">
            <input type="file" name="thumb" class="filefield">
          </label>
        </div>
        <div class="field"></div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_PLG_ES_ADDSLIDE;?></button>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=elastic" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processSlide" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"config": ?>
<?php $row = Registry::get("Elastic");?>
<div class="wk icon heading message orange"> <a class="helper wk top right info corner label" data-help="elastic"><i class="icon help"></i></a> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PLG_ES_TITLE;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=elastic" class="section"><?php echo $content->getPluginName(Filter::$plugname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_PLG_ES_CONF;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PLG_ES_INFO4. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_PLG_ES_SUBTITLE4;?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_ES_ANITYPE;?></label>
          <select name="animation">
            <option value="center"<?php if($row->animation == 'center') echo ' selected="selected"';?>><?php echo Lang::$word->_PLG_ES_ANITYPE_C;?></option>
            <option value="sides"<?php if($row->animation == 'sides') echo ' selected="selected"';?>><?php echo Lang::$word->_PLG_ES_ANITYPE_S;?></option>
          </select>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_ES_HEIGHT;?></label>
          <label class="input">
            <input type="text" value="<?php echo $row->height;?>" name="height">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_ES_AUTOPLAY;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="autoplay" type="radio" value="1" <?php getChecked($row->autoplay, 1); ?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="autoplay" type="radio" value="0" <?php getChecked($row->autoplay, 0); ?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_ES_INTERVAL;?></label>
          <label class="input">
            <input type="text" class="slrange" value="<?php echo $row->interval;?>" name="interval">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_ES_SPEED;?></label>
          <label class="input">
            <input type="text" class="slrange" value="<?php echo $row->speed;?>" name="speed">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_ES_TITLESPEED;?></label>
          <label class="input">
            <input type="text" class="slrange" value="<?php echo $row->titlespeed;?>" name="titlespeed">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_ES_THUMB;?></label>
          <label class="input">
            <input type="text" class="slrange" value="<?php echo $row->thumbMaxWidth;?>" name="thumbMaxWidth">
          </label>
        </div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_PLG_ES_BUT_CONF_U;?></button>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=elastic" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processConfig" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    $("input[name=interval]").ionRangeSlider({
		min: 1000,
		max: 5000,
        step: 500,
		postfix: " ms",
        type: 'single',
        hasGrid: true
    });
	
    $("input[name=speed], input[name=titlespeed]").ionRangeSlider({
		min: 100,
		max: 2000,
        step: 200,
		postfix: " ms",
        type: 'single',
        hasGrid: true
    });

    $("input[name=thumbMaxWidth]").ionRangeSlider({
		min: 100,
		max: 300,
        step: 20,
		postfix: " px",
        type: 'single',
        hasGrid: true
    });
});
// ]]>
</script>
<?php break;?>
<?php default: ?>
<?php $sliderows = Registry::get("Elastic")->getSlides();?>
<div class="wk icon heading message orange"> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PLG_ES_TITLE;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo $content->getPluginName(Filter::$plugname);?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PLG_ES_INFO3;?></div>
  <div class="wk segment">
    <div class="wk buttons push-right"><a href="<?php echo Core::url("plugins", "add");?>" class="wk info button"><i class="icon add"></i><?php echo Lang::$word->_PLG_ES_ADDSLIDE;?></a> <a href="<?php echo Core::url("plugins", "config");?>" class="wk warning button"><i class="icon setting"></i><?php echo Lang::$word->_PLG_ES_CONF;?></a></div>
    <div class="wk header"><?php echo Lang::$word->_PLG_ES_SUBTITLE3;?></div>
    <table class="wk sortable table">
      <thead>
        <tr>
          <th class="disabled"></th>
          <th data-sort="string"><?php echo Lang::$word->_PLG_ES_CAPTION;?></th>
          <th data-sort="int"><?php echo Lang::$word->_PLG_ES_POS;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$sliderows):?>
        <tr>
          <td colspan="4"><?php echo Filter::msgSingleAlert(Lang::$word->_PLG_ES_NOIMG);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($sliderows as $row):?>
        <tr id="node-<?php echo $row->id;?>">
          <td class="id-handle"><i class="icon reorder"></i></td>
          <td><?php echo $row->{'title'.Lang::$lang};?></td>
          <td><span class="wk black label"><?php echo $row->position;?></span></td>
          <td><a href="<?php echo Core::url("plugins", "edit", $row->id);?>"><i class="rounded inverted success icon pencil link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_PLG_ES_SLIDE;?>" data-option="deleteSlide" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title'.Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a></td>
        </tr>
        <?php endforeach;?>
        <?php unset($slrow);?>
        <?php endif;?>
      </tbody>
    </table>
  </div>
</div>
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    $(".wk.table tbody").sortable({
        helper: 'clone',
        handle: '.id-handle',
        placeholder: 'placeholder',
        opacity: .6,
        update: function (event, ui) {
            serialized = $(".wk.table tbody").sortable('serialize');
            $.ajax({
                type: "POST",
                url: "plugins/elastic/controller.php?sortslides",
                data: serialized,
                success: function (msg) {}
            });
        }
    });
});
// ]]>
</script>
<?php break;?>
<?php endswitch;?>
