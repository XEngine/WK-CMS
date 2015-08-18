<?php
  /**
   * Slider Manager
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  if(!$user->getAcl("slidecms")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
  
  Registry::set('slideCMS', new slideCMS());

switch(Filter::$maction):
  case "edit":
    include('modules/wkslider/functions/edit.php');
    break;
  case"add":
    include('modules/wkslider/functions/add.php');
    break;
  default:
    include('modules/wkslider/functions/default.php');
  break;
endswitch;
?>