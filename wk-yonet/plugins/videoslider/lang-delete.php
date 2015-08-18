<?php
  /**
   * Language Data Delete
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php
	self::$db->query("LOCK TABLES plug_videoslider WRITE");
	self::$db->query("ALTER TABLE plug_videoslider DROP COLUMN title_" . $flag_id);
	self::$db->query("UNLOCK TABLES");
?>