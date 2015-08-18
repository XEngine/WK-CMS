<?php
  /**
   * News Slider
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2010
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  if(!$user->getAcl("newsslider")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
  
  require_once("admin_class.php");
  Registry::set('newsSlider', new newsSlider());
?>
<?php switch(Filter::$paction): case "edit": ?>
<?php $row = Core::getRowById(newsSlider::mTable, Filter::$id);?>
<div class="wk icon heading message orange"> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PLG_NS_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=newsslider" class="section"><?php echo $content->getPluginName(Filter::$plugname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_PLG_NS_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PLG_NS_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_PLG_NS_SUBTITLE1 . $row->{'title'.Lang::$lang};?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_NS_TITLE;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->{'title'.Lang::$lang};?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <div class="three fields">
            <div class="field">
              <label><?php echo Lang::$word->_PLG_NS_PUB;?></label>
              <div class="inline-group">
                <label class="radio">
                  <input name="active" type="radio" value="1" <?php getChecked($row->active, 1); ?>>
                  <i></i><?php echo Lang::$word->_YES;?></label>
                <label class="radio">
                  <input name="active" type="radio" value="0" <?php getChecked($row->active, 0); ?>>
                  <i></i><?php echo Lang::$word->_NO;?></label>
              </div>
            </div>
            <div class="field">
              <label><?php echo Lang::$word->_PLG_NS_S_DATE;?></label>
              <div class="inline-group">
                <label class="radio">
                  <input name="show_created" type="radio" value="1" <?php getChecked($row->show_created, 1); ?>>
                  <i></i><?php echo Lang::$word->_YES;?></label>
                <label class="radio">
                  <input name="show_created" type="radio" value="0" <?php getChecked($row->show_created, 0); ?>>
                  <i></i><?php echo Lang::$word->_NO;?></label>
              </div>
            </div>
            <div class="field">
              <label><?php echo Lang::$word->_PLG_NS_S_TITLE;?></label>
              <div class="inline-group">
                <label class="radio">
                  <input name="show_title" type="radio" value="1" <?php getChecked($row->show_title, 1); ?>>
                  <i></i><?php echo Lang::$word->_YES;?></label>
                <label class="radio">
                  <input name="show_title" type="radio" value="0" <?php getChecked($row->show_title, 0); ?>>
                  <i></i><?php echo Lang::$word->_NO;?></label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="wk divider"></div>
      <div class="field">
        <label><?php echo Lang::$word->_PLG_NS_BODY;?></label>
        <textarea id="plugpost" class="plugpost" name="body<?php echo Lang::$lang;?>"><?php echo Filter::out_url($row->{'body'.Lang::$lang});?></textarea>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_PLG_NS_UPDATE;?></button>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=newsslider" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="processNews" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"add": ?>
<div class="wk icon heading message orange"> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PLG_NS_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=newsslider" class="section"><?php echo $content->getPluginName(Filter::$plugname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_PLG_NS_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PLG_NS_INFO2. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_PLG_NS_SUBTITLE2;?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_NS_TITLE;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_PLG_NS_TITLE;?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <div class="three fields">
            <div class="field">
              <label><?php echo Lang::$word->_PLG_NS_PUB;?></label>
              <div class="inline-group">
                <label class="radio">
                  <input name="active" type="radio" value="1" checked="checked">
                  <i></i><?php echo Lang::$word->_YES;?></label>
                <label class="radio">
                  <input name="active" type="radio" value="0">
                  <i></i><?php echo Lang::$word->_NO;?></label>
              </div>
            </div>
            <div class="field">
              <label><?php echo Lang::$word->_PLG_NS_S_DATE;?></label>
              <div class="inline-group">
                <label class="radio">
                  <input name="show_created" type="radio" value="1"checked="checked">
                  <i></i><?php echo Lang::$word->_YES;?></label>
                <label class="radio">
                  <input name="show_created" type="radio" value="0" >
                  <i></i><?php echo Lang::$word->_NO;?></label>
              </div>
            </div>
            <div class="field">
              <label><?php echo Lang::$word->_PLG_NS_S_TITLE;?></label>
              <div class="inline-group">
                <label class="radio">
                  <input name="show_title" type="radio" value="1"checked="checked">
                  <i></i><?php echo Lang::$word->_YES;?></label>
                <label class="radio">
                  <input name="show_title" type="radio" value="0">
                  <i></i><?php echo Lang::$word->_NO;?></label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="wk divider"></div>
      <div class="field">
        <label><?php echo Lang::$word->_PLG_NS_BODY;?></label>
        <textarea id="plugpost" class="plugpost" placeholder="<?php echo Lang::$word->_PLG_NS_BODY;?>" name="body<?php echo Lang::$lang;?>"></textarea>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_PLG_NS_ADD;?></button>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=newsslider" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processNews" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php default: ?>
<?php $newsrow = Registry::get("newsSlider")->getNewsItems();?>
<div class="wk icon heading message orange"> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PLG_NS_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo $content->getPluginName(Filter::$plugname);?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PLG_NS_INFO3;?></div>
  <div class="wk segment"> <a href="index.php?do=plugins&amp;action=config&amp;plugname=newsslider&amp;paction=add" class="wk info button push-right"><i class="icon add"></i><?php echo Lang::$word->_PLG_NS_ADD;?></a>
    <div class="wk header"><?php echo Lang::$word->_PLG_NS_SUBTITLE3;?></div>
    <div class="wk fitted divider"></div>
    <table class="wk sortable table">
      <thead>
        <tr>
          <th class="disabled"></th>
          <th data-sort="string"><?php echo Lang::$word->_PLG_NS_TITLE;?></th>
          <th data-sort="int"><?php echo Lang::$word->_PLG_NS_POS;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$newsrow):?>
        <tr>
          <td colspan="4"><?php echo Filter::msgSingleAlert(Lang::$word->_PLG_NS_NONEWS);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($newsrow as $row):?>
        <tr id="node-<?php echo $row->id;?>">
          <td class="id-handle"><i class="icon reorder"></i></td>
          <td><?php echo $row->{'title'.Lang::$lang};?></td>
          <td><span class="wk black label"><?php echo $row->position;?></span></td>
          <td><a href="index.php?do=plugins&amp;action=config&amp;plugname=newsslider&amp;paction=edit&amp;id=<?php echo $row->id;?>"><i class="rounded inverted success icon pencil link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_PLG_NS_ITEM;?>" data-option="deleteNews" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title'.Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a></td>
        </tr>
        <?php endforeach;?>
        <?php unset($row);?>
        <?php endif;?>
      </tbody>
    </table>
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
                url: "plugins/newsslider/controller.php?sortnews",
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