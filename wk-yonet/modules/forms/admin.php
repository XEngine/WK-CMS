<?php
  /**
   * Visual Forms
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  if(!$user->getAcl("forms")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
  
  Registry::set('Forms',new Forms());
?>
<?php switch(Filter::$maction): case "edit": ?>
<?php $row = Core::getRowById(Forms::mTable, Filter::$id);?>
<div class="wk icon heading message blue"> <a class="helper wk top right info corner label" data-help="forms"><i class="icon help"></i></a> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=forms" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_TITLE5;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_VF_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_MOD_VF_SUB1 . $row->{'title' . Lang::$lang};?></div>
    <div class="wk double fitted divider"></div>
    <form method="post" id="wk_form" name="wk_form">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_VF_FTITLE;?></label>
          <label class="input"> <i class="icon-append icon asterisk"></i>
            <input name="title<?php echo Lang::$lang;?>" value="<?php echo $row->{'title' . Lang::$lang};?>" type="text">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_VF_FSUBJECT;?></label>
          <label class="input"> <i class="icon-append icon asterisk"></i>
            <input name="subject<?php echo Lang::$lang;?>" value="<?php echo $row->{'subject' . Lang::$lang};?>" type="text">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_VF_MAILTO;?></label>
          <label class="input"> <i class="icon-append icon asterisk"></i>
            <input name="mailto" value="<?php echo $row->mailto;?>" type="text">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_VF_EMAILS;?></label>
          <label class="input">
            <input name="emails" value="<?php echo $row->emails;?>" type="text">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_VF_SBUTTON;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input name="sbutton<?php echo Lang::$lang;?>" value="<?php echo $row->{'sbutton' . Lang::$lang};?>" type="text">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_VF_MESSAGE;?></label>
          <label class="input">
            <input name="sendmessage<?php echo Lang::$lang;?>" value="<?php echo $row->{'sendmessage' . Lang::$lang};?>" type="text">
          </label>
        </div>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_MOD_VF_TEMPLATE;?></label>
        <textarea id="altpost" class="altpost" name="template<?php echo Lang::$lang;?>"><?php echo Filter::out_url($row->{'template'.Lang::$lang});?></textarea>
      </div>
      <div class="field">
        <div class="inline-group">
          <label><?php echo Lang::$word->_MOD_VF_FCAPTCHA;?></label>
          <label class="radio">
            <input name="captcha" type="radio" value="1" <?php getChecked($row->captcha, 1);?> >
            <i></i><?php echo Lang::$word->_YES;?></label>
          <label class="radio">
            <input name="captcha" type="radio"  value="0" <?php getChecked($row->captcha, 0);?>>
            <i></i> <?php echo Lang::$word->_NO;?> </label>
        </div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_MOD_VF_UPDATE;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=forms" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processForm" type="hidden" value="1">
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"add": ?>
<div class="wk icon heading message blue"> <a class="helper wk top right info corner label" data-help="forms"><i class="icon help"></i></a> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=forms" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_TITLE4;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_VF_INFO2. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_MOD_VF_SUB2;?></div>
    <div class="wk double fitted divider"></div>
    <form method="post" id="wk_form" name="wk_form">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_VF_FTITLE;?></label>
          <label class="input"> <i class="icon-append icon asterisk"></i>
            <input name="title<?php echo Lang::$lang;?>" placeholder="<?php echo Lang::$word->_MOD_VF_FTITLE;?>" type="text">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_VF_FSUBJECT;?></label>
          <label class="input"> <i class="icon-append icon asterisk"></i>
            <input name="subject<?php echo Lang::$lang;?>" placeholder="<?php echo Lang::$word->_MOD_VF_FSUBJECT;?>" type="text">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_VF_MAILTO;?></label>
          <label class="input"> <i class="icon-append icon asterisk"></i>
            <input name="mailto" placeholder="<?php echo Lang::$word->_MOD_VF_MAILTO;?>" type="text">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_VF_EMAILS;?></label>
          <label class="input">
            <input name="emails" placeholder="<?php echo Lang::$word->_MOD_VF_EMAILS;?>" type="text">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_VF_SBUTTON;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input name="sbutton<?php echo Lang::$lang;?>" placeholder="<?php echo Lang::$word->_MOD_VF_SBUTTON;?>" type="text">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_VF_MESSAGE;?></label>
          <label class="input">
            <input name="sendmessage<?php echo Lang::$lang;?>" placeholder="<?php echo Lang::$word->_MOD_VF_MESSAGE;?>" type="text">
          </label>
        </div>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_MOD_VF_TEMPLATE;?></label>
        <textarea id="altpost" class="altpost" name="template<?php echo Lang::$lang;?>"><?php echo "&lt;div align=&quot;center&quot;&gt; &lt;table width=&quot;600&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt; &lt;tbody&gt; &lt;tr&gt; &lt;th style=&quot;background-color: rgb(204, 204, 204);&quot;&gt;Hello Admin&lt;/th&gt; &lt;/tr&gt; &lt;tr&gt; &lt;td valign=&quot;top&quot; style=&quot;text-align: left;&quot;&gt;You have a new [FORMNAME] request: &lt;hr /&gt; [FORMDATA] &lt;/td&gt; &lt;/tr&gt; &lt;/tbody&gt; &lt;/table&gt;&lt;/div&gt;";?></textarea>
      </div>
      <div class="field">
        <div class="inline-group">
          <label><?php echo Lang::$word->_MOD_VF_FCAPTCHA;?></label>
          <label class="radio">
            <input name="captcha" type="radio" value="1" checked="checked" />
            <i></i><?php echo Lang::$word->_YES;?></label>
          <label class="radio">
            <input name="captcha" type="radio"  value="0" />
            <i></i> <?php echo Lang::$word->_NO;?> </label>
        </div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_MOD_VF_ADD;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=forms" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processForm" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"fields": ?>
<?php $row = Core::getRowById(Forms::mTable, Filter::$id);?>
<?php $allfields = Registry::get("Forms")->getAllFields();?>
<div class="wk icon heading message blue"> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=forms" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo str_replace("[ICOADD]", "<i class=\"icon add sign\"></i>", Lang::$word->_MOD_VF_INFO);?></div>
  <div class="wk form segment"><a class="wk icon warning button push-right" href="index.php?do=modules&amp;action=config&amp;modname=forms"><i class="icon reply mail"></i> <?php echo Lang::$word->_MOD_VF_BACK;?></a>
    <div class="wk header"><?php echo Lang::$word->_MOD_VF_SUB4 . $row->{'title' . Lang::$lang};?></div>
    <div class="wk fitted divider"></div>
    <div class="wk info stacked segment">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_VF_CFIELD;?></label>
          <select name="newfield">
            <?php echo Forms::fieldTypes();?>
          </select>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_VF_EDITFIELD;?></label>
          <select name="editfield">
            <option value=""><?php echo Lang::$word->_MOD_VF_CFIELD_S;?></option>
            <?php if($allfields):?>
            <?php foreach($allfields as $arow):?>
            <option value="<?php echo $arow->id;?>"><?php echo $arow->{'title' . Lang::$lang};?></option>
            <?php endforeach;?>
            <?php endif;?>
          </select>
        </div>
      </div>
    </div>
    <div class="wk thin attached divider"></div>
    <div id="fieldOptions" style="display:none">
      <div class="wk info segment">
        <form method="post" id="wk_form" name="wk_form">
          <div class="fieldarea"> </div>
        </form>
      </div>
      <div id="msgholder"></div>
      <div class="wk thin attached divider"></div>
    </div>
    <div class="two fitted fields">
      <div class="field">
        <div class="wk warning buttons" id="addRow">
          <div class="wk button"><?php echo Lang::$word->_MOD_VF_ADDROW;?></div>
          <div class="wk positive floating dropdown icon button"> <i class="dropdown icon"></i>
            <div class="menu">
              <div class="item" data-type="four"><i class="edit icon"></i><?php echo Lang::$word->_MOD_VF_FOUR_FIELDS;?></div>
              <div class="item" data-type="three"><i class="edit icon"></i><?php echo Lang::$word->_MOD_VF_THREE_FIELDS;?></div>
              <div class="item" data-type="two"><i class="edit icon"></i><?php echo Lang::$word->_MOD_VF_TWO_FIELDS;?></div>
              <div class="item" data-type="one"><i class="edit icon"></i><?php echo Lang::$word->_MOD_VF_ONE_FIELD;?></div>
            </div>
          </div>
        </div>
      </div>
      <div class="field">
        <div id="removerows"><i class="icon trash"></i> <?php echo Lang::$word->_MOD_VF_DROPHERE;?></div>
      </div>
    </div>
    <div class="wk divider"></div>
    <div id="renderForm"> <?php echo cleanOut($row->{'data' . Lang::$lang});?></div>
  </div>
  <a id="serialize" class="wk positive button"><?php echo Lang::$word->_MOD_VF_SAVEALL;?></a>
  <div id="smsgholder" class="small-top-space"></div>
</div>
<script src="modules/forms/forms.js"></script> 
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function () {
    $.forms({
        url: "modules/forms/controller.php",
        formid: $.url(true).param('id'),
		editor: <?php echo $core->editor;?>,
        msg: {
            btnsubmit: "<?php echo Lang::$word->_MOD_VF_INSERTFIELD;?>",
            selfile: "<?php echo Lang::$word->_MOD_VF_SELECT_FILE;?>"
        }
    });
});
// ]]>
</script>
<?php break;?>
<?php case"preview": ?>
<?php $row = Core::getRowById(Forms::mTable, Filter::$id);?>
<div class="wk icon heading message blue"> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=forms" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_VF_INFO4;?></div>
  <div class="wk form segment"><a class="wk icon warning button push-right" href="index.php?do=modules&amp;action=config&amp;modname=forms"><i class="icon reply mail"></i> <?php echo Lang::$word->_MOD_VF_BACK;?></a>
    <div class="wk header"><?php echo Lang::$word->_MOD_VF_SUB4 . $row->{'title' . Lang::$lang};?></div>
    <div class="wk fitted divider"></div>
    <?php echo cleanOut($row->{'html' . Lang::$lang});?> </div>
</div>
<?php break;?>
<?php default: ?>
<?php $formsrow = Registry::get("Forms")->getForms();?>
<div class="wk icon heading message blue"> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo $content->getModuleName(Filter::$modname);?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_VF_INFO3;?></div>
  <div class="wk segment"> <a class="wk icon warning button push-right" href="<?php echo Core::url("modules", "add");?>"><i class="icon add"></i> <?php echo Lang::$word->_MOD_VF_ADDFORM;?></a>
    <div class="wk header"><?php echo Lang::$word->_MOD_VF_SUB3;?></div>
    <div class="wk fitted divider"></div>
    <table class="wk sortable table">
      <thead>
        <tr>
          <th data-sort="int">#</th>
          <th data-sort="string"><?php echo Lang::$word->_MOD_VF_FTITLE;?></th>
          <th data-sort="int"><?php echo Lang::$word->_CREATED;?></th>
          <th class="disabled"><?php echo Lang::$word->_MOD_VF_PREVIEW;?></th>
          <th class="disabled"><?php echo Lang::$word->_MOD_VF_FLAYOUT;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$formsrow):?>
        <tr>
          <td colspan="6"><?php echo Filter::msgAlert(Lang::$word->_MOD_VF_NOFORMS);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($formsrow as $row):?>
        <tr>
          <td><?php echo $row->id;?>.</td>
          <td><?php echo $row->{'title' . Lang::$lang};?></td>
          <td data-sort-value="<?php echo strtotime($row->created);?>"><?php echo Filter::dodate('short_date', $row->created);?></td>
          <td><a href="<?php echo Core::url("modules", "preview", $row->id);?>" data-content="<?php echo Lang::$word->_VIEW;?>"><i class="rounded black inverted laptop icon link"></i></a></td>
          <td><a href="<?php echo Core::url("modules", "fields", $row->id);?>" data-content="<?php echo Lang::$word->_EDIT;?>"><i class="rounded info inverted tasks icon link"></i></a></td>
          <td><a href="<?php echo Core::url("modules", "edit", $row->id);?>"><i class="rounded inverted success icon pencil link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_MOD_VF_DELETE;?>" data-option="deleteForm" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title' . Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a></td>
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