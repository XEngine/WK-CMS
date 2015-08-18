<?php
  /**
   * Image Slider
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  require_once(BASEPATH . "admin/plugins/slider/admin_class.php");
  Registry::set('Slider', new Slider());
  
  $slides = Registry::get("Slider")->getSlides();
  $conf = Registry::get("Slider");
?>
<!-- Start jQuery Slider -->
<?php if(!$slides):?>
<?php echo Filter::msgSingleAlert(Lang::$word->_PLG_SL_NOIMG);?>
<?php else:?>
<section id="jqslider">
  <div class="ns-slider">
    <?php foreach ($slides as $srow):?>
      <?php if($srow->urltype == "nourl"):?>
      <img src="<?php echo SITEURL . '/' . Slider::imgPath . $srow->thumb;?>" <?php if($conf->showCaptions):?>data-slidecaption="<h1><?php echo $srow->{'title'.Lang::$lang};?><h1><?php echo $srow->{'body'.Lang::$lang};?>"<?php endif;?>alt="">>
      <?php else:?>
      <a href="<?php echo ($srow->urltype == "ext") ? $srow->url : Url::Page($srow->url);?>" <?php echo ($srow->urltype == "ext") ? "target=\"_blank\"" : "target=\"_self\"";?>><img src="<?php echo SITEURL . '/' . Slider::imgPath . $srow->thumb;?>" <?php if($conf->showCaptions):?>data-slidecaption="<h1><?php echo $srow->{'title'.Lang::$lang};?><h1><?php echo $srow->{'body'.Lang::$lang};?>"<?php endif;?> alt=""></a>
      <?php endif;?>
    <?php endforeach;?>
    <?php unset($srow);?>
  </div>
</section>
<script src="<?php echo PLUGURL;?>slider/slider.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".ns-slider").nerveSlider({
		sliderWidth: '3600px',
		sliderHeightAdaptable:<?php echo $conf->sliderHeightAdaptable;?>,
		<?php if(!$conf->sliderHeightAdaptable):?>
		sliderHeight: "<?php echo $conf->sliderHeight;?>px",
		<?php endif;?>
		slideTransitionSpeed: <?php echo $conf->slideTransitionSpeed;?>,
		slideTransitionEasing: "<?php echo $conf->slideTransitionEasing;?>",
		slideTransitionDelay: <?php echo $conf->slideTransitionDelay;?>,
		slideTransition: "<?php echo $conf->slideTransition;?>",
		showFilmstrip: <?php echo $conf->showFilmstrip;?>,
		showCaptions:<?php echo $conf->showCaptions;?>,
		simultaneousCaptions: <?php echo $conf->simultaneousCaptions;?>,
		slideTransitionDirection:"<?php echo $conf->slideTransitionDirection;?>",
		sliderFullscreen:0,
		sliderResizable: true,
		showArrows: <?php echo $conf->showArrows;?>,
		showDots: <?php echo $conf->showDots;?>,
		showPause: <?php echo $conf->showPause;?>,
		showTimer: <?php echo $conf->showTimer;?>,
		slideReverse: <?php echo $conf->slideReverse;?>,
		slideShuffle: <?php echo $conf->slideShuffle;?>,
		sliderAutoPlay: <?php echo $conf->sliderAutoPlay;?>,
		waitForLoad: <?php echo $conf->waitForLoad;?>,
		slideImageScaleMode: "<?php echo $conf->slideImageScaleMode;?>",
	});
});
</script>
<?php endif;?>
<!-- End jQuery Slider /-->
