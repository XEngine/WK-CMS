<?php
  /**
   * jQuery Poll
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  if(!$user->getAcl("poll")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
  
  Registry::set('Poll', new Poll());
?>
<?php switch(Filter::$paction): case "edit": ?>
<?php $row = Core::getRowById(Poll::qTable, Filter::$id);?>
<?php $pollopt = Registry::get("Poll")->getPollOptions();?>
<div class="wk icon heading message orange"> <a class="helper wk top right info corner label" data-help="poll"><i class="icon help"></i></a> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PLG_PL_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=poll" class="section"><?php echo $content->getPluginName(Filter::$plugname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_PLG_PL_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PLG_PL_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_PLG_PL_SUBTITLE1 . $row->{'question'.Lang::$lang};?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_PL_QUESTION;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->{'question'.Lang::$lang};?>" name="question<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_PL_ACTIVE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="status" type="radio" value="1" <?php getChecked($row->status, 1); ?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="status" type="radio" value="0" <?php getChecked($row->status, 0); ?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="wk divider"></div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_PL_OPTIONS;?></label>
          <div class="field">
            <?php foreach ($pollopt as $k => $v): ?>
            <?php $k++;?>
            <div id="input_<?php echo $k;?>" class="field newQuestion">
              <input name="value<?php echo Lang::$lang;?>[<?php echo $k;?>]" type="text" id="value<?php echo $k; ?>" value="<?php echo $v->{'value'.Lang::$lang};?>">
            </div>
            <?php endforeach;?>
            <button type="button" id="btnAdd" class="wk small positive button"><?php echo Lang::$word->_PLG_PL_ADD_Q;?></button>
            <button type="button" id="btnDel" class="wk small negative button"><?php echo Lang::$word->_PLG_PL_DEL_Q;?></button>
          </div>
        </div>
        <div class="field">&nbsp;</div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_PLG_PL_UPDATE;?></button>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=poll" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="updatePoll" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
    $('#btnAdd').on('click', function () {
        var num = $('.newQuestion').length;
        var newNum = new Number(num + 1);
        var newElem = $('#input_' + num).clone().attr('id', 'input_' + newNum);

		newElem.find('.newQuestion input').attr('id', 'value' + newNum).attr('name', 'value[' + newNum + ']').val('');

        $('#input_' + num).after(newElem);
        (num) ? $('#btnDel').show() : $('#btnDel').hide();
    });

    $('#btnDel').on('click', function () {
        var num = $('.newQuestion').length;

        $('#input_' + num).remove();
        (num - 1 == 1) ? $('#btnDel').hide() : $('#btnDel').show();
    });
});
// ]]>
</script>
<?php break;?>
<?php case"add": ?>
<div class="wk icon heading message orange"> <a class="helper wk top right info corner label" data-help="poll"><i class="icon help"></i></a> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PLG_PL_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=poll" class="section"><?php echo $content->getPluginName(Filter::$plugname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_PLG_PL_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PLG_PL_INFO2. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_PLG_PL_SUBTITLE2;?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_PL_QUESTION;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_PLG_PL_QUESTION;?>" name="question<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_PL_ACTIVE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="status" type="radio" value="1" checked="checked">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="status" type="radio" value="0">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="wk divider"></div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_PL_OPTIONS;?></label>
          <div id="input_1" class="field newQuestion">
            <input placeholder="<?php echo Lang::$word->_PLG_PL_OPTIONS;?>" name="value[1]" type="text"  id="value1">
          </div>
          <button type="button" id="btnAdd" class="wk small positive button"><?php echo Lang::$word->_PLG_PL_ADD_Q;?></button>
          <button type="button" id="btnDel" class="wk small negative button"><?php echo Lang::$word->_PLG_PL_DEL_Q;?></button>
        </div>
        <div class="field">&nbsp;</div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_PLG_PL_ADD;?></button>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=poll" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="addPoll" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
	$('#btnDel').hide();
    $('#btnAdd').click(function () {
        var num = $('.newQuestion').length;
        var newNum = new Number(num + 1);
        var newElem = $('#input_' + num).clone().attr('id', 'input_' + newNum);

        newElem.children(':first').attr('id', 'value' + newNum).attr('name', 'value[' + newNum + ']');
        $('#input_' + num).after(newElem);
		(num) ? $('#btnDel').show() : $('#btnDel').hide();
    });

    $('#btnDel').click(function () {
        var num = $('.newQuestion').length;
        $('#input_' + num).remove();
        (num - 1 == 1) ? $('#btnDel').hide() : $('#btnDel').show();
    });
});
// ]]>
</script>
<?php break;?>
<?php default: ?>
<?php $pollrow = Registry::get("Poll")->getPolls();?>
<div class="wk icon heading message orange"> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PLG_PL_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo $content->getPluginName(Filter::$plugname);?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PLG_PL_INFO3;?></div>
  <div class="wk segment"> <a href="index.php?do=plugins&amp;action=config&amp;plugname=poll&amp;paction=add" class="wk info button push-right"><i class="icon add"></i><?php echo Lang::$word->_PLG_PL_ADD1;?></a>
    <div class="wk header"><?php echo Lang::$word->_PLG_PL_SUBTITLE3;?></div>
    <div class="wk fitted divider"></div>
    <table class="wk sortable table">
      <thead>
        <tr>
          <th data-sort="int">#</th>
          <th data-sort="string"><?php echo Lang::$word->_PLG_PL_QUESTION;?></th>
          <th data-sort="int"><?php echo Lang::$word->_CREATED;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$pollrow):?>
        <tr>
          <td colspan="4"><?php echo Filter::msgSingleAlert(Lang::$word->_PLG_PL_NOPOLL);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($pollrow as $row):?>
        <tr>
          <td><?php echo $row->id;?>.</td>
          <td><?php echo $row->{'question'.Lang::$lang};?></td>
          <td data-sort-value="<?php echo strtotime($row->created);?>"><?php echo Filter::dodate("short_date", $row->created);?></td>
          <td><a class="view-poll" data-id="<?php echo $row->id;?>" data-content="<?php echo Lang::$word->_PLG_PL_VIEW;?>" data-name="<?php echo $row->{'question'.Lang::$lang};?>"><i class="rounded inverted info icon laptop link"></i></a> <a href="index.php?do=plugins&amp;action=config&amp;plugname=poll&amp;paction=edit&amp;id=<?php echo $row->id;?>"><i class="rounded inverted success icon pencil link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_PLG_PL_POLL;?>" data-option="deletePoll" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'question' . Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a></td>
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
    $('body').on('click', 'a.view-poll', function () {
        var id = $(this).data('id')
        var title = $(this).data('name');
        Messi.load('plugins/poll/controller.php', {
            viewPoll: 1,
            id: id
        }, {
            title: title
        });
    });
});
// ]]>
</script>
<?php break;?>
<?php endswitch;?>