<?php
  /**
   * Controller
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2010
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  define("_VALID_PHP", true);

  require_once ("../../init.php");
  
  if($core->checkTable("mod_invoices")):
	  require_once (BASEPATH . "admin/modules/invoice/lang/" . $core->language . ".lang.php");
	  require_once (BASEPATH . "admin/modules/invoice/admin_class.php");
	  $im = new invoiceManager();
  endif;
?>
<?php
  /* == Process Invoice == */
  if (isset($_POST['processInvoice']) and $user->logged_in and $row = $core->getRowById("memberships", intval($_POST['membership_id']))):
	  $data = array(
		  'user_id' => intval($_POST['user_id']),
		  'ppid' => 'offline',
		  'pp' => 'Offline',
		  'currency' => $core->currency,
		  'cur_symbol' => $core->cur_symbol,
		  'total' => floatval($row['price']),
		  'paid' => 0.00,
		  'token' => sha1(time()),
		  'created' => "NOW()"
		  );

	  $last_id = $db->insert("mod_invoices", $data);
	  
	  $pdata = array(
		  'title' => 'Offline Membership -  ' . $row['title' . $core->dblang],
		  'user_id' => intval($_POST['user_id']),
		  'invoice_id' => $last_id,
		  'description' => 'Offline Membership Submission',
		  'price' => floatval($row['price']),
		  'qty' => 1
		  );
			   
	  if ($db->insert("mod_invoices_products", $pdata)) {
		  print '<div class="msgOk">' . _OL_INFO . '</div>';
	  }
	  $im->sendInvoice($data['token']);
	  
  else:
  	  print '<div class="msgError"><span>' . _ERROR . '</span>' . _CONTENT_NOT_FOUND. ' </div>';
  endif;
?>