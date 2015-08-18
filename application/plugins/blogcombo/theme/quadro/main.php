<?php
  /**
   * Article Combobox
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2010
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  
  require_once (MODPATH . "blog/admin_class.php");
  $classname = 'Blog';
  try {
	  if (!class_exists($classname)) {
		  throw new exception('Missing blog/admin_class.php');
	  }
	  Registry::set('Blog', new Blog(false));
  }
  catch (exception $e) {
	  echo $e->getMessage();
  }
  
  $archive = Registry::get("Blog")->renderArchive();
  $popular = Registry::get("Blog")->getPopularList();
  $comments = Registry::get("Blog")->getCommentsList();
?>
<!-- Start Blog Combobox -->
<div id="artcombo" class="clearfix">
  <div id="blgtabs" class="wtabs">
    <ul class="wk tabs">
      <li><a data-tab="#pop"><?php echo Lang::$word->_MOD_AM_POPULAR;?></a></li>
      <li><a data-tab="#arc"><?php echo Lang::$word->_MOD_AM_ARCHIVE;?></a></li>
      <li><a data-tab="#com"><i class="icon chat"></i></a></li>
    </ul>
    <div class="wk bottom attached secondary segment">
      <div id="pop" class="wk tab content"> 
        <!-- Start Popular Article -->
        <?php if($popular):?>
        <div class="wk relaxed divided list">
          <?php foreach ($popular as $poprow):?>
          <div class="item">
            <?php if($poprow->thumb):?>
            <a href="<?php echo SITEURL;?>/modules/blog/dataimages/<?php echo $poprow->thumb;?>" title="<?php echo $poprow->imgcap;?>" class="lightbox"><img src="<?php echo SITEURL;?>/thumbmaker.php?src=/<?php echo MODURL;?>blog/dataimages/<?php echo $poprow->thumb;?>&amp;h=50&amp;w=50&amp;a=t" alt="" class="wk avatar image"></a>
            <?php endif;?>
            <div class="content">
              <div class="header"><a href="<?php echo Url::Blog("item", $poprow->slug);?>" class="inverted"><?php echo truncate($poprow->atitle,25);?></a></div>
              <div class="description"><i class="icon calendar"></i> <?php echo Filter::dodate("short_date",$poprow->created);?></div>
            </div>
          </div>
          <?php endforeach;?>
          <?php unset($poprow);?>
        </div>
      </div>
      <?php endif;?>
      <!-- End Popular Article /--> 
      
      <!-- Start Blog Archive -->
      <?php if($archive):?>
      <div id="arc" class="wk tab content">
        <div class="wk divided list">
          <?php foreach ($archive as $arow):?>
          <div class="item">
            <div class="right floated wk label"><?php echo $arow->total;?></div>
            <i class="icon archive"></i> <a href="<?php echo Url::Blog("blog-archive", false, $arow->year . '-'. $arow->month.'/');?>"> <?php echo Blog::getShortMonths($arow->month) . " " . $arow->year;?></a></div>
          <?php endforeach;?>
          <?php unset($arow);?>
        </div>
      </div>
      <?php endif;?>
      <!-- End Blog Archive /--> 
      
      <!-- Start Latest Comments -->
      <?php if($comments):?>
      <div id="com" class="wk tab content">
        <div class="wk divided list">
          <?php foreach ($comments as $comrow):?>
          <div class="item">
            <div class="right floated wk label"><?php echo Filter::dodate("short_date", $comrow->created);?></div>
            <i class="icon chat"></i>
            <div class="content">
              <div class="header"><a href="<?php echo Url::Blog("item", $comrow->slug);?>"><?php echo $comrow->atitle;?></a> </div>
              <div class="description"><?php echo cleanSanitize($comrow->body,50);?></div>
            </div>
          </div>
          <?php endforeach;?>
          <?php unset($comrow);?>
        </div>
      </div>
      <?php endif;?>
      <!-- End Latest Comments /--> 
    </div>
  </div>
</div>
<!-- End Blog Combobox /-->