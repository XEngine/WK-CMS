<?php
  /**
   * Vertical Menu
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<!-- Accordion Menu -->
<div id="acomenu">
<?php $content->getMenu($mainmenu,0,'side-menu');?>
</div>
<script type="text/javascript">
$(document).ready(function () {
	$("ul#side-menu").find('ul.menu-submenu').parent().prepend('<i class=\"down arrow icon\"></i>');
	$('#side-menu i.icon.down.arrow').click(function () {
		$(this).siblings('#side-menu ul.menu-submenu').slideToggle();
		$(this).toggleClass('vertically flipped');
		
	});
});
</script>
<!-- Accordion Menu /-->