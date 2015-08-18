<?php
  /**
   * Portfolio
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  if(!$user->getAcl("portfolio")): print $core->msgAlert(_CG_ONLYADMIN, false); return; endif;
  
  Registry::set('Portfolio', new Portfolio());
?>
<?php switch(Filter::$maction): case "edit": ?>
<?php $row = Core::getRowById(Portfolio::mTable, Filter::$id);?>
<?php $catrow = Registry::get("Portfolio")->getCategories();?>
<div class="wk icon heading message blue"> <a class="helper wk top right info corner label" data-help="portfolio"><i class="icon help"></i></a> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_PF_TITLE4;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=portfolio" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_PF_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_PF_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_MOD_PF_SUBTITLE1 . $row->{'title'.Lang::$lang};?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_NAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->{'title'.Lang::$lang};?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_SLUG;?></label>
          <label class="input">
            <input type="text" value="<?php echo $row->slug;?>" name="slug">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_CATEGORY;?></label>
          <select name="cid">
            <option value=""><?php echo Lang::$word->_MOD_PF_CATEGORY_SEL;?></option>
            <?php if($catrow):?>
            <?php foreach($catrow as $crow):?>
            <?php $sel = ($crow->id == $row->cid) ? ' selected="selected"' : '' ;?>
            <option value="<?php echo $crow->id;?>"<?php echo $sel;?>><?php echo $crow->{'title'.LANG::$lang};?></option>
            <?php endforeach;?>
            <?php unset($crow);?>
            <?php endif;?>
          </select>
        </div>
        <div class="field">
          <?php $module_data = $row->gallery;?>
          <?php include(BASEPATH . "admin/modules/gallery/config.php");?>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_PIMAGE;?></label>
          <label class="input">
            <input type="file" name="thumb" class="filefield">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_PIMAGEPP;?></label>
          <div class="wk small image"> <a class="lightbox" href="<?php echo SITEURL . '/' . Portfolio::imagepath . $row->thumb;?>"><img src="<?php echo SITEURL . '/' . Portfolio::imagepath . $row->thumb;?>" alt="<?php echo $row->thumb;?>"></a> </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_RWEB;?></label>
          <label class="input">
            <input type="text" value="<?php echo $row->www;?>" name="www">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_CREATED;?></label>
          <label class="input"><i class="icon-append icon calendar"></i>
            <input data-datepicker="true" data-value="<?php echo $row->created;?>" type="text" value="<?php echo $row->created;?>" name="created">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_RLOC;?></label>
          <label class="input">
            <input type="text" value="<?php echo $row->location;?>" name="location">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_RCLIENT;?></label>
          <label class="input">
            <input type="text" value="<?php echo $row->client;?>" name="client">
          </label>
        </div>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_MOD_PF_SHORTDESC;?></label>
        <textarea name="short_desc<?php echo LANG::$lang;?>"><?php echo $row->{'short_desc'.Lang::$lang};?></textarea>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_MOD_PF_PSTUDY;?></label>
        <textarea id="plugpost" class="plugpost" name="detail<?php echo Lang::$lang;?>"><?php echo Filter::out_url($row->{'detail'.Lang::$lang});?></textarea>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_MOD_PF_PAPPROACH;?></label>
        <textarea id="plugpost2" class="plugpost" name="body<?php echo LANG::$lang;?>"><?php echo Filter::out_url($row->{'body'.Lang::$lang});?></textarea>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_MOD_PF_RESULTS;?></label>
        <textarea id="plugpost3" class="plugpost" name="result<?php echo Lang::$lang;?>"><?php echo Filter::out_url($row->{'result'.Lang::$lang});?></textarea>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_METAKEYS;?></label>
          <textarea name="metakey<?php echo Lang::$lang;?>"><?php echo $row->{'metakey'.Lang::$lang};?></textarea>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_METADESC;?></label>
          <textarea name="metadesc<?php echo Lang::$lang;?>"><?php echo $row->{'metadesc'.Lang::$lang};?></textarea>
        </div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_MOD_PF_UPDATE;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=portfolio" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="processFolio" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"add": ?>
<?php $catrow = Registry::get("Portfolio")->getCategories();?>
<div class="wk icon heading message blue"> <a class="helper wk top right info corner label" data-help="portfolio"><i class="icon help"></i></a> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_PF_TITLE4;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=portfolio" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_PF_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_PF_INFO2. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_MOD_PF_SUBTITLE2;?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_NAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_PF_NAME;?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_SLUG;?></label>
          <label class="input">
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_PF_SLUG;?>" name="slug">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_CATEGORY;?></label>
          <select name="cid">
            <option value=""><?php echo Lang::$word->_MOD_PF_CATEGORY_SEL;?></option>
            <?php if($catrow):?>
            <?php foreach($catrow as $crow):?>
            <option value="<?php echo $crow->id;?>"><?php echo $crow->{'title'.LANG::$lang};?></option>
            <?php endforeach;?>
            <?php unset($crow);?>
            <?php endif;?>
          </select>
        </div>
        <div class="field">
          <?php $module_data = 0;?>
          <?php include(BASEPATH . "admin/modules/gallery/config.php");?>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_PIMAGE;?></label>
          <label class="input">
            <input type="file" name="thumb" class="filefield">
          </label>
        </div>
        <div class="field">&nbsp;</div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_RWEB;?></label>
          <label class="input">
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_PF_RWEB;?>" name="www">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_CREATED;?></label>
          <label class="input"><i class="icon-append icon calendar"></i>
            <input data-datepicker="true" data-value="<?php echo date('Y-m-d');?>" type="text" value="<?php echo date('Y-m-d');?>" name="created">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_RLOC;?></label>
          <label class="input">
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_PF_RLOC;?>" name="location">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_RCLIENT;?></label>
          <label class="input">
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_PF_RCLIENT;?>" name="client">
          </label>
        </div>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_MOD_PF_SHORTDESC;?></label>
        <label class="textarea"><i class="icon-append icon asterisk"></i>
          <textarea placeholder="<?php echo Lang::$word->_MOD_PF_SHORTDESC;?>" name="short_desc<?php echo LANG::$lang;?>"></textarea>
        </label>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_MOD_PF_PSTUDY;?></label>
        <textarea id="plugpost" placeholder="<?php echo Lang::$word->_MOD_PF_PSTUDY;?>" class="plugpost" name="detail<?php echo Lang::$lang;?>"></textarea>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_MOD_PF_PAPPROACH;?></label>
        <textarea id="plugpost2" placeholder="<?php echo Lang::$word->_MOD_PF_PAPPROACH;?>" class="plugpost" name="body<?php echo LANG::$lang;?>"></textarea>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_MOD_PF_RESULTS;?></label>
        <textarea id="plugpost3" placeholder="<?php echo Lang::$word->_MOD_PF_RESULTS;?>" class="plugpost" name="result<?php echo Lang::$lang;?>"></textarea>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_METAKEYS;?></label>
          <textarea placeholder="<?php echo Lang::$word->_METAKEYS;?>" name="metakey<?php echo Lang::$lang;?>"></textarea>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_METADESC;?></label>
          <textarea placeholder="<?php echo Lang::$word->_METADESC;?>" name="metadesc<?php echo Lang::$lang;?>"></textarea>
        </div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_MOD_PF_ADD;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=portfolio" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processFolio" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"config": ?>
<?php $row = Registry::get("Portfolio");?>
<div class="wk icon heading message blue"> <a class="helper wk top right info corner label" data-help="pfconfig"><i class="icon help"></i></a> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_PF_TITLE4;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=portfolio" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_PF_TITLE3;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_PF_INFO3. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_MOD_PF_SUBTITLE8;?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_COLS;?></label>
          <label class="input">
            <input type="text" class="slrange" value="<?php echo $row->cols;?>" name="cols">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_ITEMPP;?></label>
          <label class="input">
            <input type="text" class="slrange" value="<?php echo $row->ipp;?>" name="ipp">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_ITEMPPF;?></label>
          <label class="input">
            <input type="text" class="slrange" value="<?php echo $row->fpp;?>" name="fpp">
          </label>
        </div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_MOD_PF_UPDATEC;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=portfolio" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processConfig" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    $("input[name=cols]").ionRangeSlider({
		min: 2,
		max: 6,
        step: 1,
		postfix: " col",
        type: 'single',
        hasGrid: true
    });
	
    $("input[name=ipp], input[name=fpp]").ionRangeSlider({
		min: 5,
		max: 20,
        step: 1,
		postfix: " itm",
        type: 'single',
        hasGrid: true
    });
});
// ]]>
</script>
<?php break;?>
<?php case"category": ?>
<?php $catrow = Registry::get("Portfolio")->getCategories();?>
<div class="wk icon heading message blue"> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_PF_TITLE4;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=portfolio" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_PF_TITLE5;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_PF_INFO5;?></div>
  <div class="wk segment"> <a class="wk icon warning button push-right" href="<?php echo Core::url("modules", "catadd");?>"><i class="icon add"></i> <?php echo Lang::$word->_MOD_PF_CADD;?></a>
    <div class="wk header"><?php echo Lang::$word->_MOD_PF_SUBTITLE5;?></div>
    <div class="wk fitted divider"></div>
    <table class="wk sortable table">
      <thead>
        <tr>
          <th class="disabled"></th>
          <th class="left"><?php echo Lang::$word->_MOD_PF_CATNAME;?></th>
          <th><?php echo Lang::$word->_MOD_PF_POS;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$catrow):?>
        <tr>
          <td colspan="4"><?php echo Filter::msgSingleAlert(Lang::$word->_MOD_PF_NOCATS);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($catrow as $row):?>
        <tr id="node-<?php echo $row->id;?>">
          <td class="id-handle"><i class="icon reorder"></i></td>
          <td data-sort="string"><?php echo $row->{'title'.Lang::$lang};?></td>
          <td data-sort="int"><span class="wk black label"><?php echo $row->position;?></span></td>
          <td><a href="<?php echo Core::url("modules", "catedit", $row->id);?>"><i class="rounded inverted success icon pencil link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_MOD_PF_CATEGORY;?>" data-option="deleteCategory" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title'.Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a></td>
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
    $(".wk.table tbody").sortable({
        helper: 'clone',
        handle: '.id-handle',
        placeholder: 'placeholder',
        opacity: .6,
        update: function (event, ui) {
            serialized = $(".wk.table tbody").sortable('serialize');
            $.ajax({
                type: "POST",
                url: "modules/portfolio/controller.php?sortcats",
                data: serialized,
                success: function (msg) {}
            });
        }
    });
});
// ]]>
</script>
<?php break;?>
<?php case"catedit": ?>
<?php $row = Core::getRowById(Portfolio::cTable, Filter::$id);?>
<div class="wk icon heading message blue"> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_PF_TITLE4;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=portfolio" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <a href="<?php echo Core::url("modules", "category");?>" class="section"><?php echo Lang::$word->_MOD_PF_TITLE5;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_PF_TITLE6;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_PF_INFO6. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_MOD_PF_SUBTITLE6 . $row->{'title'.Lang::$lang};?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_CATNAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->{'title'.Lang::$lang};?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_CATSLUG;?></label>
          <input type="text" value="<?php echo $row->slug;?>" name="slug">
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_METAKEYS;?></label>
          <textarea name="metakey<?php echo Lang::$lang;?>"><?php echo $row->{'metakey'.Lang::$lang};?></textarea>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_METADESC;?></label>
          <textarea name="metadesc<?php echo Lang::$lang;?>"><?php echo $row->{'metadesc'.Lang::$lang};?></textarea>
        </div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_MOD_PF_CAUPDATE;?></button>
      <a href="<?php echo Core::url("modules", "category");?>" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="processCategory" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"catadd": ?>
<div class="wk icon heading message blue"> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_PF_TITLE4;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=portfolio" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <a href="<?php echo Core::url("modules", "category");?>" class="section"><?php echo Lang::$word->_MOD_PF_TITLE5;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_PF_TITLE7;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_PF_INFO7. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_MOD_PF_SUBTITLE7;?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_CATNAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_PF_CATNAME;?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_CATSLUG;?></label>
          <input type="text" placeholder="<?php echo Lang::$word->_MOD_PF_CATSLUG;?>" name="slug">
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_METAKEYS;?></label>
          <textarea placeholder="<?php echo Lang::$word->_METAKEYS;?>" name="metakey<?php echo Lang::$lang;?>"></textarea>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_METADESC;?></label>
          <textarea placeholder="<?php echo Lang::$word->_METADESC;?>" name="metadesc<?php echo Lang::$lang;?>"></textarea>
        </div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_MOD_PF_CADD;?></button>
      <a href="<?php echo Core::url("modules", "category");?>" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processCategory" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php default: ?>
<?php $portrow = Registry::get("Portfolio")->getPortfolio();?>
<?php $catrow = Registry::get("Portfolio")->getCategories();?>
<div class="wk icon heading message blue"> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_PF_TITLE4;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo $content->getModuleName(Filter::$modname);?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_PF_INFO4;?></div>
  <div class="wk segment">
    <div class="push-right">
      <div class="wk right pointing dropdown icon info button"> <i class="settings icon"></i>
        <div class="menu"> <a class="item" href="<?php echo Core::url("modules", "add");?>"><i class="icon add"></i><?php echo Lang::$word->_MOD_PF_SUBTITLE4;?></a> <a class="item" href="<?php echo Core::url("modules", "category");?>"><i class="icon add"></i><?php echo Lang::$word->_MOD_PF_CATEGORIES;?></a> <a class="item" href="<?php echo Core::url("modules", "config");?>"><i class="icon setting"></i><?php echo Lang::$word->_MOD_PF_CONFIGURE;?></a> </div>
      </div>
    </div>
    <div class="wk header"><?php echo Lang::$word->_MOD_PF_SUBTITLE3;?></div>
    <div class="wk fitted divider"></div>
    <table class="wk sortable table">
      <thead>
        <tr>
          <th class="disabled"><i class="icon photo"></i></th>
          <th data-sort="string"><?php echo Lang::$word->_MOD_PF_NAME;?></th>
          <th data-sort="string"><?php echo Lang::$word->_MOD_PF_CATEGORY;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$portrow):?>
        <tr>
          <td colspan="4"><?php echo Filter::msgSingleAlert(Lang::$word->_MOD_PF_NOPROJECTS);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($portrow as $row):?>
        <tr>
          <td><a class="lightbox" href="<?php echo SITEURL . '/' . Portfolio::imagepath . $row->thumb;?>" title="<?php echo $row->{'title'.LANG::$lang};?>"> <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL . '/' . Portfolio::imagepath . $row->thumb;?>&amp;w=120&amp;h=60" alt="" class="wk image"></a></td>
          <td><?php echo $row->{'title'.LANG::$lang};?></td>
          <td><a class="item" href="<?php echo Core::url("modules", "catedit", $row->cid);?>"><?php echo $row->catname;?></a></td>
          <td><a href="<?php echo Core::url("modules", "edit", $row->id);?>"><i class="rounded inverted success icon pencil link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_MOD_PF_PROJECT;?>" data-option="deleteProject" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title' . Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a></td>
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