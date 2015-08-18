<?php
  /**
   * Language Data Add
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
	self::$db->query("LOCK TABLES mod_slidecms_data WRITE");
	self::$db->query("ALTER TABLE mod_slidecms_data ADD COLUMN caption_$flag_id VARCHAR(100) NOT NULL AFTER caption_en");
	self::$db->query("UNLOCK TABLES");

	if($mod_slidecms_data = self::$db->fetch_all("SELECT * FROM mod_slidecms_data")) {
		foreach ($mod_slidecms_data as $row) {
			$data['caption_' . $flag_id] = $row->caption_en;
			self::$db->update("mod_slidecms_data", $data, "id = " . $row->id);
		}
		unset($data, $row);
	}
?>