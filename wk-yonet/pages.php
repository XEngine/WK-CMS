<?php
  /**
   * Pages
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  if(!$user->getAcl("Pages")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById(Content::pTable, Filter::$id);?>
<div class="wk icon heading message green"><a class="helper wk top right info corner label" data-help="page"><i class="icon help"></i></a> <i class="file icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PG_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=pages" class="section"><?php echo Lang::$word->_N_PAGES;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_PG_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PG_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_PG_SUBTITLE1 . $row->{'title'.Lang::$lang};?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PG_TITLE;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->{'title'.Lang::$lang};?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PG_SLUG;?></label>
          <label class="input">
            <input type="text" value="<?php echo $row->slug;?>" name="slug">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PG_CAPTION;?></label>
          <label class="input">
            <input type="text" value="<?php echo $row->{'caption'.Lang::$lang};?>" name="caption<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field"></div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PG_ACCESS_L;?></label>
          <select name="access" id="access_id" data-id="<?php echo $row->id;?>">
            <?php echo $member->getAccessList($row->access);?>
          </select>
        </div>
        <div class="field" id="memrow">
          <label><?php echo Lang::$word->_PG_MEM_LEVEL;?></label>
          <div id="membership">
            <?php if($row->membership_id == 0):?>
            <input disabled="disabled" type="text" value="<?php echo Lang::$word->_PG_NOMEM_REQ;?>" name="na">
            <?php else:?>
            <?php echo $member->getMembershipList($row->membership_id);?>
            <?php endif;?>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PG_SEL_MODULE;?></label>
          <select name="module_id" id="modulename" data-module="<?php echo $row->module_data;?>" data-id="<?php echo $row->module_id;?>">
            <?php echo $content->getModuleList($row->module_id);?>
          </select>
        </div>
        <div class="field" id="modshow"></div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PG_BG_IMAGE;?></label>
          <div class="wk action input">
            <input name="filename" type="text" data-ext="images" readonly>
            <div class="filepicker wk icon button"><i class="open folder icon"></i></div>
          </div>
        </div>
        <div class="field">
          <div class="two fields">
            <div class="field">
              <label><?php echo Lang::$word->_PG_BG_IMAGE_REM;?></label>
              <div class="inline-group">
                <label class="checkbox">
                  <input name="delimg" type="checkbox" value="1">
                  <i></i><?php echo Lang::$word->_YES;?></label>
              </div>
            </div>
            <div class="field">
              <?php if($row->custom_bg):?>
              <div class="wk small image"> <a href="<?php echo UPLOADURL . $row->custom_bg;?>" class="lightbox"><img src="<?php echo UPLOADURL . $row->custom_bg;?>" alt="<?php echo $row->custom_bg;?>"></a> </div>
              <?php endif;?>
            </div>
          </div>
        </div>
      </div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_PG_CC;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="contact_form" type="radio" value="1" <?php echo getChecked($row->contact_form, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="contact_form" type="radio" value="0" <?php echo getChecked($row->contact_form, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MU_HOME;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="home_page" type="radio" value="1" <?php echo getChecked($row->home_page, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="home_page" type="radio" value="0" <?php echo getChecked($row->home_page, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PG_LOGIN;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="login" type="radio" value="1" <?php echo getChecked($row->login, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="login" type="radio" value="0" <?php echo getChecked($row->login, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_PG_REGISTER;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="register" type="radio" value="1" <?php echo getChecked($row->register, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="register" type="radio" value="0" <?php echo getChecked($row->register, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PG_ACTIVATE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="activate" type="radio" value="1" <?php echo getChecked($row->activate, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="activate" type="radio" value="0" <?php echo getChecked($row->activate, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PG_ACCOUNT;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="account" type="radio" value="1" <?php echo getChecked($row->account, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="account" type="radio" value="0" <?php echo getChecked($row->account, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_PG_SITEMAP;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="sitemap" type="radio" value="1" <?php echo getChecked($row->sitemap, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="sitemap" type="radio" value="0" <?php echo getChecked($row->sitemap, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PG_SEARCH;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="search" type="radio" value="1" <?php echo getChecked($row->search, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="search" type="radio" value="0" <?php echo getChecked($row->search, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <?php if($user->userlevel == 9):?>
          <label><?php echo Lang::$word->_PG_ADMONLY;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="is_admin" type="radio" value="1" <?php echo getChecked($row->is_admin, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="is_admin" type="radio" value="0" <?php echo getChecked($row->is_admin, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
          <?php endif;?>
        </div>
      </div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_PG_PROFILE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="profile" type="radio" value="1" <?php echo getChecked($row->profile, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="profile" type="radio" value="0" <?php echo getChecked($row->profile, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field"></div>
        <div class="field"></div>
      </div>
      <div class="wk divider"></div>
      <div class="field">
        <label><?php echo Lang::$word->_PG_JSCODE;?></label>
        <textarea name="jscode"><?php echo $row->jscode;?></textarea>
      </div>
      <div class="field">
        <textarea id="bodypost" class="bodypost" name="body<?php echo Lang::$lang;?>"><?php echo Filter::out_url($row->{'body'.Lang::$lang});?></textarea>
      </div>
      <div class="wk divider"></div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PG_KEYS;?></label>
          <textarea name="keywords<?php echo Lang::$lang;?>"><?php echo $row->{'keywords'.Lang::$lang};?></textarea>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PG_DESC;?></label>
          <textarea name="description<?php echo Lang::$lang;?>"><?php echo $row->{'description'.Lang::$lang};?></textarea>
        </div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_PG_UPDATE;?></button>
      <a href="index.php?do=pages" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="processPage" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"add": ?>
<div class="wk icon heading message green"><a class="helper wk top right info corner label" data-help="page"><i class="icon help"></i></a> <i class="file icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PG_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=pages" class="section"><?php echo Lang::$word->_N_PAGES;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_PG_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PG_INFO2. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_PG_SUBTITLE2;?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PG_TITLE;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_PG_TITLE;?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PG_SLUG;?></label>
          <label class="input">
            <input type="text" placeholder="<?php echo Lang::$word->_PG_SLUG;?>" name="slug">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PG_CAPTION;?></label>
          <label class="input">
            <input type="text" placeholder="<?php echo Lang::$word->_PG_SLUG;?>" name="caption<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field"></div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PG_ACCESS_L;?></label>
          <select name="access" id="access_id" data-id="-1">
            <?php echo $member->getAccessList();?>
          </select>
        </div>
        <div class="field" id="memrow">
          <label><?php echo Lang::$word->_PG_MEM_LEVEL;?></label>
          <div id="membership">
            <input type="text" disabled="disabled" value="<?php echo Lang::$word->_PG_NOMEM_REQ;?>" name="na">
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PG_SEL_MODULE;?></label>
          <select name="module_id" id="modulename" data-module="0" data-id="0">
            <?php echo $content->getModuleList();?>
          </select>
        </div>
        <div class="field" id="modshow"></div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PG_BG_IMAGE;?></label>
          <div class="wk action input">
            <input name="filename" type="text" data-ext="images" readonly>
            <div class="filepicker wk icon button"><i class="open folder icon"></i></div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PG_JSCODE;?></label>
          <textarea placeholder="<?php echo Lang::$word->_PG_JSCODE;?>" name="jscode"></textarea>
        </div>
      </div>
      <div class="wk divider"></div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_PG_CC;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="contact_form" type="radio" value="1">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="contact_form" type="radio" value="0" checked="checked">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MU_HOME;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="home_page" type="radio" value="1" >
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="home_page" type="radio" value="0" checked="checked">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PG_LOGIN;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="login" type="radio" value="1">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="login" type="radio" value="0" checked="checked">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_PG_REGISTER;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="register" type="radio" value="1">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="register" type="radio" value="0" checked="checked">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PG_ACTIVATE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="activate" type="radio" value="1">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="activate" type="radio" value="0" checked="checked">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PG_ACCOUNT;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="account" type="radio" value="1">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="account" type="radio" value="0" checked="checked">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_PG_SITEMAP;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="sitemap" type="radio" value="1">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="sitemap" type="radio" value="0" checked="checked">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PG_SEARCH;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="search" type="radio" value="1">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="search" type="radio" value="0" checked="checked">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <?php if($user->userlevel == 9):?>
        <div class="field">
          <label><?php echo Lang::$word->_PG_ADMONLY;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="is_admin" type="radio" value="1">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="is_admin" type="radio" value="0" checked="checked">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <?php endif;?>
      </div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_PG_PROFILE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="profile" type="radio" value="1">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="profile" type="radio" value="0"  checked="checked">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field"></div>
        <div class="field"></div>
      </div>
      <div class="wk divider"></div>
      <div class="field">
        <textarea id="bodypost" placeholder="<?php echo Lang::$word->_PG_BODY;?>" class="bodypost" name="body<?php echo Lang::$lang;?>"></textarea>
      </div>
      <div class="wk divider"></div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PG_KEYS;?></label>
          <textarea placeholder="<?php echo Lang::$word->_PG_KEYS;?>" name="keywords<?php echo Lang::$lang;?>" cols="55" rows="6"></textarea>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PG_DESC;?></label>
          <textarea placeholder="<?php echo Lang::$word->_PG_DESC;?>" name="description<?php echo Lang::$lang;?>" cols="55" rows="6"></textarea>
        </div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_PG_ADD;?></button>
      <a href="index.php?do=pages" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processPage" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php default: ?>
<?php $pages = $content->getPages(true);?>
<div class="wk icon heading message green"> <i class="file icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PG_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_N_PAGES;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PG_INFO3;?></div>
  <div class="wk segment"> <a class="wk icon positive button push-right" href="index.php?do=pages&amp;action=add"><i class="icon add"></i> <?php echo Lang::$word->_PG_ADD;?></a>
    <div class="wk header"><?php echo Lang::$word->_PG_SUBTITLE3;?></div>
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
          <th data-sort="string"><?php echo Lang::$word->_PG_TITLE;?></th>
          <th class="disabled"><?php echo Lang::$word->_PG_TYPE;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$pages):?>
        <tr>
          <td colspan="6"><?php Filter::msgSingleAlert(Lang::$word->_PG_NOPAGES);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($pages as $row):?>
        <tr>
          <td><?php echo $row->id;?>.</td>
          <td><?php echo $row->{'title' . Lang::$lang};?></td>
          <td><?php if($row->contact_form):?>
            <i class="rounded inverted teal icon mail"></i>
            <?php elseif($row->home_page):?>
            <i class="rounded inverted icon purple home"></i>
            <?php else:?>
            <i class="rounded inverted icon file"></i>
            <?php endif;?></td>
          <td><?php echo isActive($row->active);?> <a href="index.php?do=pages&amp;action=edit&amp;id=<?php echo $row->id;?>"><i class="rounded inverted success icon pencil link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_PAGE;?>" data-option="deletePage" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title' . Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a></td>
        </tr>
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