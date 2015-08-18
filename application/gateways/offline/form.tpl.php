<?php
  /**
   * Paypal Form
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2010
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<div class="wk tiny basic button">
  <form action="#" method="post" id="admin_form" name="admin_form">
    <input class="offline" type="image" src="<?php echo SITEURL.'/gateways/offline/offline_big.png';?>" name="submit" title="Offline Payment" alt="">
    <?php if($core->checkTable("mod_invoices")):?>
    <input name="user_id" type="hidden" value="<?php echo $user->uid;?>" />
    <input name="membership_id" type="hidden" value="<?php echo $row->id;?>" />
    <?php endif;?>
  </form>
</div>