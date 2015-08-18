<?php
  /**
   * Content Slider
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  if(!$user->getAcl("contentslider")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
  
  Registry::set('csSlider', new csSlider());
?>
<?php switch(Filter::$paction): case "edit": ?>
<?php $row = Core::getRowById(csSlider::mTable, Filter::$id);?>
<div class="wk icon heading message orange"> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PLG_CS_TITLE;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=contentslider" class="section"><?php echo $content->getPluginName(Filter::$plugname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_PLG_CS_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PLG_CS_INFO2. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_PLG_CS_SUBTITLE2 . $row->{'title'.Lang::$lang};?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="field">
        <label><?php echo Lang::$word->_PLG_CS_CAPTION;?></label>
        <label class="input"><i class="icon-append icon asterisk"></i>
          <input type="text" value="<?php echo $row->{'title'.Lang::$lang};?>" name="title<?php echo Lang::$lang;?>">
        </label>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_PLG_CS_DESC;?></label>
        <textarea id="plugpost" class="plugpost" name="body<?php echo Lang::$lang;?>"><?php echo Filter::out_url($row->{'body'.Lang::$lang});?></textarea>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_PLG_CS_UPDATE;?></button>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=contentslider" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="processSlide" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"add": ?>
<div class="wk icon heading message orange"> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PLG_CS_TITLE;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=contentslider" class="section"><?php echo $content->getPluginName(Filter::$plugname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_PLG_CS_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PLG_CS_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_PLG_CS_SUBTITLE1;?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="field">
        <label><?php echo Lang::$word->_PLG_CS_CAPTION;?></label>
        <label class="input"><i class="icon-append icon asterisk"></i>
          <input type="text" placeholder="<?php echo Lang::$word->_PLG_CS_CAPTION;?>" name="title<?php echo Lang::$lang;?>">
        </label>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_PLG_CS_DESC;?></label>
        <textarea id="plugpost" class="plugpost" placeholder="<?php echo Lang::$word->_PLG_CS_DESC;?>" name="body<?php echo Lang::$lang;?>"></textarea>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_PLG_CS_TITLE1;?></button>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=contentslider" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processSlide" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php default: ?>
<?php $sliderows = Registry::get("csSlider")->getSlides();?>
<div class="wk icon heading message orange"> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PLG_CS_TITLE;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo $content->getPluginName(Filter::$plugname);?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PLG_CS_INFO3;?></div>
  <div class="wk segment"> <a href="index.php?do=plugins&amp;action=config&amp;plugname=contentslider&amp;paction=add" class="wk info button push-right"><i class="icon add"></i><?php echo Lang::$word->_PLG_CS_ADDSLIDE;?></a>
    <div class="wk header"><?php echo Lang::$word->_PLG_CS_SUBTITLE3;?></div>
    <div class="wk fitted divider"></div>
    <table class="wk sortable table">
      <thead>
        <tr>
          <th class="disabled"></th>
          <th data-sort="string"><?php echo Lang::$word->_PLG_CS_CAPTION;?></th>
          <th data-sort="int"><?php echo Lang::$word->_PLG_CS_POS;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$sliderows):?>
        <tr>
          <td colspan="4"><?php echo Filter::msgSingleAlert(Lang::$word->_PLG_CS_NOIMG);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($sliderows as $row):?>
        <tr id="node-<?php echo $row->id;?>">
          <td class="id-handle"><i class="icon reorder"></i></td>
          <td><?php echo $row->{'title'.Lang::$lang};?></td>
          <td><span class="wk black label"><?php echo $row->position;?></span></td>
          <td><a href="index.php?do=plugins&amp;action=config&amp;plugname=contentslider&amp;paction=edit&amp;id=<?php echo $row->id;?>"><i class="rounded inverted success icon pencil link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_PLG_CS_SLIDE;?>" data-option="deleteSlide" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title'.Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a></td>
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
                url: "plugins/contentslider/controller.php?sortslides",
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
