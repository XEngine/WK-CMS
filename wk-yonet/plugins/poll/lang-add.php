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
  self::$db->query('LOCK TABLES plug_poll_options WRITE');
  self::$db->query("ALTER TABLE plug_poll_options ADD value_$flag_id VARCHAR(250) NOT NULL AFTER value_en");
  self::$db->query('UNLOCK TABLES');

  if ($plug_poll_options = self::$db->fetch_all("SELECT * FROM plug_poll_options")) {
      foreach ($plug_poll_options as $row) {
          $data['value_' . $flag_id] = $row->value_en;
          self::$db->update("plug_poll_options", $data, "id = " . $row->id);
      }
      unset($data, $row);
  }

  self::$db->query('LOCK TABLES plug_poll_questions WRITE');
  self::$db->query("ALTER TABLE plug_poll_questions ADD question_$flag_id VARCHAR(250) NOT NULL AFTER question_en");
  self::$db->query('UNLOCK TABLES');

  if ($plug_poll_questions = self::$db->fetch_all("SELECT * FROM plug_poll_questions")) {
      foreach ($plug_poll_questions as $row) {
          $data['question_' . $flag_id] = $row->question_en;
          self::$db->update("plug_poll_questions", $data, "id = " . $row->id);
      }
      unset($data, $row);
  }
?>