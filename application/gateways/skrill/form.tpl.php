<?php
  /**
   * Moneybookers Form
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<div class="wk tiny basic button">
  <form action="https://www.moneybookers.com/app/payment.pl" method="post" id="mb_form" name="mb_form">
    <input type="image" src="<?php echo SITEURL.'/gateways/skrill/skrill_big.png';?>" name="submit" title="Pay With Moneybookers" alt="" onclick="document.mb_form.submit();"/>
    <input type="hidden" name="pay_to_email" value="<?php echo $grows->extra;?>" />
    <input type="hidden" name="return_url" value="<?php echo Url::Page($core->account_page);?>" />
    <input type="hidden" name="cancel_url" value="<?php echo Url::Page($core->account_page);?>" />
    <input type="hidden" name="status_url" value="<?php echo SITEURL;?>/gateways/skrill/ipn.php" />
    <input type="hidden" name="merchant_fields" value="session_id, item, custom" />
    <input type="hidden" name="item" value="<?php echo $row->{'title'.Lang::$lang};?>" />
    <input type="hidden" name="session_id" value="<?php echo md5(time())?>" />
    <input type="hidden" name="custom" value="<?php echo $row->id . '_' . $user->uid;?>" />
    <?php if($row->recurring == 1):?>
    <input type="hidden" name="rec_amount" value="<?php echo $row->price;?>" />
    <input type="hidden" name="rec_period" value="<?php echo $member->getTotalDays($row->period, $row->days);?>" />
    <input type="hidden" name="rec_cycle" value="day" />
    <?php else: ?>
    <input type="hidden" name="amount" value="<?php echo $row->price;?>" />
    <?php endif; ?>
    <input type="hidden" name="currency" value="<?php echo ($grows->extra2) ? $grows->extra2 : $core->currency;?>" />
    <input type="hidden" name="detail1_description" value="<?php echo $row->{'title'.Lang::$lang};?>" />
    <input type="hidden" name="detail1_text" value="<?php echo $row->{'description'.Lang::$lang};?>" />
  </form>
</div>