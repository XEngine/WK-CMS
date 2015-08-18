<?php
  /**
   * Language Data Delete
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2010
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php
	self::$db->query("LOCK TABLES plug_poll_options WRITE");
	self::$db->query("ALTER TABLE plug_poll_options DROP COLUMN value_" . $flag_id);
	self::$db->query('UNLOCK TABLES');
  
	self::$db->query("LOCK TABLES plug_poll_questions WRITE");
	self::$db->query("ALTER TABLE plug_poll_questions DROP COLUMN question_" . $flag_id);
	self::$db->query("UNLOCK TABLES");
?>