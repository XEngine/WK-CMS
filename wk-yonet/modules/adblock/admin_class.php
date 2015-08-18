<?php
  /**
   * AdBlock Class
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */

  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  class AdBlock
  {

      const mTable = "mod_adblock";
      const amTable = "mod_adblock_memberlevels";
      const imagepath = "modules/adblock/dataimages/";
      const pluginspath = "plugins/adblock/";
	  
	  private static $db;

      /**
       * AdBlock::__construct()
       * 
       * @return
       */
      function __construct() 
	  {
		  self::$db = Registry::get("Database");
		  
	  }

      /**
       * AdBlock::getAdBlock()
       * 
       * @return
       */
	  public function getAdBlock()
	  {
	
		  $counter = countEntries(self::mTable);
		  $pager = Paginator::instance();
		  $pager->items_total = $counter;
		  $pager->default_ipp = Registry::get("Core")->perpage;
		  $pager->paginate();
	
		  $sql = "SELECT * FROM " . self::mTable 
		  . "\n ORDER BY id, title" . Lang::$lang . $pager->limit;
		  $row = self::$db->fetch_all($sql);
	
		  if ($row)
			  foreach ($row as $k => $r) {
				  $row[$k]->is_online = self::isOnline($r);
				  $row[$k]->is_online_str = self::isOnlineStr($r);
				  $row[$k]->block_assignmen = str_replace('adblock/', '', $r->block_assignment);
			  }
	
		  return ($row) ? $row : 0;
	  }

      /**
       * AdBlock::isOnline($row)
       *
       * @return
       */
      public static function isOnline($row)
      {
          $now = strtotime(date('Y-m-d', time()));

          //time-period checking
          if (strtotime($row->start_date) > $now)
              return false;
          if ($row->end_date > 0 && strtotime($row->end_date) <= $now)
              return false;

          $total_views_allowed = $row->total_views_allowed;
          $total_views = $row->total_views;
          $total_clicks_allowed = $row->total_clicks_allowed;
          $total_clicks = $row->total_clicks;
          $min_ctr = $row->minimum_ctr;
          $ctr = ($total_views) ? round($total_clicks / $total_views) : 0;


          //conditions checking
          if ($total_views_allowed > 0 && $total_views > 0 && $total_views_allowed <= $total_views)
              return false;
          if ($total_clicks_allowed > 0 && $total_clicks > 0 && $total_clicks_allowed <= $total_clicks)
              return false;
          if ($min_ctr > 0 && $total_views > 0 && $ctr < $min_ctr)
              return false;

          return true;
      }

      /**
       * AdBlock::isOnlineStr($row)
       *
       * @return
       */
      public static function isOnlineStr($row)
      {
          return (self::isOnline($row)) ? Lang::$word->_MOD_AB_ONLINE : Lang::$word->_MOD_AB_OFFLINE;
      }


      /**
       * AdBlock::getSingle()
       * 
       * @return
       */
	  public function getSingle()
	  {
	
		  $sql = "SELECT m.*, GROUP_CONCAT(am.memberlevel_id) AS memberlevels" 
		  . "\n FROM " . self::mTable . " as m" 
		  . "\n JOIN " . self::amTable . " as am ON m.id = am.adblock_id" 
		  . "\n WHERE id = " . Filter::$id;
	
		  $row = self::$db->first($sql);
	
		  if ($row->id) {
			  $row->is_online = self::isOnline($row);
			  $row->is_online_str = self::isOnlineStr($row);
			  $row->block_assignment = str_replace('adblock/', '', $row->block_assignment);
		  }
	
		  return ($row->id) ? $row : Filter::error("You have selected an Invalid Id - #" . Filter::$id, "AdBlock::getSingle()");;
	  }


      /**
       * AdBlock::processAdBlock()
       * 
       * @return
       */
	  public function processAdBlock()
	  {
	
		  Filter::checkPost('title' . Lang::$lang, Lang::$word->_MOD_AB_NAME);
	
		  if (!Filter::$id) {
			  if (empty($_POST['date_start_submit']) || strtotime($_POST['date_start_submit']) < strtotime(date('Y-m-d', time())))
				  Filter::$msgs['date_start_submit'] = Lang::$word->_MOD_AB_DATE_S_INVALID;
		  } else {
			  if (empty($_POST['date_start_submit']) || self::checkDate($_POST['date_start_submit']))
				  Filter::$msgs['date_start_submit'] = Lang::$word->_MOD_AB_DATE_S_INVALID;
		  }
	      
		  if(!empty($_POST['date_end_submit'])) {
		  if (strtotime($_POST['date_end_submit']) < strtotime(date('Y-m-d', time())))
			  Filter::$msgs['date_end_submit'] = Lang::$word->_MOD_AB_DATE_E_INVALID;
	
		  if (strtotime($_POST['date_end_submit']) <= strtotime($_POST['date_start_submit']))
			  Filter::$msgs['date_end_2'] = Lang::$word->_MOD_AB_DATE_E_INVALID2;
		  }
	
		  if (!preg_match('/^\d+$/', $_POST['max_views']) || $_POST['max_views'] < 0)
			  Filter::$msgs['max_views'] = Lang::$word->_MOD_AB_MAX_VIEWS_INVALID;
	
		  if (!preg_match('/^\d+$/', $_POST['max_clicks']) || $_POST['max_clicks'] < 0)
			  Filter::$msgs['max_clicks'] = Lang::$word->_MOD_AB_MAX_CLICKS_INVALID;
	
		  if (!is_numeric($_POST['min_ctr']) || $_POST['min_ctr'] < 0 || $_POST['min_ctr'] > 1)
			  Filter::$msgs['max_clicks'] = Lang::$word->_MOD_AB_MIN_CTR_INVALID;
	
		  //block assignment
		  if (empty($_POST['block_assignment']))
			  Filter::$msgs['block_assignment'] = Lang::$word->_MOD_AB_BLOCK_ASSIGNMENT_INVALID;
	
		  if (Filter::$id) {
			  $currentData = Core::getRowById(self::mTable, Filter::$id);
			  $current_block_assignment = $currentData->block_assignment;
	
			  $sqlSelectPlugins = 'SELECT id FROM ' . Content::plTable . ' WHERE plugalias = \'' 
			  . 'adblock/' . sanitize($_POST['block_assignment']) . '\' AND plugalias <> \'' . $current_block_assignment . '\' LIMIT 1';
		  } else {
			  $sqlSelectPlugins = 'SELECT id FROM ' . Content::plTable . ' WHERE plugalias = \'' 
			  . 'adblock/' . sanitize($_POST['block_assignment']) . '\' LIMIT 1';
		  }
		  $existingPluginsRow = self::$db->first($sqlSelectPlugins);
	
		  if ($existingPluginsRow)
			  Filter::$msgs['block_assignment'] = Lang::$word->_MOD_AB_BLOCK_ASSIGNMENT_EXISTS;
	
		  //user level
		  if (!isset($_POST['userlevel']) || (!is_array($_POST['userlevel']) && count($_POST['userlevel']) == 0))
			  Filter::$msgs['userlevel'] = Lang::$word->_MOD_AB_ULEVEL_INVALID;
	
		  //banner_type = image
		  if ($_POST['banner_type'] == 0 && !empty($_FILES['banner_image']['name'])) {
			  if (!preg_match("/(\.jpg|\.jpeg|\.png|\.gif)$/i", $_FILES['banner_image']['name']))
				  Filter::$msgs['banner_image'] = Lang::$word->_MOD_AB_BANNER_IMAGE_INVALID;
	
			  if ($_FILES['banner_image']['size'] > 204800)
				  Filter::$msgs['banner_image'] = Lang::$word->_MOD_AB_BANNER_IMAGE_INVALID;
	
			  $file_info = getimagesize($_FILES['banner_image']['tmp_name']);
			  if (empty($file_info))
				  Filter::$msgs['banner_image'] = Lang::$word->_MOD_AB_BANNER_IMAGE_INVALID;
		  }
	
		  if (!Filter::$id) {
			  if ($_POST['banner_type'] == 0 && empty($_FILES['banner_image']['name']))
				  Filter::$msgs['banner_image'] = Lang::$word->_MOD_AB_BANNER_IMAGE_INVALID;
		  }
	
		  if ($_POST['banner_type'] == 0 && $_POST['banner_image_link'] == '')
			  Filter::$msgs['banner_image_link'] = Lang::$word->_MOD_AB_BANNER_LINK_INVALID;
		  if ($_POST['banner_type'] == 0 && $_POST['banner_image_alt'] == '')
			  Filter::$msgs['banner_image_alt'] = Lang::$word->_MOD_AB_BANNER_ALT_INVALID;
	
		  //banner_type = html
		  if ($_POST['banner_type'] == 1 && $_POST['banner_html'] == '')
			  Filter::$msgs['banner_html'] = Lang::$word->_MOD_AB_BANNER_HTML_INVALID;
	
		  if (empty(Filter::$msgs)) {
			  $data = array(
				  'title' . Lang::$lang => sanitize($_POST['title' . Lang::$lang]),
				  'start_date' => date('Y-m-d', strtotime(($_POST['date_start_submit']))),
				  'end_date' => date('Y-m-d', strtotime(($_POST['date_end_submit']))),
				  'total_views_allowed' => sanitize($_POST['max_views']),
				  'total_clicks_allowed' => sanitize($_POST['max_clicks']),
				  'minimum_ctr' => sanitize($_POST['min_ctr']),
				  'block_assignment' => 'adblock/' . doSeo($_POST['block_assignment']),
				  'banner_html' => (isset($_POST['banner_html'])) ? sanitize($_POST['banner_html']) : "NULL",
				  'banner_image_link' => (isset($_POST['banner_image_link'])) ? sanitize($_POST['banner_image_link']) : "NULL",
				  'banner_image_alt' => (isset($_POST['banner_image_alt'])) ? sanitize($_POST['banner_image_alt']) : "NULL",
				  );
	
			  if (!Filter::$id) {
				  $data['created'] = "NOW()";
			  }
			  
			  // Procces Image
			  if ($_POST['banner_type'] == 0 && !empty($_FILES['banner_image']['name'])) {
				  $filedir = BASEPATH . self::imagepath;
				  $newName = "IMG_" . randName();
				  $ext = substr($_FILES['banner_image']['name'], strrpos($_FILES['banner_image']['name'], '.') + 1);
				  $fullname = $filedir . $newName . "." . strtolower($ext);
				  if (Filter::$id && $file = getValueById("banner_image", self::mTable, Filter::$id)) {
					  @unlink($filedir . $file);
				  }
				  $res = move_uploaded_file($_FILES['banner_image']['tmp_name'], $fullname);
				  $data['banner_image'] = $newName . "." . strtolower($ext);
			  }
	
			  $data['end_date'] = (empty($_POST['date_end_submit'])) ? "0000-00-00" : sanitize($_POST['date_end_submit']);
			  if ($_POST['banner_type'] == 0)
				  $data['banner_html'] = "NULL";
			  if ($_POST['banner_type'] == 1) {
				  $data['banner_image'] = $data['banner_image_link'] = $data['banner_image_alt'] = '';
			  }
	
			  $mode = (Filter::$id) ? 'update' : 'insert';
	
			  $current_block_assignment = '';
			  //get current value of block_assignment column
			  if ($mode == 'update') {
				  $currentData = Core::getRowById(self::mTable, Filter::$id);
				  $current_block_assignment = $currentData->block_assignment;
				  $current_block_assignment_clean = str_replace('adblock/', '', $current_block_assignment);
			  }
	
			  ($mode == 'update') ? self::$db->update(self::mTable, $data, "id=" . Filter::$id) : self::$db->insert(self::mTable, $data);
			  $message = ($mode == 'update') ? Lang::$word->_MOD_AB_PUPDATED : Lang::$word->_MOD_AB_PADDED;
			  
			  Filter::$id = Filter::$id ? Filter::$id : self::$db->insertid();
	
			  $block_assignment_clean = str_replace('adblock/', '', $data['block_assignment']);
			  $plugin_file = BASEPATH . self::pluginspath . $block_assignment_clean . '/main.php';
			  $plugin_file_main = BASEPATH . self::pluginspath . 'main.php';
	
			  if ($mode == 'insert') {
				  mkdir(str_replace('/main.php', '', $plugin_file));
				  file_put_contents($plugin_file, str_replace('###ADBLOCKID###', Filter::$id, file_get_contents($plugin_file_main)));
	
				  $pdata = array(
					  'title' . Lang::$lang => $block_assignment_clean,
					  'plugalias' => $data['block_assignment'],
					  'hasconfig' => 0,
					  'created' => "NOW()",
					  'system' => 1,
					  'active' => 1);
	
				  self::$db->insert(Content::plTable, $pdata);
			  } else
				  if ($current_block_assignment != $data['block_assignment']) {
					  $plugin_file_current = BASEPATH . self::pluginspath . $current_block_assignment_clean . '/main.php';
					  unlink($plugin_file_current);
					  rmdir(str_replace('/main.php', '', $plugin_file_current));
					  mkdir(str_replace('/main.php', '', $plugin_file));
					  file_put_contents($plugin_file, str_replace('###ADBLOCKID###', Filter::$id, file_get_contents($plugin_file_main)));
	
					  $pdata = array('title' . Lang::$lang => $block_assignment_clean, 'plugalias' => $data['block_assignment']);
	
					  self::$db->update(Content::plTable, $pdata, "plugalias = '" . $data['block_assignment'] . "'");
				  }
	
	
			  //handle adblock => memberlevel
			  if (Filter::$id)
				  self::$db->delete(self::amTable, "adblock_id = " . Filter::$id);
	
			  if (is_array($_POST['userlevel'])) {
				  $sqlInsert = 'INSERT INTO ' . self::amTable . ' (adblock_id, memberlevel_id) VALUES ';
				  foreach ($_POST['userlevel'] as $ulevel)
					  $sqlInsert .= "(" . Filter::$id . ",{$ulevel}),";
	
				  $sqlInsert = rtrim($sqlInsert, ',');
				  self::$db->query($sqlInsert);
			  }
	
			  if (self::$db->affected()) {
				  Security::writeLog($message, "", "no", "module");
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk($message, false);
			  } else {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
			  }
			  print json_encode($json);
	
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }

      /**
       * AdBlock::checkDate($date)
       *
       * @return
       */
      private static function checkDate($date)
      {
          if (date('dd/mm/YYYY', strtotime($date)) == $date) {
              return true;
          } else {
              return false;
          }
      }

      /**
       * AdBlock::incrementViewsNumbers()
       *
       * @return
       */
      public function incrementViewsNumber()
      {
          if (Filter::$id) {
              $data['total_views'] = "INC(1)";
              self::$db->update(self::mTable, $data, "id = " . Filter::$id);
          }

      }

      /**
       * AdBlock::incrementClicksNumbers()
       *
       * @return
       */
      public function incrementClicksNumber()
      {

          if (Filter::$id) {
              $data['total_clicks'] = "INC(1)";
              self::$db->update(self::mTable, $data, "id = " . Filter::$id);
          }

      }

  }
?>