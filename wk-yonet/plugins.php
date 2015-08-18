<?php
  /**
   * Plugins
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  if(!$user->getAcl("Plugins")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById(Content::plTable, Filter::$id);?>
<div class="wk icon heading message orange"><a class="helper wk top right info corner label" data-help="plugin"><i class="icon help"></i></a> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PL_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_PL_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PL_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_PL_SUBTITLE1 . $row->{'title'.Lang::$lang};?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PL_TITLE;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->{'title'.Lang::$lang};?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PL_ALT_CLASS;?></label>
          <label class="input">
            <input type="text" value="<?php echo $row->alt_class;?>" name="alt_class">
          </label>
        </div>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_PL_BODY;?></label>
        <textarea id="plugpost" class="plugpost" name="body<?php echo Lang::$lang;?>"><?php echo Filter::out_url($row->{'body'.Lang::$lang});?></textarea>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PL_DESC;?></label>
          <textarea name="info<?php echo Lang::$lang;?>"><?php echo $row->{'info'.Lang::$lang};?></textarea>
        </div>
        <div class="field">
          <?php if(!$row->system):?>
          <label><?php echo Lang::$word->_PG_JSCODE;?></label>
          <textarea name="jscode"><?php echo cleanOut($row->jscode);?></textarea>
          <?php endif;?>
        </div>
      </div>
      <div class="wk fitted divider"></div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PL_PUB;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="active" type="radio" value="1" <?php echo getChecked($row->active, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="active" type="radio" value="0" <?php echo getChecked($row->active, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PL_SHOW_TITLE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="show_title" type="radio" value="1" <?php echo getChecked($row->show_title, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="show_title" type="radio" value="0" <?php echo getChecked($row->show_title, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_PL_UPDATE;?></button>
      <a href="index.php?do=plugins" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="processPlugin" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"add": ?>
<div class="wk icon heading message orange"><a class="helper wk top right info corner label" data-help="plugin"><i class="icon help"></i></a> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PL_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_PL_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PL_INFO2. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_PL_SUBTITLE2;?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PL_TITLE;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_PL_TITLE;?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PL_ALT_CLASS;?></label>
          <label class="input">
            <input type="text" placeholder="<?php echo Lang::$word->_PL_ALT_CLASS;?>" name="alt_class">
          </label>
        </div>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_PL_BODY;?></label>
        <textarea id="plugpost" class="plugpost" name="body<?php echo Lang::$lang;?>"></textarea>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PL_DESC;?></label>
          <textarea name="info<?php echo Lang::$lang;?>"></textarea>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PG_JSCODE;?></label>
          <textarea name="jscode"></textarea>
        </div>
      </div>
      <div class="wk fitted divider"></div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PL_PUB;?></label>
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
          <label><?php echo Lang::$word->_PL_SHOW_TITLE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="show_title" type="radio" value="1" checked="checked">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="show_title" type="radio" value="0">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_PL_ADD;?></button>
      <a href="index.php?do=plugins" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processPlugin" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"config": ?>
<?php $admfile = PLUGPATH . Filter::$plugname . "/admin.php";?>
<?php $clsfile = PLUGPATH . Filter::$plugname . "/admin_class.php";?>
<?php
  if (file_exists($admfile)):
      if (file_exists($clsfile)):
          include_once ($clsfile);
      endif;
      include_once ($admfile);
  else:
      redirect_to("index.php?do=plugins");
  endif;
?>
<?php break;?>
<?php default: ?>
<?php $plugin = $content->getPagePlugins();?>
<div class="wk icon heading message orange"> <i class="icon umbrella"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PL_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_N_PLUGS;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PL_INFO3;?></div>
  <div class="wk segment"> <a class="wk icon positive button push-right" href="index.php?do=plugins&amp;action=add"><i class="icon add"></i> <?php echo Lang::$word->_PL_ADD;?></a>
    <div class="wk header"><?php echo Lang::$word->_PL_SUBTITLE3;?></div>
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
          <th data-sort="string"><?php echo Lang::$word->_PL_TITLE;?></th>
          <th data-sort="int"><?php echo Lang::$word->_PL_CREATED;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$plugin):?>
        <tr>
          <td colspan="4"><?php echo Filter::msgSingleAlert(Lang::$word->_PL_NOPLUG);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($plugin as $row):?>
        <?php if($user->getAcl($row->plugalias)):?>
        <tr>
          <td><?php echo $row->id;?>.</td>
          <td><?php echo $row->{'title'.Lang::$lang};?></td>
          <td data-sort-value="<?php echo strtotime($row->created);?>"><?php echo Filter::dodate("short_date", $row->created);?></td>
          <td><?php echo isActive($row->active);?> <a href="index.php?do=plugins&amp;action=edit&amp;id=<?php echo $row->id;?>"><i class="rounded inverted success icon pencil link"></i></a>
            <?php if($row->hasconfig == 1):?>
            <a href="index.php?do=plugins&amp;action=config&amp;plugname=<?php echo $row->plugalias;?>" data-content="<?php echo Lang::$word->_PL_CONFIG.': '.$row->{'title'.Lang::$lang};?>"><i class="rounded inverted info icon setting link"></i></a>
            <?php endif;?>
            <?php if(!$row->system):?>
            <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_PLUGIN;?>" data-option="deletePlugin" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title' . Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a>
            <?php else:?>
            <i class="rounded warning inverted ban circle icon"></i>
            <?php endif;?></td>
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