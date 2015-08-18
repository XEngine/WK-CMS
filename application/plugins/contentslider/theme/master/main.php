<?php
  /**
   * Content Slider
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  require_once(PLUGPATH . "contentslider/admin_class.php");
  Registry::set('csSlider',new csSlider());

  $csliderdata = Registry::get("csSlider")->getSlides();
?>
<!-- Start Content Slider -->
<?php if(!$csliderdata):?>
<?php echo Filter::msgSingleAlert(Lang::$word->_PLG_CS_NOIMG);?>
<?php else:?>
<div class="wk secondary segment">
  <div class="wk-carousel" data-auto-play="false" data-pagination="true" data-navigation="false" data-slide-speed="200" data-rewind-speed="1000" data-transition-style="fade" data-single-item="true">
    <?php foreach ($csliderdata as $csrow):?>
    <section>
      <div class= "clearfix"><?php echo cleanOut($csrow->{'body'.Lang::$lang})?> </div>
    </section>
    <?php endforeach;?>
    <?php unset($csrow);?>
  </div>
</div>
<?php endif;?>
<!-- End Content Slider /-->