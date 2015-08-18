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
  Registry::set('Portfolio', new Portfolio());
?>
<?php
  /* == Update Configuration == */
  if (isset($_POST['processConfig'])):
      Registry::get("Portfolio")->processConfig();
  endif;

  /* == Proccess Project == */
  if (isset($_POST['processFolio'])):
      Registry::get("Portfolio")->processFolio();
  endif;

  /* == Delete Project == */
  if (isset($_POST['delete']) and $_POST['delete'] == "deleteProject"):
      $title = sanitize($_POST['title']);
      if ($thumb = getValueById("thumb", Portfolio::mTable, Filter::$id)):
          unlink(BASEPATH . Portfolio::imagepath . $thumb);
      endif;
      $result = $db->delete(Portfolio::mTable, "id=" . Filter::$id);

      if ($result):
          $json['type'] = 'success';
          $json['title'] = Lang::$word->_SUCCESS;
          $json['message'] = Lang::$word->_MOD_PF_PROJECT . ' /' . $title . '/ ' . Lang::$word->_DELETED;
          Security::writeLog(Lang::$word->_MOD_PF_PROJECT . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "module");
      else:
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
      endif;
      print json_encode($json);
  endif;

  /* == Proccess Category == */
  if (isset($_POST['processCategory'])):
      Registry::get("Portfolio")->processCategory();
  endif;

  /* == Update Category Order == */
  if (isset($_GET['sortcats'])):
      Portfolio::updateOrder();
  endif;

  /* == Delete Category == */
  if (isset($_POST['delete']) and $_POST['delete'] == "deleteCategory"):
      $title = sanitize($_POST['title']);
      $result = $db->delete(Portfolio::cTable, "id=" . Filter::$id);

      if ($result):
          $json['type'] = 'success';
          $json['title'] = Lang::$word->_SUCCESS;
          $json['message'] = Lang::$word->_MOD_PF_CATEGORY . ' /' . $title . '/ ' . Lang::$word->_DELETED;
          Security::writeLog(Lang::$word->_MOD_PF_CATEGORY . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "module");
      else:
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
      endif;
      print json_encode($json);
  endif;
?>