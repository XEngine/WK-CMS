<?php
  /**
   * Meta
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
          if (in_array(Url::$data['module']['blog-tag'], $this->_url) or in_array(Url::$data['module']['blog-archive'], $this->_url) or in_array(Url::$data['module']['blog-author'], $this->_url)) {
              $nav = '<a href="' . Url::Blog("blog") . '" class="section">' . $this->moduledata->{'title' . Lang::$lang} . '</a>';
              $nav .= '<span class="divider"></span> ';
              if (in_array(Url::$data['module']['blog-tag'], $this->_url)) {
                  $nav .= '<div class="active section">' . Lang::$word->_MOD_AMT_RESULT . '</div>';
              }
              if (in_array(Url::$data['module']['blog-archive'], $this->_url)) {
                  $nav .= '<div class="active section">' . Lang::$word->_MOD_AM_ARCHIVE . '</div>';
              }
              if (in_array(Url::$data['module']['blog-author'], $this->_url)) {
                  $nav .= '<div class="active section">' . Lang::$word->_LA_AUTHOR . '</div>';
				  $nav .= '<span class="divider"></span>';
				  $nav .= '<div class="active section"> ' . $this->_url[2] . ' </div>';
              }
          } else {
              $nav = '<a href="' . Url::Blog("blog") . '" class="section">' . $this->moduledata->{'title' . Lang::$lang} . '</a>';
              $nav .= '<span class="divider"></span>';
              $nav .= '<div class="active section"> ' . Lang::$word->_CATEGORY . ' </div>';
              $nav .= '<span class="divider"></span>';
              $nav .= '<div class="active section"> ' . $this->moduledata->mod->{'name' . Lang::$lang} . ' </div>';
          }
          break;

      case 2:
          if (in_array(Url::$data['module']['blog-search'], $this->_url)) {
              $nav = '<a href="' . Url::Blog("blog") . '" class="section">' . $this->moduledata->{'title' . Lang::$lang} . '</a>';
              $nav .= '<span class="divider"></span> ';
              $nav .= '<div class="active section">' . Lang::$word->_MOD_AMS_RESULT . '</div>';
          } else {
              $nav = '<a href="' . Url::Blog("blog") . '" class="section">' . $this->moduledata->{'title' . Lang::$lang} . '</a>';
              $nav .= '<span class="divider"></span>';
              $nav .= '<div class="active section">' . $this->moduledata->mod->{'title' . Lang::$lang} . '</div>';
          }
          break;

      default:
          $nav = '<div class="active section">' . $this->moduledata->{'title' . Lang::$lang} . '</div>';
          break;
  }
?>