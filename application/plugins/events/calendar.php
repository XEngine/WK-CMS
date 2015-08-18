<?php
  /**
   * Calendar
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  define("_VALID_PHP", true);
  
  require_once("../../init.php");
  require_once(MODPATH . "events/admin_class.php");

  Registry::set('eventManager',new eventManager());
  Registry::get("eventManager")->weekDayNameLength = "short";

?>
<?php Registry::get("eventManager")->renderCalendar('small');?>