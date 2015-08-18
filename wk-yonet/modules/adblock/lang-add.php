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
  self::$db->query("LOCK TABLES mod_adblock WRITE");
  self::$db->query("ALTER TABLE mod_adblock ADD COLUMN title_$flag_id VARCHAR(100) NOT NULL AFTER title_en");
  self::$db->query("UNLOCK TABLES");

  if ($mod_adblock = self::$db->fetch_all("SELECT * FROM mod_adblock")) {
      foreach ($mod_adblock as $row) {
          $data['title_' . $flag_id] = $row->title_en;
          self::$db->update("mod_adblock", $data, "id = " . $row->id);
      }
      unset($data, $row);
  }
?>