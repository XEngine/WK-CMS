<?php
  /**
   * Rss Class
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  class Rss
  {

      /**
       * Rss::__construct()
       * 
       * @return
       */
      function __construct()
      {
		  $this->getconfig();
      }
	  
	  /**
	   * Rss::getConfig()
	   * 
	   * @return
	   */
	  private function getconfig()
	  {
		  
		  $row = INI::read(PLUGPATH . 'rss/config.ini');
		  
		  $this->url = $row->rss_config->url;
		  $this->title_trim = $row->rss_config->title_trim;
		  $this->show_body = $row->rss_config->show_body;
		  $this->body_trim = $row->rss_config->body_trim;
		  $this->show_date = $row->rss_config->show_date;
		  $this->dateformat = $row->rss_config->dateformat;
		  $this->perpage = $row->rss_config->perpage;
	
		  return ($row) ? $row : 0;
	  }

	  	  
	  /**
	   * Rss::processConfig()
	   * 
	   * @return
	   */
	  public function processConfig()
	  {
	
		  Filter::checkPost('url', Lang::$word->_PLG_RSS_URL);
		  Filter::checkPost('perpage', Lang::$word->_PLG_RSS_ITEMS);
	
		  if (empty(Filter::$msgs)) {
			  $data = array('rss_config' => array(
					  'url' => '"' . sanitize($_POST['url']) . '"',
					  'title_trim' => intval($_POST['title_trim']),
					  'show_body' => intval($_POST['show_body']),
					  'body_trim' => intval($_POST['body_trim']),
					  'show_date' => intval($_POST['show_date']),
					  'dateformat' => sanitize($_POST['dateformat']),
					  'perpage' => intval($_POST['perpage']),
					  ));
	
			  if (INI::write(PLUGPATH . 'rss/config.ini', $data)) {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk(Lang::$word->_PLG_RSS_UPDATED, false);
				  Security::writeLog(Lang::$word->_PLG_RSS_UPDATED, "", "no", "plugin");
			  } else {
				  $json['type'] = 'info';
				  $json['message'] = Filter::msgAlert(Lang::$word->_PROCCESS_C_ERR . '{admin/plugins/rss/config.ini}', false);
			  }
			  print json_encode($json);
	
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }
					
	  /**
	   * Rss::getDateFormat()
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
				  $html .= "<option selected=\"selected\" value=\"" . $key . "\">" . $val . "</option>\n";
			  } else
				  $html .= "<option value=\"" . $key . "\">" . $val . "</option>\n";
		  }
		  unset($val);
		  return $html;
	  }
  }
?>