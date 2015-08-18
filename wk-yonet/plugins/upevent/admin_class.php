<?php
  /**
   * upEvent Class
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  class upEvent
  {
      
	  const mTable = "mod_events";

      /**
       * upEvent::__construct()
       * 
       * @return
       */
      function __construct()
      {
		  $this->getconfig();
      }

	  
	  /**
	   * upEvent::getEvent()
	   * 
	   * @return
	   */
	  public function getEvent()
	  {
		  
		  $sql = "SELECT * FROM " . self::mTable . " WHERE id = " . $this->event_id;
		  $row = Registry::get("Database")->first($sql);
		  
		  return ($row) ? $row : 0;
	  }

	  /**
	   * upEvent::getconfig()
	   * 
	   * @return
	   */
	  private function getconfig()
	  {
		  $row = INI::read(PLUGPATH . 'upevent/config.ini');
		  $this->event_id = $row->upev_config->event_id;
	
		  return ($row) ? $row : 0;

	  }

	  /**
	   * upEvent::getconfig()
	   * 
	   * @return
	   */
	  public static function get_time_difference($start, $end)
	  {
	
		  $uts['start'] = strtotime($start);
		  $uts['end'] = strtotime($end);
		  if ($uts['start'] !== -1 && $uts['end'] !== -1) {
			  if ($uts['end'] >= $uts['start']) {
				  $diff = $uts['end'] - $uts['start'];
				  if ($days = intval((floor($diff / 86400)))) {
					  $diff = $diff % 86400;
				  }
				  if ($hours = intval((floor($diff / 3600)))) {
					  $h = $diff % 3600;
					  $diff = ($h > 10) ? '0' . $h : $h;
				  }
				  if ($minutes = intval((floor($diff / 60)))) {
					  $diff = $diff % 60;
				  }
				  $diff = intval($diff);
	
				  $days = ($days < 10) ? '0' . $days : $days;
				  $minutes = ($minutes < 10) ? '0' . $minutes : $minutes;
				  $diff = ($diff < 10) ? '0' . $diff : $diff;
				  $hours = ($hours < 10) ? '0' . $hours : $hours;
	
				  return (array(
					  'days' => $days,
					  'hours' => $hours,
					  'minutes' => $minutes,
					  'seconds' => $diff));
			  } else {
				  return false;
				  Filter::msgSingleError("Ending date/time is earlier than the start date/time.");
			  }
		  } else {
			  return false;
			  Filter::msgSingleError("Invalid date/time data detected");
		  }
		  return (false);
	  }


	  /**
	   * upEvent::processConfig()
	   * 
	   * @return
	   */
	  public function processConfig()
	  {
	
		  Filter::checkPost('event_id', Lang::$word->_PLG_UE_SELECT);
	
		  if (empty(Filter::$msgs)) {
			  $data = array('upev_config' => array('event_id' => intval($_POST['event_id'])));
	
			  if (INI::write(PLUGPATH . 'upevent/config.ini', $data)) {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk(Lang::$word->_PLG_UE_UPDATED, false);
				  Security::writeLog(Lang::$word->_PLG_UE_UPDATED, "", "no", "plugin");
			  } else {
				  $json['type'] = 'info';
				  $json['message'] = Filter::msgAlert(Lang::$word->_PROCCESS_C_ERR . '{admin/plugins/upevent/config.ini}', false);
			  }
			  print json_encode($json);
	
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }
  }
?>