<?php
  /**
   * AdBlock
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  if(!$user->getAcl("adblock")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
  
  Registry::set('AdBlock', new AdBlock());
?>
<?php switch(Filter::$maction): case "edit": ?>
<?php $row = Registry::get("AdBlock")->getSingle();?>
<?php $memberlevels = ($row->memberlevels) ? explode(',',$row->memberlevels):array(); ?>
<div class="wk icon heading message blue"> <a class="helper wk top right info corner label" data-help="adblock"><i class="icon help"></i></a> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_AB_TITLE4;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=adblock" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_AB_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_AB_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_MOD_AB_SUBTITLE1 . $row->{'title'.Lang::$lang};?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AB_NAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->{'title'.Lang::$lang};?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <div class="two fields">
            <div class="field">
              <label><?php echo Lang::$word->_MOD_AB_DATE_S;?></label>
              <label class="input"><i class="icon-append icon asterisk"></i>
                <input name="date_start" type="text" disabled="disabled" value="<?php echo $row->start_date;?>" readonly data-value="<?php echo $row->start_date;?>" data-datepicker="true">
              </label>
            </div>
            <div class="field">
              <label><?php echo Lang::$word->_MOD_AB_DATE_E;?></label>
              <label class="input"><i class="icon-append icon asterisk"></i>
                <input type="text" <?php if($row->end_date != "0000-00-00") echo 'data-value="' . $row->end_date . '"';?> value="<?php echo $row->end_date;?>" name="date_end">
              </label>
            </div>
          </div>
        </div>
      </div>
      <div class="four fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AB_MAX_VIEWS;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->total_views_allowed;?>" name="max_views">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AB_MAX_CLICKS;?></label>
          <label class="input">
            <input type="text" value="<?php echo $row->total_clicks_allowed;?>" name="max_clicks">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AB_MIN_CTR;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->minimum_ctr;?>" name="min_ctr">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AB_BLOCK_ASSIGNMENT;?></label>
          <label class="input">
            <input name="block_assignment" type="text" value="<?php echo $row->block_assignment;?>" readonly>
          </label>
        </div>
      </div>
      <div class="wk divider"></div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AB_ADVERTISEMENT_MEDIA;?></label>
          <div class="inline-group">
            <?php if($row->banner_image):?>
            <label class="radio">
              <input name="banner_type" type="radio" value="0" checked="checked">
              <i></i><?php echo Lang::$word->_MOD_AB_BANNER_IMAGE;?></label>
            <?php else:?>
            <label class="radio">
              <input name="banner_type" type="radio" value="1" checked="checked">
              <i></i><?php echo Lang::$word->_MOD_AB_BANNER_HTML;?></label>
            <?php endif;?>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_UR_LEVEL;?></label>
          <div class="inline-group">
            <label class="checkbox">
              <input name="userlevel[]" type="checkbox" value="9" <?php if(in_array(9,$memberlevels)):?>checked="checked"<?php endif;?>>
              <i></i><?php echo Lang::$word->_UR_SADMIN;?></label>
            <label class="checkbox">
              <input name="userlevel[]" type="checkbox" value="8" <?php if(in_array(8,$memberlevels)):?>checked="checked"<?php endif;?>>
              <i></i><?php echo Lang::$word->_UR_ADMIN;?></label>
            <label class="checkbox">
              <input name="userlevel[]" type="checkbox" value="1" <?php if(in_array(1,$memberlevels)):?>checked="checked"<?php endif;?>>
              <i></i><?php echo Lang::$word->_USER;?></label>
            <label class="checkbox">
              <input name="userlevel[]" type="checkbox" value="0" <?php if(in_array(0,$memberlevels)):?>checked="checked"<?php endif;?>>
              <i></i><?php echo Lang::$word->_GUEST;?></label>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <?php if($row->banner_image):?>
          <label><?php echo Lang::$word->_MOD_AB_BANNER_IMAGE;?></label>
          <label class="input">
            <input type="file" name="banner_image" class="filefield">
          </label>
          <div class="small-top-space"></div>
          <label><?php echo Lang::$word->_MOD_AB_BANNER_LINK;?></label>
          <label class="input">
            <input type="text" value="<?php echo $row->banner_image_link;?>" name="banner_image_link">
          </label>
          <div class="small-top-space"></div>
          <label><?php echo Lang::$word->_MOD_AB_BANNER_ALT;?></label>
          <label class="input">
            <input type="text" value="<?php echo $row->banner_image_alt;?>" name="banner_image_alt">
          </label>
          <?php else:?>
          <label><?php echo Lang::$word->_MOD_AB_BANNER_HTML2;?></label>
          <textarea name="banner_html"><?php echo $row->banner_html?></textarea>
          <?php endif;?>
        </div>
        <div class="field">
          <?php if($row->banner_image):?>
          <img src="<?php echo  SITEURL . '/' . AdBlock::imagepath . $row->banner_image;?>" class="wk image small">
          <?php endif;?>
        </div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_MOD_AB_EDIT;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=adblock" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="processAdBlock" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<script type="text/javascript"> 
// <![CDATA[
  $(document).ready(function(){
    $('input[name=date_end]').pickadate({
        formatSubmit: 'yyyy-mm-dd',
		min: $.now(),
    });
  });
// ]]>
</script>
<?php break;?>
<?php case"add": ?>
<div class="wk icon heading message blue"> <a class="helper wk top right info corner label" data-help="adblock"><i class="icon help"></i></a> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_AB_TITLE4;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=adblock" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_AB_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_AB_INFO2. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_MOD_AB_SUBTITLE2;?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AB_NAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_AB_NAME;?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <div class="two fields">
            <div class="field">
              <label><?php echo Lang::$word->_MOD_AB_DATE_S;?></label>
              <label class="input"><i class="icon-append icon asterisk"></i>
                <input type="text" data-value="<?php echo date('Y-m-d');?>" name="date_start">
              </label>
            </div>
            <div class="field">
              <label><?php echo Lang::$word->_MOD_AB_DATE_E;?></label>
              <label class="input"><i class="icon-append icon asterisk"></i>
                <input type="text" name="date_end">
              </label>
            </div>
          </div>
        </div>
      </div>
      <div class="four fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AB_MAX_VIEWS;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_AB_MAX_VIEWS;?>" name="max_views">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AB_MAX_CLICKS;?></label>
          <label class="input">
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_AB_MAX_CLICKS;?>" name="max_clicks">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AB_MIN_CTR;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_AB_MIN_CTR;?>" name="min_ctr">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AB_BLOCK_ASSIGNMENT;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input name="block_assignment" type="text" placeholder="<?php echo Lang::$word->_MOD_AB_BLOCK_ASSIGNMENT;?>">
          </label>
        </div>
      </div>
      <div class="wk divider"></div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AB_ADVERTISEMENT_MEDIA;?></label>
          <div class="inline-group">
            <label class="radio">
              <input id="show_banner_image" name="banner_type" type="radio" value="0" checked="checked">
              <i></i><?php echo Lang::$word->_MOD_AB_BANNER_IMAGE;?></label>
            <label class="radio">
              <input id="show_banner_html" name="banner_type" type="radio" value="1">
              <i></i><?php echo Lang::$word->_MOD_AB_BANNER_HTML;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_UR_LEVEL;?></label>
          <div class="inline-group">
            <label class="checkbox">
              <input name="userlevel[]" type="checkbox" value="9">
              <i></i><?php echo Lang::$word->_UR_SADMIN;?></label>
            <label class="checkbox">
              <input name="userlevel[]" type="checkbox" value="8" >
              <i></i><?php echo Lang::$word->_UR_ADMIN;?></label>
            <label class="checkbox">
              <input name="userlevel[]" type="checkbox" value="1">
              <i></i><?php echo Lang::$word->_USER;?></label>
            <label class="checkbox">
              <input name="userlevel[]" type="checkbox" value="0">
              <i></i><?php echo Lang::$word->_GUEST;?></label>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field" id="banner_image">
          <label><?php echo Lang::$word->_MOD_AB_BANNER_IMAGE;?></label>
          <label class="input">
            <input type="file" name="banner_image" class="filefield">
          </label>
          <div class="small-top-space"></div>
          <label><?php echo Lang::$word->_MOD_AB_BANNER_LINK;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_AB_BANNER_IMAGE;?>" name="banner_image_link">
          </label>
          <div class="small-top-space"></div>
          <label><?php echo Lang::$word->_MOD_AB_BANNER_ALT;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_AB_BANNER_ALT;?>" name="banner_image_alt">
          </label>
        </div>
        <div class="field" id="banner_html" style="display:none">
          <label><?php echo Lang::$word->_MOD_AB_BANNER_HTML2;?></label>
          <label class="textarea"><i class="icon-append icon asterisk"></i>
          <textarea placeholder="<?php echo Lang::$word->_MOD_AB_BANNER_HTML2;?>" name="banner_html"></textarea>
          </label>
        </div>
        <div class="field">&nbsp;</div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_MOD_AB_ADD;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=adblock" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processAdBlock" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    $('input[name=date_end],input[name=date_start]').pickadate({
        formatSubmit: 'yyyy-mm-dd',
        min: $.now(),
    });
    $('#show_banner_image').click(function () {
        $('#banner_html').hide();
        $('#banner_image').show();

    });
    $('#show_banner_html').click(function () {
        $('#banner_html').show();
        $('#banner_image').hide();
    });
});
// ]]>
</script>
<?php break;?>
<?php default: ?>
<?php $adrow = Registry::get("AdBlock")->getAdBlock();?>
<div class="wk icon heading message blue"> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_AB_TITLE4;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo $content->getModuleName(Filter::$modname);?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_AB_INFO4;?></div>
  <div class="wk segment"> <a class="wk icon warning button push-right" href="<?php echo Core::url("modules", "add");?>"><i class="icon add"></i> <?php echo Lang::$word->_MOD_AB_ADD;?></a>
    <div class="wk header"><?php echo Lang::$word->_MOD_AB_SUBTITLE3;?></div>
    <div class="wk fitted divider"></div>
    <table class="wk sortable table">
      <thead>
        <tr>
          <th data-sort="int">#</th>
          <th data-sort="int"><?php echo Lang::$word->_MOD_AB_NAME;?></th>
          <th class="left sortable"><?php echo Lang::$word->_CREATED;?></th>
          <th data-sort="string"><?php echo Lang::$word->_MOD_AB_IS_ONLINE;?></th>
          <th data-sort="string"><?php echo Lang::$word->_MOD_AB_BLOCK_ASSIGNMENT;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$adrow):?>
        <tr>
          <td colspan="6"><?php echo Filter::msgSingleAlert(Lang::$word->_MOD_AB_NOADBLOCKS);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($adrow as $row):?>
        <tr>
          <td><?php echo $row->id;?>.</td>
          <td><?php echo $row->{'title'.Lang::$lang};?></td>
          <td data-sort-value="<?php echo strtotime($row->created);?>"><?php echo $row->created;?></td>
          <td><?php echo $row->is_online_str;?></td>
          <td><?php echo $row->block_assignment;?></td>
          <td><a href="<?php echo Core::url("modules", "edit", $row->id);?>"><i class="rounded inverted success icon pencil link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_MOD_AB_ADBLOCK;?>" data-option="deleteAdBlock" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title' . Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a></td>
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