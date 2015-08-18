<?php
  /**
   * Portfolio Gallery
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  require_once(MODPATH . "gallery/admin_class.php");
  Registry::set('Gallery', new Gallery($row->gallery));
  
  $galrow = Registry::get("Gallery")->getGalleryImages($row->gallery); 
?>
<?php if(!$galrow):?>
<?php Filter::msgSingleAlert(Lang::$word->_MOD_GA_NOIMG);?>
<?php else:?>
<div class="wk secondary segment">
<div id="gallerywrap" class="clearfix">
          <div class="wk-carousel" 
        data-pagination="false" 
        data-navigation="true" 
        data-single-item="true"
        data-auto-play="false"
        data-transition-style="fade"
        >
        <?php foreach($galrow as $i => $grow):?>
        <section>
        <img src="<?php echo SITEURL.'/'.Gallery::galpath.Registry::get("Gallery")->folder.'/'.$grow->thumb;?>" alt="">
        <h4 class="wk header"><?php echo $grow->{'title' . Lang::$lang};?></h4>
        <p class="portfolio-meta-image"> <?php echo $grow->{'description'.Lang::$lang};?> </p>
        </section>
        <?php endforeach;?>
  </div>      
</div>
</div>
<?php endif;?>