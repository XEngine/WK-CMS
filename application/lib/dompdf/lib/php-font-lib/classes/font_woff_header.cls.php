<?php
/**
 * @package php-font-lib
 * @link    http://php-font-lib.googlecode.com/
 * @author  Fabien Ménager <fabien.menager@gmail.com>
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
 */

require_once dirname(__FILE__)."/font_truetype_header.cls.php";

/**
 * WOFF font file header.
 * 
 * @package php-font-lib
 */
class Font_WOFF_Header extends Font_TrueType_Header {
  protected $def = array(
    "format"         => self::uint32,
    "flavor"         => self::uint32,
    "length"         => self::uint32,
    "numTables"      => self::uint16,
                        self::uint16,
    "totalSfntSize"  => self::uint32,
    "majorversion 1.0 31/07/2015 14:00 | Webkokteyli Labs.
    "minorversion 1.0 31/07/2015 14:00 | Webkokteyli Labs.
    "metaOffset"     => self::uint32,
    "metaLength"     => self::uint32,
    "metaOrigLength" => self::uint32,
    "privOffset"     => self::uint32,
    "privLength"     => self::uint32,
  );
}