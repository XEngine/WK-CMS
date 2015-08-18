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

  require_once ("../../init.php");
  if (!$user->is_Admin())
      redirect_to("../../login.php");

  require_once("admin_class.php");
  Registry::set('GMaps', new GMaps());
?>
<?php
  /* == Proccess GMap == */
  if (isset($_POST['processGMap'])):
      Registry::get("GMaps")->processGMap();
  endif;

  /* == Delete GMap  == */
  if (isset($_POST['delete']) and $_POST['delete'] == "deleteGMap"):
      $title = sanitize($_POST['title']);
      $name = getValueById("name", GMaps::mTable, Filter::$id);

      if ($name):
          $pluginid = getValue("id", Content::plTable, "plugalias='gmaps/" . $name . "'");

          $name_clean = str_replace('gmaps/', '', $name);
          $plugin_file_current = BASEPATH . GMaps::pluginspath . $name_clean . '/main.php';
		  if(is_file($plugin_file_current)):
              unlink($plugin_file_current);
              rmdir(str_replace('/main.php', '', $plugin_file_current));
		  endif;
          if ($pluginid):
              $db->delete(Content::plTable, "id=" . $pluginid);
              $db->delete(Content::lTable, "plug_id=" . $pluginid);
          endif;
      endif;

      $result = $db->delete(GMaps::mTable, "id=" . Filter::$id);

      if ($result):
          $json['type'] = 'success';
          $json['title'] = Lang::$word->_SUCCESS;
          $json['message'] = Lang::$word->_MOD_GM_GMAP . ' /' . $title . '/ ' . Lang::$word->_DELETED;
          Security::writeLog(Lang::$word->_MOD_GM_GMAP . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "module");
      else:
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
      endif;
      print json_encode($json);
  endif;
?>