<?php
  /**
   * Upcoming Event
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  require_once(PLUGPATH . "upevent/admin_class.php");
  Registry::set('upEvent',new upEvent());
  $conf = Registry::get("upEvent");
  $erow = $conf->getEvent();

  $d = explode("-",$erow->date_end); 
  $t = explode(":",$erow->time_end);
?>
<!-- Start Upcoming Event -->
<?php if(strtotime(date('y-m-d H:i:s')) > strtotime($erow->date_end . ' ' . $erow->time_end)):?>
<?php echo Filter::msgSingleAlert(Lang::$word->_PLG_UE_ENDED);?>
<?php else:?>
<?php if($conf->event_id):?>
<div id="countevent" class="clearfix">
  <div class="dash weeks_dash">
    <div class="digit first">
      <div style="display:none" class="top">1</div>
      <div style="display:block" class="bottom">0</div>
    </div>
    <div class="digit last">
      <div style="display:none" class="top">3</div>
      <div style="display:block" class="bottom">0</div>
    </div>
    <span class="dash_title"><?php echo Lang::$word->_M_WEEKS;?></span> </div>
  <div class="dash days_dash">
    <div class="digit first">
      <div style="display:none" class="top">0</div>
      <div style="display:block" class="bottom">0</div>
    </div>
    <div class="digit last">
      <div style="display:none" class="top">0</div>
      <div style="display:block" class="bottom">0</div>
    </div>
    <span class="dash_title"><?php echo Lang::$word->_M_DAYS;?></span> </div>
  <div class="dash hours_dash">
    <div class="digit first">
      <div style="display:none" class="top">2</div>
      <div style="display:block" class="bottom">0</div>
    </div>
    <div class="digit last">
      <div style="display:none" class="top">3</div>
      <div style="display:block" class="bottom">0</div>
    </div>
    <span class="dash_title"><?php echo Lang::$word->_M_HOURS;?></span> </div>
  <div class="dash minutes_dash">
    <div class="digit first">
      <div style="display:none" class="top">2</div>
      <div style="display:block" class="bottom">0</div>
    </div>
    <div class="digit last">
      <div style="display:none" class="top">9</div>
      <div style="display:block" class="bottom">0</div>
    </div>
    <span class="dash_title"><?php echo Lang::$word->_M_MINUTES;?></span> </div>
</div>
<div class="wk message">
  <h5 class="wk header"><?php echo $erow->{'title'.Lang::$lang};?></h5>
  <div class="wk divided list">
    <div class="item"><i class="icon information"></i><?php echo cleanSanitize($erow->{'body'.Lang::$lang},60);?></div>
    <div class="item"><i class="icon calendar"></i><?php echo Filter::dodate("long_date", $erow->date_start.' '.$erow->time_start);?></div>
    <?php if($erow->{'venue'.Lang::$lang}):?>
    <div class="item"><i class="icon building"></i><?php echo $erow->{'venue'.Lang::$lang};?></div>
    <?php endif;?>
  </div>
</div>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
	$('#countevent').countDown({
		targetDate: {
			'day': <?php echo $d[2];?>,
			'month': <?php echo $d[1];?>,
			'year': <?php echo $d[0];?>,
			'hour': <?php echo $t[0];?>,
			'min': <?php echo $t[1];?>,
			'sec': 0
		}
	});
});

// ]]>
</script>
<?php endif;?>
<?php endif;?>
<!-- End Upcoming Event /-->