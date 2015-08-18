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
  Registry::set('newsSlider', new newsSlider());
?>
<?php
  /* == Update News Item == */
  if (isset($_POST['processNews'])):
      Registry::get("newsSlider")->processNews();
  endif;

  /* == Update News Order == */
  if (isset($_GET['sortnews'])):
      newsSlider::updateOrder();
  endif;

  /* == Delete News Item == */
  if (isset($_POST['delete']) and $_POST['delete'] == "deleteNews"):
      $title = sanitize($_POST['title']);
	  $result = $db->delete(newsSlider::mTable, "id=" . Filter::$id);

      if ($result):
          $json['type'] = 'success';
          $json['title'] = Lang::$word->_SUCCESS;
          $json['message'] = Lang::$word->_PLG_NS_ITEM . ' /' . $title . '/ ' . Lang::$word->_DELETED;
          Security::writeLog(Lang::$word->_PLG_NS_ITEM . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "plugin");
      else:
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
      endif;
       print json_encode($json);
  endif;
?>