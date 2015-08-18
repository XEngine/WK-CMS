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
  self::$db->query("LOCK TABLES mod_blog WRITE");
  self::$db->query("ALTER TABLE mod_blog DROP COLUMN title_" . $flag_id);
  self::$db->query("ALTER TABLE mod_blog DROP COLUMN short_desc_" . $flag_id);
  self::$db->query("ALTER TABLE mod_blog DROP COLUMN body_" . $flag_id);
  self::$db->query("ALTER TABLE mod_blog DROP COLUMN caption_" . $flag_id);
  self::$db->query("ALTER TABLE mod_blog DROP COLUMN tags_" . $flag_id);
  self::$db->query("ALTER TABLE mod_blog DROP COLUMN metakey_" . $flag_id);
  self::$db->query("ALTER TABLE mod_blog DROP COLUMN metadesc_" . $flag_id);
  self::$db->query("UNLOCK TABLES");

  self::$db->query("LOCK TABLES mod_blog_categories WRITE");
  self::$db->query("ALTER TABLE mod_blog_categories DROP COLUMN name_" . $flag_id);
  self::$db->query("ALTER TABLE mod_blog_categories DROP COLUMN description_" . $flag_id);
  self::$db->query("ALTER TABLE mod_blog_categories DROP COLUMN metakey_" . $flag_id);
  self::$db->query("ALTER TABLE mod_blog_categories DROP COLUMN metadesc_" . $flag_id);
  self::$db->query("UNLOCK TABLES");

  self::$db->query("LOCK TABLES plug_blog_tags WRITE");
  self::$db->query("ALTER TABLE plug_blog_tags DROP COLUMN tagname_" . $flag_id);
  self::$db->query("UNLOCK TABLES");
?>