<?php
  /**
   * Google Maps Class
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */

  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  class slideCMS
  {

      const mTable = "mod_wkslider_slides";
	  const dTable = "mod_wkslider_slides_data";
      const pTable = "plugins";
      const pluginspath = "plugins/slidecms/";
	  const maxFile = 3145728;
	  private static $fileTypes = array("jpg","jpeg","png");
	  
	  private static $db;


      /**
       * slideCMS::__construct()
       * 
       * @return
       */
      function __construct($item = false, $cat = false)
      {
		  self::$db = Registry::get("Database");
      }



      /**
       * slideCMS::getSliders()
       * 
       * @return
       */
      public function getSliders()
      {

		  $pager = Paginator::instance();
		  $pager->items_total = countEntries(self::mTable);
		  $pager->default_ipp = Registry::get("Core")->perpage;
		  $pager->paginate();
		  
          $sql = "SELECT *" 
		  . "\n FROM " . self::mTable
		  . "\n ORDER BY title" . $pager->limit;
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * slideCMS::getSliderData()
       * 
	   * @param bool $sid
       * @return
       */
      public function getSliderData($sid = false)
      {
		  
		  $id = ($sid) ? $sid : Filter::$id;

          $sql = "SELECT *" 
		  . "\n FROM " . self::dTable
		  . "\n WHERE slider_id = '".(int)$id."'"
		  . "\n ORDER BY sorting";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }
                
      /**
       * slideCMS::editSlider()
       * 
       * @return
       */
      public function editSlider()
      {

          Filter::checkPost('title', Lang::$word->_MOD_SLC_NAME);

          if (empty(Filter::$msgs)) {
              $data = array(
                  'height' => empty($_POST['height']) ? 400 :  intval($_POST['height']),
                  'navtype' => sanitize($_POST['navtype']),
                  'navpos' => sanitize($_POST['navpos']),
				  'navplace' => sanitize($_POST['navplace']),
                  'navarrows' => intval($_POST['navarrows']),
				  'fullscreen' => intval($_POST['fullscreen']),
				  'transition' => sanitize($_POST['transition']),
				  'durration' => intval($_POST['durration']),
				  'captions' => intval($_POST['captions']),
				  'autoplay' => intval($_POST['autoplay']),
				  'loop' => intval($_POST['loop']),
				  'fit' => sanitize($_POST['fit']),
				  'shuffle' => intval($_POST['shuffle']),
				  );


			  self::$db->update(self::mTable, $data, "id=" . Filter::$id);
			  $message = Lang::$word->_MOD_SLC_GUPDATED;
	
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
       * slideCMS::addSlider()
       * 
       * @return
       */
	  public function addSlider()
	  {
	
          Filter::checkPost('title', Lang::$word->_MOD_SLC_NAME);

          if (empty(Filter::$msgs)) {
			  $data = array(
				  'title' => sanitize($_POST['title']),
				  'height' => empty($_POST['height']) ? 400 : intval($_POST['height']),
				  'plug_name' => "slidecms/" . sanitize(doSeo($_POST['title']),25),
				  'navtype' => sanitize($_POST['navtype']),
				  'navpos' => sanitize($_POST['navpos']),
				  'navplace' => sanitize($_POST['navplace']),
				  'navarrows' => intval($_POST['navarrows']),
				  'fullscreen' => intval($_POST['fullscreen']),
				  'transition' => sanitize($_POST['transition']),
				  'durration' => empty($_POST['durration']) ? 350 : intval($_POST['durration']),
				  'captions' => intval($_POST['captions']),
				  'autoplay' => intval($_POST['autoplay']),
				  'loop' => intval($_POST['loop']),
				  'fit' => sanitize($_POST['fit']),
				  'shuffle' => intval($_POST['shuffle']),
				  );
	
			  $last_id = self::$db->insert(self::mTable, $data);
	
			  $plugin_file_main = BASEPATH . slideCMS::pluginspath . 'main.php';
			  $slider_clean = str_replace('slidecms/', '', $data['plug_name']);
			  $plugin_file = BASEPATH . slideCMS::pluginspath . $slider_clean . '/main.php';
			  mkdir(str_replace('/main.php', '', $plugin_file));
			  file_put_contents($plugin_file, str_replace('###SLIDERID###', $last_id, file_get_contents($plugin_file_main)));
			  mkdir(BASEPATH . 'plugins/' . $data['plug_name'] . '/slides');
	
			  $datap = array(
				  'title' . Lang::$lang => 'Slider - ' . $slider_clean,
				  'system' => 1,
				  'plugalias' => $data['plug_name'],
				  'created' => "NOW()",
				  'active' => 1,
				  );

			  $result = self::$db->insert(self::pTable, $datap);
			  $message = Lang::$word->_MOD_SLC_GADDED;
	
			  if ($result) {
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
       * Gallery::doUpload()
       * 
       * @param mixed $filename
       * @return
       */
	  public static function doUpload($filename)
	  {
		  $path = BASEPATH . 'plugins/' . $_REQUEST['sfolder'] . '/slides/';
	
		  if (isset($_FILES[$filename]) && $_FILES[$filename]['error'] == 0) {
	
			  $extension = pathinfo($_FILES[$filename]['name'], PATHINFO_EXTENSION);
			  if (!in_array(strtolower($extension), self::$fileTypes)) {
				  $json['status'] = "error";
				  $json['msg'] = str_replace("[EXT]", $extension, Lang::$word->_FM_FILE_ERR5);
				  print json_encode($json);
				  exit;
			  }
	
			  if (file_exists($path . $_FILES[$filename]['name'])) {
				  $json['status'] = "error";
				  $json['msg'] = Lang::$word->_FM_FILE_ERR1;
				  print json_encode($json);
				  exit;
			  }
	
			  if (!is_writeable($path)) {
				  $json['status'] = "error";
				  $json['msg'] = Lang::$word->_FM_FILE_ERR2;
				  print json_encode($json);
				  exit;
			  }
	
			  if (!is_dir($path)) {
				  $json['status'] = "error";
				  $json['msg'] = Lang::$word->_FM_FILE_ERR4;
				  print json_encode($json);
				  exit;
			  }
	
			  if (self::maxFile != null && self::maxFile < $_FILES[$filename]['size']) {
				  $json['status'] = "error";
				  $json['msg'] = str_replace("[LIMIT]", getSize(self::maxFile), Lang::$word->_FM_FILE_ERR3);
				  print json_encode($json);
				  exit;
			  }
	
			  $newName = "IMG_" . randName();
			  $ext = substr($_FILES[$filename]['name'], strrpos($_FILES[$filename]['name'], '.') + 1);
			  $fullname = $path . $newName . "." . strtolower($ext);
	
	
			  if (move_uploaded_file($_FILES[$filename]['tmp_name'], $fullname)) {
	
				  $data = array(
					  'slider_id' => Filter::$id,
					  'data' => $newName . "." . strtolower($ext),
					  'data_type' => "img", 
					  'caption' . Lang::$lang => "-/-",
					  'created' => "NOW()"
					  );
	
				  $last_id = self::$db->insert(self::dTable, $data);
				  $url = SITEURL . '/plugins/' . $_REQUEST['sfolder'] . '/slides/' . $data['data'];

				  $html = '<div class="item">';
				  $html .= '<a href="' . $url . '" class="lightbox" title="-/-"><img src="' . $url . '" alt="" class="wk image"></a>';
				  $html .= '<a data-id="' . $last_id . '" data-type="img" data-name="-/-" class="imgdelete wk top right negative corner label"><i class="icon remove sign"></i></a>
					<div class="wk-content">
					  <div contenteditable="true" data-path="false" data-edit-type="cslidecms" data-id="' . $last_id . '" data-key="title" class="wk editable">-/-</div>
					</div>
				  </div>';
	
				  $json['status'] = "success";
				  $json['msg'] = $html;
				  print json_encode($json);
				  exit;
			  }
		  }
	
		  $json['status'] = "error";
		  exit;
	  }
  }
?>