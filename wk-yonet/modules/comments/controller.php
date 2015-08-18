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
  Registry::set('Comments', new Comments());
?>
<?php 
  /* == Update Configuration == */
  if (isset($_POST['processConfig'])):
      Registry::get("Comments")->processConfig();
  endif;

  /* == Load Comment == */
  if (isset($_POST['loadComment'])):
      $row = Core::getRowById(Comments::mTable, Filter::$id);
      if ($row):
          $html =  '<div class="wk small form" style="width:400px">';
          $html .= '<div class="field"><textarea name="body" class="altpost" id="bodyid">' . $row->body . '</textarea></div>';
          $html .= '<p class="wk info">' . $row->www . '</p>';
          $html .= '<p class="wk info">IP: ' . $row->ip . '</p>';
          $html .= '</div>';
          print $html;
      endif;
  endif;
  
  /* == Update Comment == */
  if (isset($_POST['processComment'])):
      $data['body'] = cleanOut($_POST['content']);
      $result = $db->update(Comments::mTable, $data, "id=" . Filter::$id);

      if ($result):
          $json['type'] = 'success';
          $json['title'] = Lang::$word->_SUCCESS;
          $json['message'] = Lang::$word->_MOD_CM_COMUPDATED;
          Security::writeLog(Lang::$word->_MOD_CM_COMUPDATED, "", "no", "module");
      else:
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
      endif;
      print json_encode($json);
  endif;
  
  /* == Comments Actions == */
  if (isset($_POST['comproccess'])):
      $action = '';
      if (empty($_POST['comid'])):
          $json['type'] = 'warning';
          $json['message'] = Filter::msgAlert(Lang::$word->_MOD_CM_NA, false);
      endif;

      if (!empty($_POST['comid'])):
          foreach ($_POST['comid'] as $val):
              $id = intval($val);

              if (isset($_POST['action']) && $_POST['action'] == "disapprove"):
                  $data['active'] = 0;
                  $action = Lang::$word->_MOD_CM_DISAPPROVED;
              elseif (isset($_POST['action']) && $_POST['action'] == "approve"):
                  $data['active'] = 1;
                  $action = Lang::$word->_MOD_CM_APPROVED;
              endif;

              if (isset($_POST['action']) && $_POST['action'] == "delete"):
                  $db->delete(Comments::mTable, "id=" . $id);
                  $action = Lang::$word->_MOD_CM_DELETED;
              else:
                  $db->update(Comments::mTable, $data, "id=" . $id);
              endif;
          endforeach;

		  if ($db->affected()):
			  $json['type'] = 'success';
			  $json['message'] = Filter::msgOk($action, false);
			  Security::writeLog($action, "", "no", "module");
		  else:
			  $json['type'] = 'warning';
			  $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
		  endif;

      endif;
	  print json_encode($json);
  endif;
?> 