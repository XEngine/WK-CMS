<?php
  /**
   * Email Templates
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  if(!$user->getAcl("Templates")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById(Content::eTable, Filter::$id);?>
<div class="wk icon heading message mortar"> <i class="mail icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_ET_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=templates" class="section"><?php echo Lang::$word->_N_EMAILS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_ET_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_ET_INFO2. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_ET_SUBTITLE2 . $row->{'name'.Lang::$lang};?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_ET_TTITLE;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->{'name'.Lang::$lang};?>" name="name<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_ET_SUBJECT;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->{'subject'.Lang::$lang};?>" name="subject<?php echo Lang::$lang;?>">
          </label>
        </div>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_ET_BODY;?></label>
        <textarea id="bodypost" class="bodypost" name="body<?php echo Lang::$lang;?>"><?php echo $row->{'body'.Lang::$lang};?></textarea>
        <p class="wk error note"><?php echo Lang::$word->_ET_VAR_T;?></p>
      </div>
      <div class="wk divider"></div>
      <div class="field">
        <label><?php echo Lang::$word->_ET_TPL_DESC;?></label>
        <textarea name="help<?php echo Lang::$lang;?>"><?php echo $row->{'help'.Lang::$lang};?></textarea>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_ET_UPDATE;?></button>
      <a href="index.php?do=templates" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processTemplate" type="hidden" value="1">
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"add": ?>
<div class="wk icon heading message mortar"> <a class="helper wk top right info corner label" data-help="email"><i class="icon help"></i></a><i class="mail icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_ET_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=templates" class="section"><?php echo Lang::$word->_N_EMAILS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_ET_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_ET_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_ET_SUBTITLE1;?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_ET_TTITLE;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_ET_TTITLE;?>" name="name<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_ET_SUBJECT;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_ET_TTITLE;?>" name="subject<?php echo Lang::$lang;?>">
          </label>
        </div>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_ET_BODY;?></label>
        <textarea id="bodypost" class="bodypost" placeholder"<?php echo Lang::$word->_ET_BODY;?>" name="body<?php echo Lang::$lang;?>"></textarea>
      </div>
      <div class="wk divider"></div>
      <div class="field">
        <label><?php echo Lang::$word->_ET_TPL_DESC;?></label>
        <textarea placeholder"<?php echo Lang::$word->_ET_TPL_DESC;?>" name="help<?php echo Lang::$lang;?>"></textarea>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_ET_ADD;?></button>
      <a href="index.php?do=templates" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processTemplate" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php default: ?>
<?php $tplrow = $member->getEmailTemplates()?>
<div class="wk icon heading message mortar"> <i class="mail icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_ET_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_N_EMAILS;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_ET_INFO3;?></div>
  <div class="wk segment"><a class="wk icon positive button push-right" href="index.php?do=templates&amp;action=add"><i class="icon add"></i> <?php echo Lang::$word->_ET_ADD;?></a>
    <div class="wk header"><?php echo Lang::$word->_ET_SUBTITLE3;?></div>
    <div class="wk fitted divider"></div>
    <table class="wk sortable table">
      <thead>
        <tr>
          <th data-sort="int">#</th>
          <th data-sort="string"><?php echo Lang::$word->_ET_TTITLE;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$tplrow):?>
        <tr>
          <td colspan="3"><?php Filter::msgSingleAlert(Lang::$word->_ET_NOTEMPLATE);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($tplrow as $row):?>
        <tr>
          <td><?php echo $row->id;?>.</td>
          <td><?php echo $row->{'name'.Lang::$lang};?></td>
          <td><a href="index.php?do=templates&amp;action=edit&amp;id=<?php echo $row->id;?>"><i class="rounded inverted success icon pencil link"></i></a></td>
        </tr>
        <?php endforeach;?>
        <?php unset($row);?>
        <?php endif;?>
      </tbody>
    </table>
  </div>
</div>
<?php break;?>
<?php endswitch;?>