<?php
  /**
   * FAQ Manager
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  if(!$user->getAcl("faq")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;

  Registry::set('FAQManager',new FAQManager());
?>
<?php switch(Filter::$maction): case "edit": ?>
<?php $row = Core::getRowById(FAQManager::mTable, Filter::$id);?>
<div class="wk icon heading message blue"> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_FAQ_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=faq" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_FAQ_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_FAQ_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_MOD_FAQ_SUBTITLE1 . $row->{'question' . Lang::$lang};?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="field">
        <label><?php echo Lang::$word->_MOD_FAQ_TITLE;?></label>
        <label class="input"><i class="icon-append icon asterisk"></i>
          <input type="text" value="<?php echo $row->{'question' . Lang::$lang};?>" name="question<?php echo Lang::$lang;?>">
        </label>
      </div>
      <div class="wk fitted divider"></div>
      <div class="field">
        <label><?php echo Lang::$word->_MOD_FAQ_DESC;?></label>
        <textarea id="plugpost" class="plugpost" name="answer<?php echo Lang::$lang;?>"><?php echo Filter::out_url($row->{'answer' . Lang::$lang});?></textarea>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_MOD_FAQ_UPDATE;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=faq" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="processFaq" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"add": ?>
<div class="wk icon heading message blue"> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_FAQ_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=faq" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_FAQ_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_FAQ_INFO. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_MOD_FAQ_SUBTITLE;?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="field">
        <label><?php echo Lang::$word->_MOD_FAQ_TITLE;?></label>
        <label class="input"><i class="icon-append icon asterisk"></i>
          <input type="text" placeholder="<?php echo Lang::$word->_MOD_FAQ_TITLE;?>" name="question<?php echo Lang::$lang;?>">
        </label>
      </div>
      <div class="wk fitted divider"></div>
      <div class="field">
        <label><?php echo Lang::$word->_MOD_FAQ_DESC;?></label>
        <textarea id="plugpost" class="plugpost" name="answer<?php echo Lang::$lang;?>"></textarea>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_MOD_FAQ_ADD;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=faq" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processFaq" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php default: ?>
<?php $faqrow = Registry::get("FAQManager")->getFaq();?>
<div class="wk icon heading message blue"> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_FAQ_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo $content->getModuleName(Filter::$modname);?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_FAQ_INFO3;?></div>
  <div class="wk segment"> <a href="<?php echo Core::url("modules", "add");?>" class="wk info button push-right"><i class="icon add"></i><?php echo Lang::$word->_MOD_FAQ_ADD;?></a>
    <div class="wk header"><?php echo Lang::$word->_MOD_FAQ_SUBTITLE3;?></div>
    <div class="wk fitted divider"></div>
    <table class="wk sortable table">
      <thead>
        <tr>
          <th class="disabled"></th>
          <th data-sort="string"><?php echo Lang::$word->_MOD_FAQ_TITLE;?></th>
          <th data-sort="int"><?php echo Lang::$word->_MOD_FAQ_POS;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$faqrow):?>
        <tr>
          <td colspan="4"><?php echo Filter::msgSingleAlert(Lang::$word->_MOD_FAQ_NOFAQS);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($faqrow as $row):?>
        <tr id="node-<?php echo $row->id;?>">
          <td class="id-handle"><i class="icon reorder"></i></td>
          <td><?php echo $row->{'question' . Lang::$lang};?></td>
          <td><span class="wk black label"><?php echo $row->position;?></span></td>
          <td><a href="<?php echo Core::url("modules", "edit", $row->id);?>"><i class="rounded inverted success icon pencil link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_MOD_FAQ_FAQ;?>" data-option="deleteFaq" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'question' . Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a></td>
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
                url: "modules/faq/controller.php?sortslides",
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