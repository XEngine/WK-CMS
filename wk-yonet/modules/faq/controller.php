<?php
  /**
   * Controller
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  define("_VALID_PHP", true);
  
  require_once("../../init.php");
  if (!$user->is_Admin())
      redirect_to("../../login.php");
  
  require_once("admin_class.php");
  Registry::set('FAQManager', new FAQManager());
?>
<?php
  /* == Process FAQ == */
  if (isset($_POST['processFaq'])):
      Registry::get("FAQManager")->processFaq();
  endif;

  /* == Update FAQ Order == */
  if (isset($_GET['sortslides'])):
      FAQManager::updateOrder();
  endif;
  
  /* == Delete FAQ == */
  if (isset($_POST['delete']) and $_POST['delete'] == "deleteFaq"):
      $title = sanitize($_POST['title']);
      $result = $db->delete(FAQManager::mTable, "id=" . Filter::$id);

      if ($result):
          $json['type'] = 'success';
          $json['title'] = Lang::$word->_SUCCESS;
          $json['message'] = Lang::$word->_MOD_FAQ_FAQ . ' /' . $title . '/ ' . Lang::$word->_DELETED;
          Security::writeLog(Lang::$word->_MOD_FAQ_FAQ . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "module");
      else:
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
      endif;
      print json_encode($json);
  endif;
?>