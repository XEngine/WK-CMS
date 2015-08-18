<?php
  /**
   * Admin
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  if(!$user->getAcl("comments")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;

  Registry::set('Comments', new Comments());
?>
<?php switch(Filter::$maction): case "config": ?>
<?php $row = Registry::get("Comments");?>
<div class="wk icon heading message blue"> <a class="helper wk top right info corner label" data-help="comments"><i class="icon help"></i></a> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_CM_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=comments" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_CM_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_CM_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_MOD_CM_SUBTITLE1;?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_CM_SORTING;?></label>
          <select name="sorting">
            <option value="DESC"<?php if($row->sorting == "DESC") echo ' selected="selected"';?>><?php echo Lang::$word->_MOD_CM_SORTING_T;?></option>
            <option value="ASC"<?php if($row->sorting == "ASC") echo ' selected="selected"';?>><?php echo Lang::$word->_MOD_CM_SORTING_B;?></option>
          </select>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_CM_DATE;?></label>
          <select name="dateformat" >
            <?php echo Comments::getDateFormat($row->dateformat);?>
          </select>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_CM_CHAR;?></label>
          <label class="input">
            <input type="text" value="<?php echo $row->char_limit;?>" name="char_limit">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_CM_PERPAGE;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->perpage;?>" name="perpage">
          </label>
        </div>
      </div>
      <div class="wk divider"></div>
      <div class="four fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_CM_UNAME_R;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="username_req" type="radio" value="1" <?php echo getChecked($row->username_req, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="username_req" type="radio" value="0" <?php echo getChecked($row->username_req, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_CM_EMAIL_R;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="email_req" type="radio" value="1" <?php echo getChecked($row->email_req, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="email_req" type="radio" value="0" <?php echo getChecked($row->email_req, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_CM_CAPTCHA;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="show_captcha" type="radio" value="1" <?php echo getChecked($row->show_captcha, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="show_captcha" type="radio" value="0" <?php echo getChecked($row->show_captcha, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_CM_WWW;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="show_www" type="radio" value="1" <?php echo getChecked($row->show_www, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="show_www" type="radio" value="0" <?php echo getChecked($row->show_www, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="four fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_CM_UNAME_S;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="show_username" type="radio" value="1" <?php echo getChecked($row->show_username, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="show_username" type="radio" value="0" <?php echo getChecked($row->show_username, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_CM_EMAIL_S;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="show_email" type="radio" value="1" <?php echo getChecked($row->show_email, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="show_email" type="radio" value="0" <?php echo getChecked($row->show_email, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_CM_REG_ONLY;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="public_access" type="radio" value="1" <?php echo getChecked($row->public_access, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="public_access" type="radio" value="0" <?php echo getChecked($row->public_access, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_CM_AA;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="auto_approve" type="radio" value="1" <?php echo getChecked($row->auto_approve, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="auto_approve" type="radio" value="0" <?php echo getChecked($row->auto_approve, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="wk divider"></div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_CM_NOTIFY;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="notify_new" type="radio" value="1" <?php echo getChecked($row->notify_new, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="notify_new" type="radio" value="0" <?php echo getChecked($row->notify_new, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_CM_WORDS;?></label>
          <textarea name="blacklist_words"><?php echo $row->blacklist_words;?></textarea>
        </div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_MOD_CM_UPDATE_B;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=comments" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processConfig" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php default: ?>
<?php $commentrow = Registry::get("Comments")->getComments();?>
<div class="wk icon heading message blue"> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_CM_TITLE3;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo $content->getModuleName(Filter::$modname);?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_CM_INFO3;?></div>
  <div class="wk segment"> <a class="wk icon warning button push-right" href="<?php echo Core::url("modules", "config");?>"><i class="icon add"></i> <?php echo Lang::$word->_MOD_CM_CONFIG;?></a>
    <div class="wk header"><?php echo Lang::$word->_MOD_CM_SUBTITLE3;?></div>
    <div class="wk fitted divider"></div>
    <div class="wk small form basic segment">
      <form method="post" id="wk_form" name="wk_form">
        <div class="four fields">
          <div class="field">
            <div class="wk input"> <i class="icon-prepend icon calendar"></i>
              <input name="fromdate" type="text" data-datepicker="true" placeholder="<?php echo Lang::$word->_MOD_CM_SHOWFROM;?>" id="fromdate" />
            </div>
          </div>
          <div class="field">
            <div class="wk action input"> <i class="icon-prepend icon calendar"></i>
              <input name="enddate" type="text" data-datepicker="true" placeholder="<?php echo Lang::$word->_MOD_CM_SHOWTO;?>" id="enddate" />
              <a id="doDates" class="wk icon button"><?php echo Lang::$word->_GO;?></a> </div>
          </div>
          <div class="field"> <?php echo $pager->items_per_page();?> </div>
          <div class="field"> <?php echo $pager->jump_menu();?> </div>
        </div>
      </form>
      <div class="wk fitted divider"></div>
    </div>
    <form method="post" id="admin_form" name="admin_form">
      <table class="wk sortable table">
        <thead>
          <tr>
            <th class="disabled"> <label class="checkbox">
                <input type="checkbox" name="masterCheckbox" id="masterCheckbox">
                <i></i></label>
            </th>
            <th data-sort="string"><?php echo Lang::$word->_MOD_CM_UNAME;?></th>
            <th data-sort="string"><?php echo Lang::$word->_MOD_CM_EMAIL;?></th>
            <th data-sort="int"><?php echo Lang::$word->_MOD_CM_CREATED;?></th>
            <th data-sort="string"><?php echo Lang::$word->_MOD_CM_PNAME;?></th>
            <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
          </tr>
        </thead>
        <?php if($commentrow):?>
        <tfoot>
          <tr>
            <td colspan="6"><div class="wk small buttons">
                <button type="submit" name="approve" class="wk positive button"><i class="add icon"></i> <?php echo Lang::$word->_MOD_CM_APPROVE;?></button>
                <button type="submit" name="disapprove" class="wk warning button"><i class="minus icon"></i> <?php echo Lang::$word->_MOD_CM_DISAPPROVE;?></button>
                <button type="submit" name="delete" class="wk negative button"><i class="remove icon"></i><?php echo Lang::$word->_DELETE;?></button>
              </div></td>
          </tr>
        </tfoot>
        <?php endif;?>
        <tbody>
          <?php if(!$commentrow):?>
          <tr>
            <td colspan="6"><?php echo Filter::msgSingleAlert(Lang::$word->_MOD_CM_NONCOMMENTS);?></td>
          </tr>
          <?php else:?>
          <?php foreach ($commentrow as $row):?>
          <tr>
            <td class="hide-tablet"><label class="checkbox">
                <input name="comid[<?php echo $row->cid;?>]" type="checkbox" value="<?php echo $row->cid;?>">
                <i></i></label></td>
            <td><?php echo $row->username;?></td>
            <td><?php echo $row->email;?></td>
            <td data-sort-value="<?php echo strtotime($row->created);?>"><?php echo Filter::dodate("long_date", $row->created);?></td>
            <td><a href="index.php?do=pages&amp;action=edit&amp;id=<?php echo $row->id;?>"><?php echo $row->title;?></a></td>
            <td><?php echo isActive($row->active);?> <a data-username="<?php echo $row->username;?>" class="viewcomment" data-id="<?php echo $row->cid;?>"><i class="rounded success inverted laptop icon link"></i></a></td>
          </tr>
          <?php endforeach;?>
          <?php unset($row);?>
          <?php endif;?>
        </tbody>
      </table>
    </form>
  </div>
  <div id="msgholder"></div>
  <div class="wk-grid">
    <div class="two columns horizontal-gutters">
      <div class="row"> <span class="wk label"><?php echo Lang::$word->_PAG_TOTAL.': '.$pager->items_total;?> / <?php echo Lang::$word->_PAG_CURPAGE.': '.$pager->current_page.' '.Lang::$word->_PAG_OF.' '.$pager->num_pages;?></span> </div>
      <div class="row">
        <div id="pagination"><?php echo $pager->display_pages();?></div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
    $("button[type=submit]").on("click", function () {
        var action = $(this).prop("name");
        var str = $("#admin_form").serialize();
        str += '&comproccess=1';
        str += '&action=' + action;
        $.ajax({
            type: "post",
            url: 'modules/comments/controller.php',
			dataType: 'json',
            data: str,
            success: function (json) {
                $(".wk.sortable.table tbody tr").each(function () {
                    if ($(this).find("input:checked").length) {
                        if (action == "delete") {
                            $(this).fadeOut(400, function () {
                                $(this).remove();
                            });
                        } else {
                            $(this).addClass('warning');
                        }
                    }
                });
                $("#msgholder").html(json.message);
            }
        });
        return false;
    });
	
    $('a.viewcomment').on('click', function () {
        var id = $(this).data('id')
        var title = $(this).data('username');
		var $parent = $(this).closest('tr')

        Messi.load('modules/comments/controller.php', {
            loadComment: 1,
            id: id,
        }, {
            title: '<?php echo Lang::$word->_MOD_CM_VIEW_P;?>' + title,
            buttons: [{
                id: 0,
                'label': '<?php echo Lang::$word->_SUBMIT;?>',
                'class': 'positive',
                'val': 'Y'
            }],
            callback: function (val) {
                $.ajax({
                    type: 'post',
                    url: 'modules/comments/controller.php',
                    dataType: 'json',
                    data: {
                        processComment: 1,
                        id: id,
                        content: $("#bodyid").val()
                    },
                    beforeSend: function () {},
                    success: function (json) {
						$($parent).addClass('warning');
						console.log($parent)
                        $.sticky(decodeURIComponent(json.message), {
                            type: json.type,
                            title: json.title
                        });
                    }
                });
            }
        });
    });

    $('#masterCheckbox').click(function (e) {
        var $checkBoxes = $("input[type=checkbox]");
        $($checkBoxes).prop("checked", $(this).prop("checked"))
    });
});
// ]]>
</script>
<?php break;?>
<?php endswitch;?>