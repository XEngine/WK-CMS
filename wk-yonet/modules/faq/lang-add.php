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
  self::$db->query("LOCK TABLES mod_faq WRITE");
  self::$db->query("ALTER TABLE mod_faq ADD question_$flag_id VARCHAR(150) NOT NULL AFTER question_en");
  self::$db->query("ALTER TABLE mod_faq ADD answer_$flag_id TEXT AFTER answer_en");
  self::$db->query("UNLOCK TABLES");

  if ($mod_faq = self::$db->fetch_all("SELECT * FROM mod_faq")) {
      foreach ($mod_faq as $row) {
          $data = array(
              'question_' . $flag_id => $row->question_en,
              'answer_' . $flag_id => $row->answer_en);

          self::$db->update("mod_faq", $data, "id = " . $row->id);
      }
      unset($data, $row);
  }
?>