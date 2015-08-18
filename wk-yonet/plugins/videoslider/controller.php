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
  Registry::set('vSlider', new vSlider());
?>
<?php
  /* == Proccess Slide == */
  if (isset($_POST['processSlide'])):
      Registry::get("vSlider")->processSlide();
  endif;

  /* == Proccess Configuration == */
  if (isset($_POST['processConfig'])):
      Registry::get("vSlider")->processConfig();
  endif;
  
  /* == Update Images Order == */
  if (isset($_GET['sortslides'])):
      vSlider::updateOrder();
  endif;

  /* == Delete Slide == */
  if (isset($_POST['delete']) and $_POST['delete'] == "deleteSlide"):
      $title = sanitize($_POST['title']);
      $result = $db->delete(vSlider::mTable, "id=" . Filter::$id);

      if ($result):
          $json['type'] = 'success';
          $json['title'] = Lang::$word->_SUCCESS;
          $json['message'] = Lang::$word->_PLG_VS_SLIDE . ' /' . $title . '/ ' . Lang::$word->_DELETED;
          Security::writeLog(Lang::$word->_PLG_VS_SLIDE . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "plugin");
      else:
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
      endif;
      print json_encode($json);
  endif;
?>