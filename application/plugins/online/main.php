<?php
  /**
   * Online Users
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<div id="online-users" class="online clearfix">
  <div class="items"><img class="preloader" src="<?php echo SITEURL;?>/plugins/online/images/preloader.gif" alt="Loading.." /></div>
  <div class="counter"></div>
  <div class="title">online</div>
  <div class="button"><i class="icon angle up"></i></div>
</div>
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    var count = $('#online-users.online .counter');
    var panel = $('#online-users.online .items');
    var timeout;
    count.load(SITEURL + '/plugins/online/controller.php');

    $('#online-users.online').hover(
        function () {
            clearTimeout(timeout);
            timeout = setTimeout(function () {
                panel.trigger('open');
            }, 500);
        },
        function () {
            clearTimeout(timeout);
            timeout = setTimeout(function () {
                panel.trigger('close');
            }, 500);
        }
    );
    var loaded = false;
    panel.on('open', function () {
        panel.slideDown(function () {
            if (!loaded) {
                panel.load(SITEURL + '/plugins/online/geodata.php');
                loaded = true;
            }
        });
    }).on('close', function () {
        panel.slideUp();
    });
});
// ]]>
</script>