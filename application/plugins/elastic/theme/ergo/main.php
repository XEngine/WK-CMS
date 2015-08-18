<?php
  /**
   * Elastic Slider
   *
   * @package wk:cms
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  require_once(PLUGPATH . "elastic/admin_class.php");
  Registry::set('Elastic',new Elastic());

  $slides = Registry::get("Elastic")->getSlides();
?>
<!-- Start Slider -->
<?php if(!$slides):?>
<?php echo Filter::msgSingleAlert(Lang::$word->_PLG_ES_NOIMG);?>
<?php else:?>
<div class="elastic-slideshow">
  <div id="ei-slider" class="ei-slider" style="height:<?php echo Registry::get("Elastic")->height;?>px">
    <ul class="ei-slider-large">
      <?php foreach ($slides as $eslrow):?>
      <li><img src="<?php echo SITEURL . '/' . Elastic::imgPath . $eslrow->thumb;?>" alt="<?php echo $eslrow->thumb;?>" />
        <div class="ei-title">
          <h2><?php echo $eslrow->{'title' . Lang::$lang};?></h2>
          <?php if($eslrow->{'body' . Lang::$lang}):?>
          <h3><?php echo $eslrow->{'body' . Lang::$lang}?></h3>
          <?php endif;?>
        </div>
      </li>
      <?php endforeach;?>
    </ul>
    <ul class="ei-slider-thumbs">
      <li class="ei-slider-element">Current</li>
      <?php foreach ($slides as $eslrow):?>
      <li><a href="#"><?php echo $eslrow->{'title' . Lang::$lang};?></a><img src="<?php echo SITEURL . '/' . Elastic::imgPath . $eslrow->thumb;?>" alt="<?php echo $eslrow->{'title' . Lang::$lang};?>" /></li>
      <?php endforeach;?>
    </ul>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function () {
	  $('#ei-slider').eislideshow({
		  easing		: 'easeOutExpo',
		  titleeasing	: 'easeOutExpo',
		  titlespeed	: <?php echo Registry::get("Elastic")->titlespeed;?>,
		  animation	: '<?php echo Registry::get("Elastic")->animation;?>',
		  autoplay	: <?php echo Registry::get("Elastic")->autoplay;?>,
		  interval	: <?php echo Registry::get("Elastic")->interval;?>,
		  speed	: <?php echo Registry::get("Elastic")->speed;?>,
		  thumbMaxWidth	: <?php echo Registry::get("Elastic")->thumbMaxWidth;?>
		  
	  });
  });
</script>
<?php unset($eslrow);?>
<?php endif;?>
<!-- End Slider /--> 