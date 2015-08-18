<?php
  /**
   * Comments Class
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  class Comments
  {
	  const mTable = "mod_comments";


      /**
       * Comments::__construct()
       * 
       * @return
       */
      function __construct()
      {
		  $this->getConfig();
      }

	  
	  /**
	   * Comments::getConfig()
	   * 
	   * @return
	   */
	  private function getConfig()
	  {
	
		  $row = INI::read(MODPATH . 'comments/config.ini');
	
		  $this->username_req = $row->com_config->username_req;
		  $this->email_req = $row->com_config->show_captcha;
		  $this->show_captcha = $row->com_config->show_captcha;
		  $this->show_www = $row->com_config->show_www;
		  $this->show_username = $row->com_config->show_username;
		  $this->show_email = $row->com_config->show_email;
		  $this->auto_approve = $row->com_config->auto_approve;
		  $this->public_access = $row->com_config->public_access;
		  $this->notify_new = $row->com_config->notify_new;
		  $this->sorting = $row->com_config->sorting;
		  $this->blacklist_words = $row->com_config->blacklist_words;
		  $this->char_limit = $row->com_config->char_limit;
		  $this->perpage = $row->com_config->perpage;
		  $this->dateformat = $row->com_config->dateformat;
	
		  return ($row) ? $row : 0;
	  }

	  /**
	   * Comments::updateConfig()
	   * 
	   * @return
	   */
	  public function processConfig()
	  {
		  
		  Filter::checkPost('perpage', Lang::$word->_MOD_CM_PERPAGE);
		  
		  if (empty(Filter::$msgs)) {
			  $data = array(
				  'com_config' => array(
					  'username_req' => intval($_POST['username_req']),
					  'email_req' => intval($_POST['email_req']),
					  'show_captcha' => intval($_POST['show_captcha']),
					  'show_www' => intval($_POST['show_www']),
					  'show_username' => intval($_POST['show_username']),
					  'show_email' => intval($_POST['show_email']),
					  'auto_approve' => intval($_POST['auto_approve']),
					  'notify_new' => intval($_POST['notify_new']),
					  'public_access' => intval($_POST['public_access']),
					  'sorting' => sanitize($_POST['sorting']),
					  'blacklist_words' => sanitize($_POST['blacklist_words']),
					  'char_limit' => intval($_POST['char_limit']),
					  'perpage' => intval($_POST['perpage']),
					  'dateformat' => sanitize($_POST['dateformat']),
				  ));

			  if (INI::write(MODPATH . 'comments/config.ini', $data)) {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk(Lang::$word->_MOD_CM_UPDATED, false);
				  Security::writeLog(Lang::$word->_MOD_CM_UPDATED, "", "no", "module");
			  } else {
				  $json['type'] = 'info';
				  $json['message'] = Filter::msgAlert(Lang::$word->_PROCCESS_C_ERR . '{admin/modules/comments/config.ini}', false);
			  }
			  print json_encode($json);
			   
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }
	  	  
	  /**
	   * Comments::getComments()
	   * 
	   * @return
	   */
	  public function getComments()
	  {
	
		  if (isset($_POST['fromdate_submit']) && $_POST['fromdate_submit'] <> "" || isset($from) && $from != '') {
			  $enddate = date("Y-m-d");
			  $fromdate = (empty($from)) ? $_POST['fromdate_submit'] : $from;
			  if (isset($_POST['enddate_submit']) && $_POST['enddate_submit'] <> "") {
				  $enddate = $_POST['enddate_submit'];
			  }
			  $where = " WHERE c.created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";
	
			  $q = "SELECT COUNT(*) FROM " . self::mTable . " WHERE created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59' LIMIT 1";
			  $record = Registry::get("Database")->query($q);
			  $total = Registry::get("Database")->fetchrow($record);
			  $counter = $total[0];
		  } else {
			  $where = null;
			  $counter = countEntries(self::mTable);
		  }
	
		  $pager = Paginator::instance();
		  $pager->items_total = $counter;
		  $pager->default_ipp = Registry::get("Core")->perpage;
		  $pager->paginate();
	
		  $sql = "SELECT c.*, c.id as cid, p.id as id, p.title" . Lang::$lang . " as title" 
		  . "\n FROM " . self::mTable . " as c" 
		  . "\n LEFT JOIN pages AS p ON p.id = c.page_id" 
		  . "\n " . $where . "" . "\n ORDER BY c.created " . $pager->limit;
		  $row = Registry::get("Database")->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  }

	  /**
	   * Comments::getDateFormat()
	   * 
	   * @param bool $selected
	   * @return
	   */
	  public static function getDateFormat($selected = false)
	  {
		  $format = (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') ? "%#d" : "%e";
		  $arr = array(
			  '%m-%d-%Y' => strftime('%m-%d-%Y') . ' (MM-DD-YYYY)',
			  $format . '-%m-%Y' => strftime($format . '-%m-%Y') . ' (D-MM-YYYY)',
			  '%m-' . $format . '-%y' => strftime('%m-' . $format . '-%y') . ' (MM-D-YY)',
			  $format . '-%m-%y' => strftime($format . '-%m-%y') . ' (D-MMM-YY)',
			  '%d %b %Y' => strftime('%d %b %Y'),
			  '%B %d, %Y %I:%M %p' => strftime('%B %d, %Y %I:%M %p'),
			  '%d %B %Y %I:%M %p' => strftime('%d %B %Y %I:%M %p'),
			  '%B %d, %Y' => strftime('%B %d, %Y'),
			  '%d %B, %Y' => strftime('%d %B, %Y'),
			  '%A %d %B %Y' => strftime('%A %d %B %Y'),
			  '%A %d %B %Y %H:%M' => strftime('%A %d %B %Y %H:%M'),
			  '%a %d, %B' => strftime('%a %d, %B'));
	
		  $html = '';
		  foreach ($arr as $key => $val) {
			  if ($key == $selected) {
				  $html .= "<option selected=\"selected\" value=\"" . $key . "\">" . utf8_encode($val) . "</option>\n";
			  } else
				  $html .= "<option value=\"" . $key . "\">" . utf8_encode($val) . "</option>\n";
		  }
		  unset($val);
		  return $html;
	  }

	  /**
	   * Comments::censored()
	   *
	   * @param mixed $string
	   * @return
	   */
	  public function censored($string)
	  {
		  $array = explode(",", $this->blacklist_words);
		  reset($array);
	
		  foreach ($array as $row) {
			  $string = preg_replace("`$row`", "***", $string);
		  }
		  unset($row);
		  return $string;
	  }
  
	  /**
	   * Comments::keepTags()
	   *
	   * @param mixed $string
	   * @param mixed $allowtags
	   * @param mixed $allowattributes
	   * @return
	   */
	  public static function keepTags($string, $allowtags = null, $allowattributes = null)
	  {
		  $string = strip_tags($string, $allowtags);
		  if (!is_null($allowattributes)) {
			  if (!is_array($allowattributes))
				  $allowattributes = explode(",", $allowattributes);
			  if (is_array($allowattributes))
				  $allowattributes = implode(")(?<!", $allowattributes);
			  if (strlen($allowattributes) > 0)
				  $allowattributes = "(?<!" . $allowattributes . ")";
			  $string = preg_replace_callback("/<[^>]*>/i", create_function('$matches', 'return preg_replace("/ [^ =]*' . $allowattributes . '=(\"[^\"]*\"|\'[^\']*\')/i", "", $matches[0]);'), $string);
		  }
		  return $string;
	  }
  }
?>