<?php
  /**
   * Blog Search
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<!-- Start Blog Search -->
<form action="<?php echo Url::Blog("blog-search");?>" method="post">
  <div class="wk fluid basic icon input">
    <input name="keywords" placeholder="Search..." type="text">
    <i class="search icon"></i> </div>
</form>
<!-- End Blog Search /--> 