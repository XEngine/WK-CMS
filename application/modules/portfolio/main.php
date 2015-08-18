<?php
  /**
   * Portfolio Main
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  require_once (MODPATH . "portfolio/admin_class.php");
  $classname = 'Portfolio';
  try {
	  if (!class_exists($classname)) {
		  throw new exception('Missing digishop/admin_class.php');
	  }
	  Registry::set('Portfolio', new Portfolio());
  }
  catch (exception $e) {
	  echo $e->getMessage();
  }
  
  $length = count($content->_url);
?>
<?php switch($length): case 3: ?>
<?php $catrow = Registry::get("Portfolio")->renderCategory($content->moduledata->mod->id);?>
<?php if(!$catrow):?>
<?php echo Filter::msgSingleAlert(Lang::$word->_MOD_PF_NOPROJECTS);?>
<?php else:?>
<h1 class="wk double header"><span><?php echo Lang::$word->_MOD_PF_ALL_PROJECTS;?> / <?php echo $content->moduledata->mod->{'title' . Lang::$lang};?></span></h1>
<?php $catsrow = Registry::get("Portfolio")->getCategories();?>
<?php if($catsrow):?>
<div class="wk buttons"> <a href="<?php echo Url::Portfolio("portfolio");?>" class="wk black button"><span><?php echo Lang::$word->_MOD_PF_ALL;?></span></a>
  <?php foreach($catsrow as $fcrow):?>
  <a class="wk <?php echo ($content->_url[2] == $fcrow->slug)? "warning" : "black";?> button" href="<?php echo Url::Portfolio("portfolio-cat", $fcrow->slug);?>" data-category="<?php echo $fcrow->id;?>"><?php echo $fcrow->{'title'.Lang::$lang};?></a>
  <?php endforeach;?>
</div>
<?php endif;?>
<div class="wk section divider"></div>
<div id="foliowrap" class="clearfix">
  <?php foreach($catrow as $row):?>
  <div class="item">
    <section>
      <div class="image-overlay"> <img src="<?php echo SITEURL.'/'.Portfolio::imagepath . $row->thumb;?>" alt="">
        <div class="overlay-fade"> <a href="<?php echo Url::Portfolio("item", $row->slug);?>"><i class="icon-overlay icon url"></i></a> </div>
      </div>
      <h4><?php echo $row->{'title' . Lang::$lang};?> </h4>
      <p><?php echo cleanSanitize($row->{'short_desc' . Lang::$lang});?></p>
    </section>
  </div>
  <?php endforeach;?>
</div>
<?php endif;?>
<div id="pagination" class="content-center"><?php echo $pager->display_pages();?></div>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
	$('#foliowrap').waitForImages(function () {
		$('#foliowrap').Grid({
			inner: 3,
			outer: 0,
			cols: Math.round(1200 / <?php echo Registry::get("Portfolio")->cols;?>)
		});
	});
});
// ]]>
</script>
<?php break;?>
<?php case 2: ?>
<?php $row = $content->moduledata->mod;?>
<h1 class="wk double header"><span><?php echo Lang::$word->_MOD_PF_V_ITEM . $row->{'title' . Lang::$lang};?></span></h1>
<div id="folio-single">
  <div class="columns gutters">
    <div class="screen-50 tablet-50 pfone-100">
      <?php if($row->gallery):?>
      <?php include(MODPATHF . "/portfolio/gallery.tpl.php");?>
      <?php else:?>
      <div class="pitem">
        <div class="image-overlay"> <img src="<?php echo SITEURL.'/'.Portfolio::imagepath . $row->thumb;?>" alt="">
          <div class="overlay-fade"> <a title="<?php echo $row->{'title' . Lang::$lang};?>" href="<?php echo SITEURL.'/'.Portfolio::imagepath . $row->thumb;?>" class="lightbox"><i class="icon-overlay icon url"></i></a> </div>
        </div>
      </div>
      <?php endif;?>
    </div>
    <div class="screen-50 tablet-50 pfone-100"> <?php echo cleanOut($row->{'short_desc'.Lang::$lang});?>
      <div class="wk section divider"></div>
      <h4 class="wk header"> <?php echo Lang::$word->_MOD_PF_KEY;?></h4>
      <div class="wk divided list">
        <div class="item"> <i class="globe icon"></i>
          <div class="content">
            <div class="header"><?php echo Lang::$word->_MOD_PF_RWEB;?></div>
            <div class="description"><?php echo $row->www;?></div>
          </div>
        </div>
        <div class="item"> <i class="calendar icon"></i>
          <div class="content">
            <div class="header"><?php echo Lang::$word->_MOD_PF_RDATE;?></div>
            <div class="description"><?php echo Filter::doDate("short_date", $row->created);?></div>
          </div>
        </div>
        <div class="item"> <i class="user icon"></i>
          <div class="content">
            <div class="header"><?php echo Lang::$word->_MOD_PF_RCLIENT;?></div>
            <div class="description"><?php echo $row->client;?></div>
          </div>
        </div>
        <div class="item"> <i class="building icon"></i>
          <div class="content">
            <div class="header"><?php echo Lang::$word->_MOD_PF_RLOC;?></div>
            <div class="description"><?php echo $row->location;?></div>
          </div>
        </div>
      </div>
      <a href="<?php echo Url::Portfolio("portfolio");?>" class="wk info labeled icon button"><i class="left arrow icon"></i><?php echo Lang::$word->_MOD_PF_BACK;?></a> </div>
  </div>
  <div id="pftabs" class="wtabs">
    <ul class="wk tabs">
      <li><a data-tab="#tab1"><?php echo Lang::$word->_MOD_PF_PSTUDY;?></a></li>
      <li><a data-tab="#tab2"><?php echo Lang::$word->_MOD_PF_PAPPROACH;?></a></li>
      <li><a data-tab="#tab3"><?php echo Lang::$word->_MOD_PF_RESULTS;?></a></li>
    </ul>
    <div id="tab1" class="wk tab content"> <?php echo cleanOut($row->{'detail'.Lang::$lang});?> </div>
    <div id="tab2" class="wk tab content"> <?php echo cleanOut($row->{'body'.Lang::$lang});?> </div>
    <div id="tab3" class="wk tab content"> <?php echo cleanOut($row->{'result'.Lang::$lang});?> </div>
  </div>
</div>
<?php break;?>
<?php default: ?>
<?php $portadata = Registry::get("Portfolio")->renderPortfolio();?>
<?php $catrow = Registry::get("Portfolio")->getCategories();?>
<h1 class="wk double header"><span><?php echo Lang::$word->_MOD_PF_ALL_PROJECTS;?></span></h1>
<?php if($catrow):?>
<div class="wk buttons"> <a class="wk warning button"><span><?php echo Lang::$word->_MOD_PF_ALL;?></span></a>
  <?php foreach($catrow as $fcrow):?>
  <a class="wk black button" href="<?php echo Url::Portfolio("portfolio-cat", $fcrow->slug);?>" data-category="<?php echo $fcrow->id;?>"><?php echo $fcrow->{'title'.Lang::$lang};?></a>
  <?php endforeach;?>
</div>
<?php endif;?>
<div class="wk section divider"></div>
<div id="foliowrap" class="clearfix">
  <?php if(!$portadata):?>
  <?php echo Filter::msgSingleAlert(Lang::$word->_MOD_PF_NOPROJECTS);?>
  <?php else:?>
  <?php foreach($portadata as $row):?>
  <div class="item">
    <section>
      <div class="image-overlay"> <img src="<?php echo SITEURL.'/'.Portfolio::imagepath . $row->thumb;?>" alt="">
        <div class="overlay-fade"> <a href="<?php echo Url::Portfolio("item", $row->slug);?>"><i class="icon-overlay icon url"></i></a> </div>
      </div>
      <h4><?php echo $row->{'title' . Lang::$lang};?> </h4>
      <p><?php echo cleanSanitize($row->{'short_desc' . Lang::$lang});?></p>
    </section>
  </div>
  <?php endforeach;?>
</div>
<div id="pagination" class="content-center"><?php echo $pager->display_pages();?></div>
<?php endif;?>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
	$('#foliowrap').waitForImages(function () {
		$('#foliowrap').Grid({
			inner: 3,
			outer: 0,
			cols: Math.round(1200 / <?php echo Registry::get("Portfolio")->cols;?>)
		});
	});
});
// ]]>
</script>
<?php break;?>
<?php endswitch;?>