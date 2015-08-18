<?php
  /**
   * Blog Categories
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */

  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  require_once (MODPATH . "blog/admin_class.php");
  $classname = 'Blog';
  try {
      if (!class_exists($classname)) {
          throw new exception('Missing blog/admin_class.php');
      }
      Registry::set('Blog', new Blog());
  }
  catch (exception $e) {
      echo $e->getMessage();
  }
?>
<!-- Start Blog Categories -->
<div class="wk secondary segment">
  <h4><?php echo Lang::$word->_MOD_AM_CATEGORIES;?></h4>
  <div id="blogcats">
    <?php $artcats = Registry::get("Blog")->getCatList(); Registry::get("Blog")->getCategories($artcats,0, "acats");?>
  </div>
</div>
<!-- End Blog Categories /--> 
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
	$("ul#acats").find('ul.menu-submenu').parent().prepend('<i class=\"down arrow icon\"></i>');
	$('#acats i.icon.down.arrow').click(function () {
		$(this).siblings('#acats ul.menu-submenu').slideToggle();
		$(this).toggleClass('vertically flipped');
		
	});
});
// ]]>
</script>