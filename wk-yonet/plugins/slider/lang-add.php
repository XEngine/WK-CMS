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
  self::$db->query("LOCK TABLES plug_slider WRITE");
  self::$db->query("ALTER TABLE plug_slider ADD title_$flag_id VARCHAR(150) NOT NULL AFTER title_en");
  self::$db->query("ALTER TABLE plug_slider ADD body_$flag_id TEXT AFTER body_en");
  self::$db->query("UNLOCK TABLES");

  if ($plug_slider = self::$db->fetch_all("SELECT * FROM plug_slider")) {
      foreach ($plug_slider as $row) {
          $data['title_' . $flag_id] = $row->title_en;
          $data['body_' . $flag_id] = $row->body_en;
          self::$db->update("plug_slider", $data, "id = " . $row->id);
      }
      unset($data, $row);
  }
?>