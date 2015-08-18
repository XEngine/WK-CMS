<?php
  /**
   * Stripe Form
   *
   * @package reelance Manager
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
    die('Direct access to this location is not allowed.');
?>
<?php if(!$row->recurring):?>
<div class="wk tiny basic button">
  <input type="image" src="<?php echo SITEURL.'/gateways/stripe/stripe_big.png';?>" name="submit" title="Pay With Stripe" alt="" onclick="$('#stripeform').slideToggle(500)"/>
</div>
<div id="stripeform" style="display:none">
  <form method="post" id="stripe_form" class="wk segment form">
    <div class="field">
      <label>Card Number</label>
      <label class="input"> <i class="icon-append icon asterisk"></i>
        <input type="text" autocomplete="off" name="card-number" placeholder="Card Number">
      </label>
    </div>
    <div class="three fields">
      <div class="field">
        <label>CVC</label>
        <label class="input"> <i class="icon-append icon asterisk"></i>
          <input type="text" autocomplete="off" name="card-cvc" placeholder="CVC">
        </label>
      </div>
      <div class="field">
        <label>Expiration Month</label>
        <label class="input"> <i class="icon-append icon asterisk"></i>
          <input type="text" autocomplete="off" name="card-expiry-month" placeholder="MM">
        </label>
      </div>
      <div class="field">
        <label>Expiration Year</label>
        <label class="input"> <i class="icon-append icon asterisk"></i>
          <input type="text" autocomplete="off" name="card-expiry-year" placeholder="YYYY">
        </label>
      </div>
    </div>
    <button class="wk positive right labeled icon button" id="dostripe" name="dostripe" type="button"><i class="right arrow icon"></i> Pay With Stripe</button>
    <input type="hidden" name="amount" value="<?php echo $row->price;?>" />
    <input type="hidden" name="item_name" value="<?php echo $row->{'title'.Lang::$lang};?>" />
    <input type="hidden" name="item_number" value="<?php echo $row->id;?>" />
    <input type="hidden" name="currency_code" value="<?php echo ($grows->extra2) ? $grows->extra2 : $core->currency;?>" />
    <input type="hidden" name="processStripePayment" value="1" />
  </form>
</div>
<div id="smsgholder"></div>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function() {
    $('#dostripe').on('click', function() {
        $("#stripe_form").addClass('loading');
        var str = $("#stripe_form").serialize();
        $.ajax({
            type: "post",
            dataType: 'json',
            url: SITEURL + "/gateways/stripe/ipn.php",
            data: str,
            success: function(json) {
                $("#stripe_form").removeClass('loading');
                if (json.type == "success") {
					$('#smsgholder').html(json.message).fadeOut();
                    setTimeout(function() {
							window.location.href = '<?php echo Url::Page($core->account_page);?>';
                        },
                        4000);
                } else {
                    $("#smsgholder").html(json.message);
                }
            }
        });
        return false;
    });
});
// ]]>
</script> 
<?php endif;?>