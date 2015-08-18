<?php
  /**
   * Breadcrumbs
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  require_once("admin_class.php");
?>
<?php
  $length = count($this->_url);
  switch ($length) {
      case 3:
          $nav = '<a href="' . Url::Portfolio("portfolio") . '" class="section">' . $this->moduledata->{'title' . Lang::$lang} . '</a>';
          $nav .= '<span class="divider"></span>';
          $nav .= '<div class="active section">' . $this->moduledata->mod->{'title' . Lang::$lang} . '</div>';
          break;
		  
      case 2:
          $nav = '<a href="' . Url::Portfolio("portfolio") . '" class="section">' . $this->moduledata->{'title' . Lang::$lang} . '</a>';
          $nav .= '<span class="divider"></span>';
          $nav .= '<div class="active section">' . $this->moduledata->mod->{'title' . Lang::$lang} . '</div>';
          break;

      default:
          $nav = '<div class="active section">' . $this->moduledata->{'title' . Lang::$lang} . '</div>';
          break;
  }
?>