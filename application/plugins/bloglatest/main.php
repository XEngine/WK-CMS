<?php
  /**
   * Article Combobox
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
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

  $bmlatest = Registry::get("Blog")->getLatestPluginArticles();
?>
<!-- Start Latest Article -->
<?php if($bmlatest):?>
<section class="wk stacked segment clearfix">
  <div class="wk-carousel" 
  data-pagination="true" 
  data-navigation="false" 
  data-slide-speed="200" 
  data-rewind-speed="100" 
  data-transition-style="fade" 
  data-single-item="true"
  >
    <?php foreach ($bmlatest as $bmlrow):?>
    <div class="item">
      <?php if($bmlrow->thumb):?>
      <a href="<?php echo Url::Blog("item", $bmlrow->slug);?>"><img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL.'/'.Blog::imagepath . $bmlrow->thumb;?>&amp;h=150&amp;w=400&amp;s=1&amp;a=tl" alt="" class="wk image"></a>
      <?php endif;?>
      <h4><a href="<?php echo Url::Blog("item", $bmlrow->slug);?>"><?php echo $bmlrow->atitle;?></a></h4>
      <div class="description"> <small><i class="icon calendar"></i> <?php echo Filter::dodate("short_date", $bmlrow->created);?><br>
        <i class="icon sitemap"></i> <a href="<?php echo Url::Blog("blog-cat", $bmlrow->catslug);?>" class="inverted"><?php echo $bmlrow->catname;?></a><br>
        <i class="icon chat"></i> <?php echo $bmlrow->totalcomments;?> <?php echo Lang::$word->_MOD_AM_COMMENTS;?></small> </div>
    </div>
    <?php endforeach;?>
    <?php unset($bmlrow);?>
  </div>
</section>
<?php endif;?>
<!-- End Latest Article /-->