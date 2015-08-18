<?php
  /**
   * videoSlider Class
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  class vSlider
  {
      
	  const mTable = "plug_videoslider";
	  private static $db;


      /**
       * vSlider::__construct()
       * 
       * @return
       */
      function __construct()
      {
		  self::$db = Registry::get("Database");
		  $this->getconfig();
      }

	  /**
	   * vSlider::getConfiguration()
	   * 
	   * @return
	   */
	  private function getconfig()
	  {
		  
		  $row = INI::read(PLUGPATH . 'videoslider/config.ini');
		  
		  $this->autoPlay = $row->vs_config->autoPlay;
		  $this->allowFullScreen = $row->vs_config->allowFullScreen;
		  $this->autohide = $row->vs_config->autohide;
		  $this->rel = $row->vs_config->rel;
		  $this->theme = $row->vs_config->theme;
		  $this->ycolor = $row->vs_config->ycolor;
		  $this->showinfo = $row->vs_config->showinfo;
		  $this->vq = $row->vs_config->vq;
		  $this->title = $row->vs_config->title;
		  $this->byline = $row->vs_config->byline;
		  $this->portrait = $row->vs_config->portrait;
		  $this->vcolor = $row->vs_config->vcolor;
	
		  return ($row) ? $row : 0;
	  }
 
	  /**
	   * vSlider::getSlides()
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
	   * vSlider::processSlide()
	   * 
	   * @return
	   */
	  public function processSlide()
	  {
	
		  Filter::checkPost('title' . Lang::$lang, Lang::$word->_PLG_VS_CAPTION);
		  Filter::checkPost('vidurl', Lang::$word->_PLG_VS_URL);
	
		  if (empty(Filter::$msgs)) {
			  $data = array(
				  'title' . Lang::$lang => sanitize($_POST['title' . Lang::$lang]),
				  'vidurl' => sanitize($_POST['vidurl'])
				  );
	
			  (Filter::$id) ? self::$db->update(self::mTable, $data, "id=" . Filter::$id) : $lastid = self::$db->insert(self::mTable, $data);
			  $message = (Filter::$id) ? Lang::$word->_PLG_VS_UPDATED : Lang::$word->_PLG_VS_ADDED;
	
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
	   * vSlider::processConfig()
	   * 
	   * @return
	   */
	  public function processConfig()
	  {
		  
		  Filter::checkPost('theme', Lang::$word->_PLG_VS_THEME);
		  
		  if (empty(Filter::$msgs)) {
			  $data = array('vs_config' => array(
					  'autoPlay' => intval($_POST['autoPlay']),
					  'allowFullScreen' => intval($_POST['allowFullScreen']),
					  'autohide' => intval($_POST['autohide']),
					  'rel' => intval($_POST['rel']),
					  'theme' => sanitize($_POST['theme']),
					  'ycolor' => sanitize($_POST['ycolor']),
					  'showinfo' => intval($_POST['showinfo']),
					  'vq' => sanitize($_POST['vq']),
					  'title' => intval($_POST['title']),
					  'byline' => intval($_POST['byline']),
					  'portrait' => intval($_POST['portrait']),
					  'vcolor' => sanitize(str_replace("#", "", $_POST['vcolor']))
					  ));
		  
			  if (INI::write(PLUGPATH . 'videoslider/config.ini', $data)) {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk(Lang::$word->_PLG_VS_CONF_UPDATED, false);
				  Security::writeLog(Lang::$word->_PLG_VS_CONF_UPDATED, "", "no", "plugin");
			  } else {
				  $json['type'] = 'info';
				  $json['message'] = Filter::msgAlert(Lang::$word->_PROCCESS_C_ERR . '{admin/plugins/videoslider/config.ini}', false);
			  }
			  print json_encode($json);
	
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }
	  
	  /**
	   * vSlider::updateOrder()
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