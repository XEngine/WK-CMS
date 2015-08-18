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
  self::$db->query("LOCK TABLES mod_portfolio WRITE");
  self::$db->query("ALTER TABLE mod_portfolio DROP COLUMN title_" . $flag_id);
  self::$db->query("ALTER TABLE mod_portfolio DROP COLUMN short_desc_" . $flag_id);
  self::$db->query("ALTER TABLE mod_portfolio DROP COLUMN detail_" . $flag_id);
  self::$db->query("ALTER TABLE mod_portfolio DROP COLUMN body_" . $flag_id);
  self::$db->query("ALTER TABLE mod_portfolio DROP COLUMN result_" . $flag_id);
  self::$db->query("ALTER TABLE mod_portfolio DROP COLUMN metakey_" . $flag_id);
  self::$db->query("ALTER TABLE mod_portfolio DROP COLUMN metadesc_" . $flag_id);
  self::$db->query("UNLOCK TABLES");

  self::$db->query("LOCK TABLES mod_portfolio_category WRITE");
  self::$db->query("ALTER TABLE mod_portfolio_category DROP COLUMN title_" . $flag_id);
  self::$db->query("ALTER TABLE mod_portfolio_category DROP COLUMN metakey_" . $flag_id);
  self::$db->query("ALTER TABLE mod_portfolio_category DROP COLUMN metadesc_" . $flag_id);
  self::$db->query("UNLOCK TABLES");
?>