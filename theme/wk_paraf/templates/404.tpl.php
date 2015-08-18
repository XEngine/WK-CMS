<?php
  /**
   * 404 Template
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<div id="error-page">
  <div class="wk-grid">
    <div class="logo"><a href="<?php echo SITEURL;?>"><?php echo ($core->logo) ? '<img src="'.SITEURL.'/uploads/'.$core->logo.'" alt="'.$core->company.'" />': $core->company;?></a> </div>
    <h1><?php echo Lang::$word->_ER_404;?></h1>
    <a href="<?php echo SITEURL;?>/">
    <div id="but" class="wk info icon button"><i class="icon home"></i></div>
    </a>
    <h3 class="primary"><?php echo Lang::$word->_ER_404_1;?></h3>
    <h3><?php echo Lang::$word->_ER_404_2;?></h3>
  </div>
</div>