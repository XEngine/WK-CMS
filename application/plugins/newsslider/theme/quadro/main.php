<?php
  /**
   * News Slider
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2010
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  require_once(PLUGPATH . "newsslider/admin_class.php");
  Registry::set('newsSlider',new newsSlider());
  $sliderrow = Registry::get("newsSlider")->renderNewsItems();
?>
<!-- Start News Slider -->
<?php if($sliderrow):?>
<div class="wk basic segment clearfix">
<div class="wk-carousel" 
  data-pagination="false" 
  data-navigation="true" 
  data-slide-speed="200" 
  data-rewind-speed="100" 
  data-transition-style="fade" 
  data-single-item="true"
  >
    <?php foreach ($sliderrow as $nrow):?>
    <section class="wk-content">
      <?php if($nrow->show_title):?>
      <h5 class="wk header"><?php echo $nrow->{'title'.Lang::$lang};?></h5>
      <?php endif;?>
      <?php if($nrow->show_created):?>
      <p class="created"><i class="icon calendar"></i> <?php echo Filter::dodate('short_date', $nrow->created);?></p>
      <?php endif;?>
      <?php echo cleanOut($nrow->{'body'.Lang::$lang});?>
      </section>
    <?php endforeach;?>
    <?php unset($nrow);?>
  </div>
</div>
<?php endif;?>
<!-- End News Slider /-->