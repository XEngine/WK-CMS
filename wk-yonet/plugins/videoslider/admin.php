<?php
  /**
   * jQuery Slider
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  if(!$user->getAcl("videoslider")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
  
  Registry::set('vSlider', new vSlider());
?>
<?php switch(Filter::$paction): case "edit": ?>
<?php $row = Core::getRowById(vSlider::mTable, Filter::$id);?>
<div class="wk icon heading message orange"> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PLG_VS_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=videoslider" class="section"><?php echo $content->getPluginName(Filter::$plugname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_PLG_VS_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PLG_VS_INFO2. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_PLG_VS_SUBTITLE2 . $row->{'title'.Lang::$lang};?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_VS_CAPTION;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->{'title'.Lang::$lang};?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_VS_URL;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->vidurl;?>" name="vidurl">
          </label>
          <p class="wk info note"><?php echo Lang::$word->_PLG_VS_URL_T;?></p>
        </div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_PLG_CS_UPDATE;?></button>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=videoslider" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
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
    <div class="header"> <?php echo Lang::$word->_PLG_VS_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=videoslider" class="section"><?php echo $content->getPluginName(Filter::$plugname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_PLG_VS_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PLG_VS_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_PLG_VS_SUBTITLE1;?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_VS_CAPTION;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_PLG_VS_CAPTION;?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_VS_URL;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_PLG_VS_URL;?>" name="vidurl">
          </label>
          <p class="wk info note"><?php echo Lang::$word->_PLG_VS_URL_T;?></p>
        </div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_PLG_VS_ADD;?></button>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=videoslider" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processSlide" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"config": ?>
<?php $row = Registry::get("vSlider");?>
<div class="wk icon heading message orange"> <a class="helper wk top right info corner label" data-help="vslider"><i class="icon help"></i></a> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PLG_VS_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=videoslider" class="section"><?php echo $content->getPluginName(Filter::$plugname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_PLG_VS_CONF;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PLG_VS_INFO4. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_PLG_VS_SUBTITLE4;?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_VS_THEME;?></label>
          <select name="theme">
            <option value="dark"<?php if($row->theme == 'dark') echo ' selected="selected"';?>><?php echo Lang::$word->_PLG_VS_DARK;?></option>
            <option value="light"<?php if($row->theme == 'light') echo ' selected="selected"';?>><?php echo Lang::$word->_PLG_VS_LIGHT;?></option>
          </select>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_VS_YCOLOR;?></label>
          <select name="ycolor">
            <option value="white"<?php if($row->ycolor == 'white') echo ' selected="selected"';?>><?php echo Lang::$word->_PLG_VS_WHITE;?></option>
            <option value="red"<?php if($row->ycolor == 'red') echo ' selected="selected"';?>><?php echo Lang::$word->_PLG_VS_RED;?></option>
          </select>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_VS_VQ;?></label>
          <select name="vq">
            <option value="small"<?php if($row->vq == 'small') echo ' selected="selected"';?>>240p</option>
            <option value="medium"<?php if($row->vq == 'medium') echo ' selected="selected"';?>>360p</option>
            <option value="large"<?php if($row->vq == 'large') echo ' selected="selected"';?>>480p</option>
            <option value="hd720"<?php if($row->vq == 'hd720') echo ' selected="selected"';?>>720p</option>
            <option value="hd1080"<?php if($row->vq == 'hd1080') echo ' selected="selected"';?>>1080p</option>
          </select>
        </div>
      </div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_VS_HIDE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="autohide" type="radio" value="1" <?php getChecked($row->autohide, 1); ?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="autohide" type="radio" value="0" <?php getChecked($row->autohide, 0); ?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_VS_SHOWINFO;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="rel" type="radio" value="1" <?php getChecked($row->rel, 1); ?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="rel" type="radio" value="0" <?php getChecked($row->rel, 0); ?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_VS_REL;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="showinfo" type="radio" value="1" <?php getChecked($row->showinfo, 1); ?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="showinfo" type="radio" value="0" <?php getChecked($row->showinfo, 0); ?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="wk divider"></div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_VS_VTITLE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="title" type="radio" value="1" <?php getChecked($row->title, 1); ?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="title" type="radio" value="0" <?php getChecked($row->title, 0); ?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_VS_BYLINE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="byline" type="radio" value="1" <?php getChecked($row->byline, 1); ?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="byline" type="radio" value="0" <?php getChecked($row->byline, 0); ?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_VS_PORT;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="portrait" type="radio" value="1" <?php getChecked($row->portrait, 1); ?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="portrait" type="radio" value="0" <?php getChecked($row->portrait, 0); ?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_VS_VCOLOR;?></label>
          <label class="input">
            <input type="text" data-color-format="hex" value="#<?php echo $row->vcolor;?>" name="vcolor">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_VS_AUTOPLAY;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="autoPlay" type="radio" value="1" <?php getChecked($row->autoPlay, 1); ?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="autoPlay" type="radio" value="0" <?php getChecked($row->autoPlay, 0); ?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_VS_FULLSCR;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="allowFullScreen" type="radio" value="1" <?php getChecked($row->allowFullScreen, 1); ?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="allowFullScreen" type="radio" value="0" <?php getChecked($row->allowFullScreen, 0); ?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_PLG_VS_CONF_U;?></button>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=videoslider" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processConfig" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<script type="text/javascript">
$(document).ready(function () {
    $('input[name=vcolor]').ColorPickerSliders({
        previewontriggerelement: true,
        flat: false,
        customswatches: false,
        swatches: ['#F0B174', '#79C0D8', '#3CC9CA', '#B2D280', '#FB4434', '#fff'],
        order: {
            rgb: 1,
            preview: 2
        }
    });
});
</script>
<?php break;?>
<?php default: ?>
<?php $sliderows = Registry::get("vSlider")->getSlides();?>
<div class="wk icon heading message orange"> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PLG_VS_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo $content->getPluginName(Filter::$plugname);?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PLG_VS_INFO3;?></div>
  <div class="wk segment">
    <div class="wk buttons push-right"><a href="index.php?do=plugins&amp;action=config&amp;plugname=videoslider&amp;paction=add" class="wk info button"><i class="icon add"></i><?php echo Lang::$word->_PLG_VS_ADD;?></a> <a href="index.php?do=plugins&amp;action=config&amp;plugname=videoslider&amp;paction=config" class="wk warning button"><i class="icon setting"></i><?php echo Lang::$word->_PLG_VS_CONF;?></a></div>
    <div class="wk header"><?php echo Lang::$word->_PLG_VS_SUBTITLE3;?></div>
    <div class="wk fitted divider"></div>
    <table class="wk sortable table">
      <thead>
        <tr>
          <th class="disabled"></th>
          <th data-sort="string"><?php echo Lang::$word->_PLG_VS_CAPTION;?></th>
          <th data-sort="int"><?php echo Lang::$word->_PLG_VS_POS;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$sliderows):?>
        <tr>
          <td colspan="4"><?php echo Filter::msgSingleAlert(Lang::$word->_PLG_VS_NOIMG);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($sliderows as $row):?>
        <tr id="node-<?php echo $row->id;?>">
          <td class="id-handle"><i class="icon reorder"></i></td>
          <td><?php echo $row->{'title'.Lang::$lang};?></td>
          <td><span class="wk black label"><?php echo $row->position;?></span></td>
          <td><a href="index.php?do=plugins&amp;action=config&amp;plugname=videoslider&amp;paction=edit&amp;id=<?php echo $row->id;?>"><i class="rounded inverted success icon pencil link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_PLG_VS_SLIDE;?>" data-option="deleteSlide" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title'.Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a></td>
        </tr>
        <?php endforeach;?>
        <?php unset($row);?>
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
                url: "plugins/videoslider/controller.php?sortslides",
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