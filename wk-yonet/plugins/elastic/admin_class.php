<?php
  /**
   * Elastic Slider Class
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  class Elastic
  {
      
	  const mTable = "plug_elastic";
	  const imgPath = "plugins/elastic/imgdata/";
	  private static $db;

      /**
       * Elastic::__construct()
       * 
       * @return
       */
      function __construct()
      {
		  self::$db = Registry::get("Database");
		  $this->getconfig();
      }

	  /**
	   * Slider::getconfig()
	   * 
	   * @return
	   */
	  private function getconfig()
	  {
		  
		  $row = INI::read(PLUGPATH . 'elastic/config.ini');
		  
		  $this->animation = $row->es_config->animation;
		  $this->autoplay = $row->es_config->autoplay;
		  $this->interval = $row->es_config->interval;
		  $this->speed = $row->es_config->speed;
		  $this->titlespeed = $row->es_config->titlespeed;
		  $this->thumbMaxWidth = $row->es_config->thumbMaxWidth;
		  $this->height = $row->es_config->height;
	
		  return ($row) ? $row : 0;
	  }
	  
	  /**
	   * Elastic::getSliderImages()
	   * 
	   * @return
	   */
	  public function getSlides()
	  {
		  
		  $sql = "SELECT * FROM " . self::mTable . " ORDER BY position";
		  $row = self::$db->fetch_all($sql);
		  
		  return ($row) ? $row : 0;
	  }
	  
	  /**
	   * Elastic::processSlide()
	   * 
	   * @return
	   */
	  public function processSlide()
	  {
	
		  Filter::checkPost('title' . Lang::$lang, Lang::$word->_PLG_ES_CAPTION);
	
		  if (!Filter::$id) {
			  if (empty($_FILES['thumb']['name']))
				  Filter::$msgs['thumb'] = Lang::$word->_PLG_ES_IMG_SEL;
		  }
	
		  if (!empty($_FILES['thumb']['name'])) {
			  if (!preg_match("/(\.jpg|\.png)$/i", $_FILES['thumb']['name'])) {
				  Filter::$msgs['thumb'] = Lang::$word->_CG_LOGO_R;
			  }
			  $file_info = getimagesize($_FILES['thumb']['tmp_name']);
			  if (empty($file_info))
				  Filter::$msgs['thumb'] = Lang::$word->_CG_LOGO_R;
		  }
		  
		  if (empty(Filter::$msgs)) {
			  $data['title' . Lang::$lang] = sanitize($_POST['title' . Lang::$lang]);
			  $data['body' . Lang::$lang] = sanitize($_POST['body' . Lang::$lang]);
			  
			  // Procces Image
			  if (!empty($_FILES['thumb']['name'])) {
				  $filedir = BASEPATH . self::imgPath;
				  $newName = "FILE_" . randName();
				  $ext = substr($_FILES['thumb']['name'], strrpos($_FILES['thumb']['name'], '.') + 1);
				  $fullname = $filedir . $newName . "." . strtolower($ext);
	
				  if (Filter::$id and $file = getValueById("thumb", self::mTable, Filter::$id)) {
					  @unlink($filedir . $file);
				  }
	
				  if (!move_uploaded_file($_FILES['thumb']['tmp_name'], $fullname)) {
					  die(Filter::msgError(Lang::$word->_FILE_ERR, false));
				  }
				  $data['thumb'] = $newName . "." . strtolower($ext);
			  }
			  
			  (Filter::$id) ? self::$db->update(self::mTable, $data, "id=" . Filter::$id) : $lastid = self::$db->insert(self::mTable, $data);
			  $message = (Filter::$id) ? Lang::$word->_PLG_ES_UPDATED : Lang::$word->_PLG_ES_ADDED;
	
			  if (self::$db->affected()) {
				  Security::writeLog($message, "", "no", "plugin");
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
	   * Elastic::processConfig()
	   * 
	   * @return
	   */
	  public function processConfig()
	  {
		  
		  Filter::checkPost('height', Lang::$word->_PLG_ES_HEIGHT);
		  
		  if (empty(Filter::$msgs)) {
			  $data = array('es_config' => array(
					  'animation' => sanitize($_POST['animation']),
					  'autoplay' => intval($_POST['autoplay']),
					  'interval' => intval($_POST['interval']),
					  'speed' => intval($_POST['speed']),
					  'titlespeed' => intval($_POST['titlespeed']),
					  'thumbMaxWidth' => intval($_POST['thumbMaxWidth']),
					  'height' => intval($_POST['height'])
					  ));
					  
			  if (INI::write(PLUGPATH . 'elastic/config.ini', $data)) {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk(Lang::$word->_PLG_ES_CONF_UPDATED, false);
				  Security::writeLog(Lang::$word->_PLG_ES_CONF_UPDATED, "", "no", "plugin");
			  } else {
				  $json['type'] = 'info';
				  $json['message'] = Filter::msgAlert(Lang::$word->_PROCCESS_C_ERR . '{admin/plugins/elastic/config.ini}', false);
			  }
			  print json_encode($json);
	
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }

	  /**
	   * Elastic::updateOrder()
	   * 
	   * @return
	   */
	  public static function updateOrder()
	  {
		  	  
		  foreach ($_POST['node'] as $k => $v) {
			  $p = $k + 1;
			  $data['position'] = intval($p);
			  self::$db->update(self::mTable, $data, "id=" . (int)$v);
		  }
		  
	  }
  }
?>