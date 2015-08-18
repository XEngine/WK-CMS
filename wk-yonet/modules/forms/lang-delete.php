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
  self::$db->query("LOCK TABLES mod_forms WRITE");
  self::$db->query("ALTER TABLE mod_forms DROP COLUMN title_" . $flag_id);
  self::$db->query("ALTER TABLE mod_forms DROP COLUMN subject_" . $flag_id);
  self::$db->query("ALTER TABLE mod_forms DROP COLUMN html_" . $flag_id);
  self::$db->query("ALTER TABLE mod_forms DROP COLUMN data_" . $flag_id);
  self::$db->query("ALTER TABLE mod_forms DROP COLUMN sendmessage_" . $flag_id);
  self::$db->query("ALTER TABLE mod_forms DROP COLUMN sbutton_" . $flag_id);
  self::$db->query("ALTER TABLE mod_forms DROP COLUMN template_" . $flag_id);
  self::$db->query("UNLOCK TABLES");
  
  self::$db->query("LOCK TABLES mod_forms_fields WRITE");
  self::$db->query("ALTER TABLE mod_forms_fields DROP COLUMN title_" . $flag_id);
  self::$db->query("ALTER TABLE mod_forms_fields DROP COLUMN desc_" . $flag_id);
  self::$db->query("ALTER TABLE mod_forms_fields DROP COLUMN msgerror_" . $flag_id);
  self::$db->query("ALTER TABLE mod_forms_fields DROP COLUMN tooltip_" . $flag_id);
  self::$db->query("ALTER TABLE mod_forms_fields DROP COLUMN html_" . $flag_id);
  self::$db->query("UNLOCK TABLES");
?>