<?php

  /**
   * Google Maps Class
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2012
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */

  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  class GMaps
  {

      const mTable = "mod_gmaps";
      const pluginspath = "plugins/gmaps/";


      /**
       * GMaps::__construct()
       * 
       * @return
       */
      function __construct()
      {
      }


      /**
       * GMaps::getGMaps()
       * 
       * @return
       */
      public function getGMaps()
      {

          $sql = "SELECT * FROM " . self::mTable . " ORDER BY name";
          $row = Registry::get("Database")->fetch_all($sql);

          return ($row) ? $row : 0;
      }


      /**
       * GMaps::processGMap()
       * 
       * @return
       */
      public function processGMap()
      {

          Filter::checkPost('name', Lang::$word->_MOD_GM_NAME);

          if (empty($_POST['lat']) or empty($_POST['lng']))
              Filter::$msgs['lat'] = Lang::$word->_MOD_GM_LLERR;

          if (!preg_match('/^[a-z0-9]+$/i', $_POST['name']))
              Filter::$msgs['name'] = Lang::$word->_MOD_GM_NAME2;

          if (Filter::$id) {
              $currentData = Core::getRowById(self::mTable, Filter::$id);
              $current_name = $currentData->name;

              $sqlSelectPlugins = Registry::get("Database")->first(
			  "SELECT id FROM " . Content::plTable 
			  . "\n WHERE plugalias = 'gmaps/" . sanitize($_POST['name']) . "'" 
			  . "\n AND plugalias <> 'gmaps/" . $current_name . "'");
          } else {
              $sqlSelectPlugins = Registry::get("Database")->first(
			  "SELECT id FROM " . Content::plTable 
			  . "\n WHERE plugalias = 'gmaps/" . sanitize($_POST['name']) . "'");
          }

          $existingPluginsRow = $sqlSelectPlugins;
          $existingPluginsId = $existingPluginsRow['id'];

          if ($existingPluginsId)
              Filter::$msgs['name'] = Lang::$word->_MOD_GM_NAME_EXISTS;

          if (empty(Filter::$msgs)) {
              $data = array(
                  'name' => sanitize($_POST['name']),
                  'lat' => sanitize($_POST['lat']),
                  'lng' => sanitize($_POST['lng']),
                  'zoom' => intval($_POST['zoom']));

              $mode = (Filter::$id) ? 'update' : 'insert';

              $current_name = '';
              //get current value of name column
              if ($mode == 'update') {
                  $currentData = Core::getRowById(self::mTable, Filter::$id);
                  $current_name = $currentData->name;
                  $current_name_clean = str_replace('gmaps/', '', $current_name);
              }

              $gmaps_clean = str_replace('gmaps/', '', $data['name']);
              $plugin_file = BASEPATH . self::pluginspath . $gmaps_clean . '/main.php';
              $plugin_file_main = BASEPATH . self::pluginspath . 'main.php';

              if ($mode == 'insert' && is_dir(str_replace('/main.php', '', $plugin_file))) {
                  //Filter::$msgs['name'] = Lang::$word->_MOD_GM_NAME_EXISTS;
				  $json['message'] = Filter::msgError(Lang::$word->_MOD_GM_NAME_EXISTS, false);
				  print json_encode($json);
                  return;
              }

              ($mode == 'update') ? Registry::get("Database")->update(self::mTable, $data, "id=" . Filter::$id) : $last_id = Registry::get("Database")->insert(self::mTable, $data);
              $message = ($mode == 'update') ? Lang::$word->_MOD_GM_GUPDATED : Lang::$word->_MOD_GM_GADDED;


              if ($mode == 'insert') {
                  mkdir(str_replace('/main.php', '', $plugin_file));
                  file_put_contents($plugin_file, str_replace('###GMAPSID###', $last_id, file_get_contents($plugin_file_main)));

                  $datai = array(
                      'title' . Lang::$lang => 'Google Maps - ' . $gmaps_clean,
                      'system' => 1,
                      'plugalias' => 'gmaps/' . $data['name'],
                      'created' => "NOW()",
                      'active' => 1,
                      );

                  Registry::get("Database")->insert(Content::plTable, $datai);
              } else {
                  if ($current_name != $data['name']) {
                      $plugin_file_current = BASEPATH . self::pluginspath . $current_name_clean . '/main.php';
                      unlink($plugin_file_current);
                      rmdir(str_replace('/main.php', '', $plugin_file_current));

                      mkdir(str_replace('/main.php', '', $plugin_file));
                      file_put_contents($plugin_file, str_replace('###GMAPSID###', Filter::$id, file_get_contents($plugin_file_main)));

                      $datau = array(
                          'title' . Lang::$lang => 'Google Maps - ' . $gmaps_clean,
                          'system' => 1,
                          'plugalias' => 'gmaps/' . $data['name']);

                      Registry::get("Database")->update(Content::plTable, $datau, "plugalias='" . $current_name . "'");
                  }
			  }

              if (Registry::get("Database")->affected()) {
                  $json['type'] = 'success';
                  $json['message'] = Filter::msgOk($message, false);
                  Security::writeLog($message, "", "no", "module");
              } else {
                  $json['type'] = 'info';
                  $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
              }
              print json_encode($json);

          } else {
              $json['message'] = Filter::msgStatus();
              print json_encode($json);
          }
      }
  }
?>