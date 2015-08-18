<?php
  /**
   * NewsSlider Class
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  class newsSlider
  {
      
	  const mTable = "plug_newsslider";
	  private static $db;


      /**
       * newsSlider::__construct()
       * 
       * @return
       */
      function __construct()
      {
		  self::$db = Registry::get("Database");
      }

	  
	  /**
	   * newsSlider::getNewsItems()
	   * 
	   * @return
	   */
	  public function getNewsItems()
	  {
		  
		  $sql = "SELECT * FROM " . self::mTable . " ORDER BY position";
		  $row = self::$db->fetch_all($sql);
		  
		  return ($row) ? $row : 0;
	  }

	  /**
	   * newsSlider::renderNewsItems()
	   * 
	   * @return
	   */
	  public function renderNewsItems()
	  {
		  
		  $sql = "SELECT * FROM " . self::mTable
		  . "\n WHERE active = 1"
		  . "\n ORDER BY position";
		  $row = self::$db->fetch_all($sql);
		  
		  return ($row) ? $row : 0;
	  }
	  	  
	  /**
	   * newsSlider::processNews()
	   * 
	   * @return
	   */
	  public function processNews()
	  {
	
		  Filter::checkPost('title' . Lang::$lang, Lang::$word->_PLG_NS_TITLE);
		  Filter::checkPost('body' . Lang::$lang, Lang::$word->_PLG_NS_BODY);
	
		  if (empty(Filter::$msgs)) {
			  $data = array(
				  'title' . Lang::$lang => sanitize($_POST['title' . Lang::$lang]),
				  'body' . Lang::$lang => Filter::in_url($_POST['body' . Lang::$lang]),
				  'show_title' => intval($_POST['show_title']),
				  'show_created' => intval($_POST['show_created']),
				  'active' => intval($_POST['active'])
				  );
			  
			  if (!Filter::$id)
				  $data['created'] = "NOW()";
	
			  (Filter::$id) ? self::$db->update(self::mTable, $data, "id=" . Filter::$id) : $lastid = self::$db->insert(self::mTable, $data);
			  $message = (Filter::$id) ? Lang::$word->_PLG_NS_UPDATED : Lang::$word->_PLG_NS_ADDED;
	
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
	   * newsSlider::updateOrder()
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