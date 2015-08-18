<?php
  /**
   * jQuery Tabs Class
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2010
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  class jTabs
  {
      
	  const mTable = "plug_tabs";
	  private static $db;


      /**
       * jTabs::__construct()
       * 
       * @return
       */
      function __construct()
      {
		  self::$db = Registry::get("Database");
      }
	  
	  /**
	   * jTabs::getTabs()
	   * 
	   * @return
	   */
	  public function getTabs()
	  {
		  
		  $sql = "SELECT * FROM " . self::mTable . " ORDER BY position";
		  $row = self::$db->fetch_all($sql);
		  
		  return ($row) ? $row : 0;
	  }

	  /**
	   * jTabs::renderTabs()
	   * 
	   * @return
	   */
	  public function renderTabs()
	  {
		  
		  $sql = "SELECT * FROM " . self::mTable
		  . "\n WHERE active = 1"
		  . "\n ORDER BY position";
		  $row = self::$db->fetch_all($sql);
		  
		  return ($row) ? $row : 0;
	  }
	  	  
	  /**
	   * jTabs::processTabs()
	   * 
	   * @return
	   */
	  public function processTabs()
	  {
	
		  Filter::checkPost('title' . Lang::$lang, Lang::$word->_PLG_JT_TITLE);
		  Filter::checkPost('body' . Lang::$lang, Lang::$word->_PLG_JT_BODY);
	
		  if (empty(Filter::$msgs)) {
			  $data = array(
				  'title' . Lang::$lang => sanitize($_POST['title' . Lang::$lang]),
				  'body' . Lang::$lang => Filter::in_url($_POST['body' . Lang::$lang]),
				  'active' => intval($_POST['active'])
				  );
	
			  (Filter::$id) ? self::$db->update(self::mTable, $data, "id=" . Filter::$id) : $lastid = self::$db->insert(self::mTable, $data);
			  $message = (Filter::$id) ? Lang::$word->_PLG_JT_UPDATED : Lang::$word->_PLG_JT_ADDED;
	
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
	   * jTabs::updateOrder()
	   * 
	   * @return
	   */
	  public static function updateOrder()
	  {
		  foreach ($_POST['node'] as $k => $v) {
			  $p = $k + 1;
			  $data['position'] = intval($p);
			  self::$db->update(self::mTable, $data, "id='" . (int)$v . "'");
		  }
		  
	  }
  }
?>