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
  
  require_once("../../init.php");
  if (!$user->is_Admin())
      redirect_to("../../login.php");

  require_once("admin_class.php");
  Registry::set('Donate', new Donate());
?>
<?php
  /* == Proccess Configuration */
  if (isset($_POST['processConfig'])):
      Registry::get("Donate")->processConfig();
  endif;

  /* == Empty Donations == */
  if (isset($_GET['emptyDonations'])):
      $db->query("TRUNCATE TABLE " . Donate::mTable);
      redirect_to("../../index.php?do=plugins&action=config&plugname=donate");
  endif;

  /* == Add Payment */
  if (isset($_POST['addPayment'])):
      if (!empty($_POST['amount']) or !empty($_POST['email']) or !empty($_POST['name'])):
          $data = array(
              'name' => sanitize($_POST['name']),
              'email' => sanitize($_POST['email']),
              'amount' => floatval($_POST['amount']),
              'created' => "NOW()");
          $last_id = $db->insert(Donate::mTable, $data);
          $html = '
			<tr class="warning">
			  <td>' . $last_id . '.</td>
			  <td>' . $data['name'] . '</td>
			  <td>' . $data['email'] . '</td>
			  <td>' . $data['amount'] . '</td>
			  <td data-sort-value="' . strtotime(date('Y-m-d H:i:s')) . '">' . Filter::dodate("long_date", date('Y-m-d H:i:s')) . '</td>
			</tr>';

          $json['type'] = 'success';
          $json['html'] = $html;
          $json['title'] = Lang::$word->_SUCCESS;
          $json['message'] = Lang::$word->_PLG_DP_ADDED;
          Security::writeLog(Lang::$word->_PLG_DP_ADDED, "", "no", "module");
      else:
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = Lang::$word->_PLG_DP_ADDEDERR;
      endif;
      print json_encode($json);
  endif;

  
  /* == Export Donations == */
  if (isset($_GET['exportDonations'])):
      $header = '';
      $data = '';
      $result = $db->query("SELECT * FROM " . Donate::mTable);
      $fields = $db->field_count();
      $names = $db->fetch_fields($result);

      for ($i = 0; $i < $fields; $i++) {
          $header .= $names[$i]->name . ",";
      }
      while ($row = $db->fetchrow($result)) {
          $line = '';
          foreach ($row as $value) {
              $value = '"' . $value . '"' . ",";
              $line .= $value;
          }
          $data .= trim($line) . "\n";
      }
      $title = Lang::$word->_PLG_DP_REPORT;
      $data = str_replace("\r", " ", $data);
      header("Content-type: application/x-msdownload");
      header("Content-Disposition: attachment; filename=nsl.csv");
      header("Pragma: no-cache");
      header("Expires: 0");
      print "$title\n\n$header\n$data";

      exit;
  endif;
?>