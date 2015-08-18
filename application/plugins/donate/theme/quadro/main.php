<?php
  /**
   * Donations
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  require_once(PLUGPATH . "donate/admin_class.php");
  Registry::set('Donate',new Donate());
  $donate = Registry::get("Donate");
  
  $total = $donate->countDonations();
  $percentage = $donate->donationPercentage($total, $donate->atarget)
?>
<!-- Start Donations -->
<div id="donations">
  <div class="wk striped black active progress small-top-space" data-percent="<?php echo $percentage;?>">
    <div style="width:<?php echo $percentage;?>%" class="bar"><?php echo $percentage;?>%</div>
  </div>
  <div class="wk two fluid basic buttons small-top-space small-bottom-space">
    <div class="wk button"><?php echo $core->cur_symbol . number_format($total, 2, '.', ',');?></div>
    <div class="wk button"><?php echo LANG::$word->_PLG_DP_TARGET1;?> <?php echo $core->cur_symbol . number_format($donate->atarget, 2, '.', ',');?></div>
  </div>
  <form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="pp_form" name="pp_form">
    <input type="hidden" name="cmd" value="_donations" />
    <input type="hidden" name="business" value="<?php echo $donate->paypal;?>" />
    <input type="hidden" name="item_name" value="Donations For <?php echo $core->company;?>" />
    <input type="hidden" name="item_number" value="<?php echo rand(10,3);?>" />
    <input type="hidden" name="return" value="<?php echo Url::Page($donate->thankyou);?>" />
    <input type="hidden" name="rm" value="2" />
    <input type="hidden" name="notify_url" value="<?php echo SITEURL;?>/plugins/donate/ipn.php" />
    <input type="hidden" name="cancel_return" value="<?php echo SITEURL;?>" />
    <input type="hidden" name="no_note" value="1" />
    <input type="hidden" name="currency_code" value="<?php echo $core->currency;?>" />
    <button class="wk fluid positive button" type="submit" name="pp_form"><?php echo LANG::$word->_PLG_DP_DONATE;?></button>
  </form>
</div>
<!-- End Donations /-->