<?php
  /**
   * Modules
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2010
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  if(!$user->getAcl("Modules")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById(Content::mdTable, Filter::$id);?>
<div class="wk icon heading message blue"><a class="helper wk top right info corner label" data-help="module"><i class="icon help"></i></a> <i class="icon puzzle piece"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MO_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_N_MODS;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MO_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_MO_SUBTITLE1 . $row->{'title'.Lang::$lang};?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MO_TITLE;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->{'title'.Lang::$lang};?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MO_DESC;?></label>
          <label class="input">
            <input type="text" value="<?php echo $row->{'info'.Lang::$lang};?>" name="info<?php echo Lang::$lang;?>">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_METAKEYS;?></label>
          <textarea name="metakey<?php echo Lang::$lang;?>" cols="55" rows="6"><?php echo $row->{'metakey'.Lang::$lang};?></textarea>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_METADESC;?></label>
          <textarea name="metadesc<?php echo Lang::$lang;?>" cols="55" rows="6"><?php echo $row->{'metadesc'.Lang::$lang};?></textarea>
        </div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_MO_UPDATE;?></button>
      <a href="index.php?do=modules" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="processModule" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"config": ?>
<?php $admfile = MODPATH . Filter::$modname . "/admin.php";?>
<?php $clsfile = MODPATH . Filter::$modname . "/admin_class.php";?>
<?php
  if (file_exists($admfile)):
      if (file_exists($clsfile)):
          include_once ($clsfile);
      endif;
      include_once ($admfile);
  else:
      redirect_to("index.php?do=modules");
  endif;
?>
<?php break;?>
<?php default: ?>
<?php $module = $content->getPageModules();?>
<div class="wk icon heading message blue"> <i class="icon puzzle piece"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MO_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_N_MODS;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MO_INFO3;?></div>
  <div class="wk segment">
    <div class="wk header"><?php echo Lang::$word->_MO_SUBTITLE3;?></div>
    <div class="wk fitted divider"></div>
    <div class="wk small basic form segment">
      <div class="four fields">
        <div class="field empty">&nbsp;</div>
        <div class="field empty">&nbsp;</div>
        <div class="field"> <?php echo $pager->items_per_page();?> </div>
        <div class="field"> <?php echo $pager->jump_menu();?> </div>
      </div>
    </div>
    <table class="wk sortable table">
      <thead>
        <tr>
          <th data-sort="int">#</th>
          <th data-sort="string"><?php echo Lang::$word->_MO_TITLE;?></th>
          <th data-sort="int"><?php echo Lang::$word->_MO_CREATED;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$module):?>
        <tr>
          <td colspan="4"><?php echo Filter::msgSingleAlert(Lang::$word->_MO_NOMOD);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($module as $row):?>
        <?php if($user->getAcl($row->modalias)):?>
        <tr>
          <td><?php echo $row->id;?>.</td>
          <td><?php echo $row->{'title'.Lang::$lang};?></td>
          <td data-sort-value="<?php echo strtotime($row->created);?>"><?php echo Filter::dodate("short_date", $row->created);?></td>
          <td><?php echo isActive($row->active);?> <a href="index.php?do=modules&amp;action=edit&amp;id=<?php echo $row->id;?>"><i class="rounded inverted success icon pencil link"></i></a>
            <?php if($row->hasconfig):?>
            <a href="index.php?do=modules&amp;action=config&amp;modname=<?php echo $row->modalias;?>" data-content="<?php echo Lang::$word->_MO_CONFIG.': '.$row->{'title'.Lang::$lang};?>"><i class="rounded inverted info icon setting link"></i></a>
            <?php endif;?>
            <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_MODULE;?>" data-option="deleteModule" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title' . Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a></td>
        </tr>
        <?php endif;?>
        <?php endforeach;?>
        <?php unset($row);?>
        <?php endif;?>
      </tbody>
    </table>
  </div>
  <div class="wk-grid">
    <div class="two columns horizontal-gutters">
      <div class="row"> <span class="wk label"><?php echo Lang::$word->_PAG_TOTAL.': '.$pager->items_total;?> / <?php echo Lang::$word->_PAG_CURPAGE.': '.$pager->current_page.' '.Lang::$word->_PAG_OF.' '.$pager->num_pages;?></span> </div>
      <div class="row">
        <div id="pagination"><?php echo $pager->display_pages();?></div>
      </div>
    </div>
  </div>
</div>
<?php break;?>
<?php endswitch;?>