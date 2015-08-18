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
  Registry::set('AdBlock', new AdBlock());
?>
<?php
  /* == Proccess AdBlock == */
  if (isset($_POST['processAdBlock'])):
      Registry::get("AdBlock")->processAdBlock();
  endif;

  /* == Delete AdBlock == */
  if (isset($_POST['delete']) and $_POST['delete'] == "deleteAdBlock"):
      $title = sanitize($_POST['title']);
      $row = getValuesById("block_assignment, banner_image", AdBlock::mTable, Filter::$id);

      if ($row->block_assignment) :
          $pluginid = getValue("id", Content::plTable, "plugalias='" . $row->block_assignment . "'");
          $block_assignment_clean = str_replace('adblock/', '', $row->block_assignment);
          $plugin_file_current = BASEPATH . AdBlock::pluginspath . $block_assignment_clean . '/main.php';
          unlink($plugin_file_current);
          rmdir(str_replace('/main.php', '', $plugin_file_current));
          $db->delete(Content::plTable, "id=" . $pluginid);
          $db->delete(Content::lTable, "plug_id=" . $pluginid);
      endif;

      if ($row->banner_image):
          @unlink(BASEPATH . AdBlock::imagepath . $row->banner_image);
      endif;
      $result = $db->delete(AdBlock::mTable, "id=" . Filter::$id);
      $db->delete(AdBlock::amTable, "adblock_id=" . Filter::$id);

      if ($result):
          $json['type'] = 'success';
          $json['title'] = Lang::$word->_SUCCESS;
          $json['message'] = Lang::$word->_MOD_AB_ADBLOCK . ' /' . $title . '/ ' . Lang::$word->_DELETED;
          Security::writeLog(Lang::$word->_MOD_AB_ADBLOCK . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "module");
      else:
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
      endif;
      print json_encode($json);
  endif;
?>