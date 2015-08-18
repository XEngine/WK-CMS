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
  self::$db->query("LOCK TABLES mod_forms WRITE");
  self::$db->query("ALTER TABLE mod_forms ADD title_$flag_id VARCHAR(100) NOT NULL AFTER title_en");
  self::$db->query("ALTER TABLE mod_forms ADD subject_$flag_id VARCHAR(150) NOT NULL AFTER subject_en");
  self::$db->query("ALTER TABLE mod_forms ADD html_$flag_id TEXT AFTER html_en");
  self::$db->query("ALTER TABLE mod_forms ADD data_$flag_id TEXT AFTER data_en");
  self::$db->query("ALTER TABLE mod_forms ADD sendmessage_$flag_id VARCHAR(200) NOT NULL AFTER sendmessage_en");
  self::$db->query("ALTER TABLE mod_forms ADD sbutton_$flag_id VARCHAR(100) NOT NULL AFTER sbutton_en");
  self::$db->query("ALTER TABLE mod_forms ADD template_$flag_id TEXT AFTER template_en");
  self::$db->query("UNLOCK TABLES");

  if ($mod_forms = self::$db->fetch_all("SELECT * FROM mod_forms")) {
      foreach ($mod_forms as $row) {
          $data['title_' . $flag_id] = $row->title_en;
          $data['subject_' . $flag_id] = $row->subject_en;
		  $data['html_' . $flag_id] = $row->html_en;
		  $data['data_' . $flag_id] = $row->data_en;
		  $data['sendmessage_' . $flag_id] = $row->sendmessage_en;
		  $data['sbutton_' . $flag_id] = $row->sbutton_en;
		  $data['template_' . $flag_id] = $row->template_en;
		  
          self::$db->update("mod_forms", $data, "id = " . $row->id);
      }
      unset($data, $row);
  }
  
  self::$db->query("LOCK TABLES mod_forms_fields WRITE");
  self::$db->query("ALTER TABLE mod_forms_fields ADD title_$flag_id VARCHAR(100) NOT NULL AFTER title_en");
  self::$db->query("ALTER TABLE mod_forms_fields ADD desc_$flag_id TEXT AFTER desc_en");
  self::$db->query("ALTER TABLE mod_forms_fields ADD msgerror_$flag_id VARCHAR(200) NOT NULL AFTER msgerror_en");
  self::$db->query("ALTER TABLE mod_forms_fields ADD tooltip_$flag_id VARCHAR(200) NOT NULL AFTER tooltip_en");
  self::$db->query("ALTER TABLE mod_forms_fields ADD html_$flag_id TEXT AFTER html_en");
  self::$db->query("UNLOCK TABLES");
  
  if ($mod_forms_fields = self::$db->fetch_all("SELECT * FROM mod_forms_fields")) {
      foreach ($mod_forms_fields as $row) {
          $data['title_' . $flag_id] = $row->title_en;
          $data['desc_' . $flag_id] = $row->desc_en;
		  $data['msgerror_' . $flag_id] = $row->msgerror_en;
		  $data['tooltip_' . $flag_id] = $row->tooltip_en;
		  $data['html_' . $flag_id] = $row->html_en;
		  
          self::$db->update("mod_forms_fields", $data, "id = " . $row->id);
      }
      unset($data, $row);
  }
?>