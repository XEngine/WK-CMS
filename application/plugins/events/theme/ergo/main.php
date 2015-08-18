<?php
  /**
   * Event Manager
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  require_once(MODPATH . "events/admin_class.php");

  Registry::set('eventManager',new eventManager());
  Registry::get("eventManager")->weekDayNameLength = "short";
?>
<!-- Start Event Manager -->
<div id="cal-wrap-small"><?php Registry::get("eventManager")->renderCalendar('small');?></div>
<script type="text/javascript">
// <![CDATA[
  $(document).ready(function () {
      $("#cal-wrap-small").on("click", "a.changedate", function () {
          $("#cal-wrap-small").addClass('loader');
          var month = $(this).data('m');
          var year = $(this).data('y');
          $.ajax({
              type: "post",
              url: SITEURL + "/plugins/events/calendar.php",
              data: {
                  'year': year,
                  'month': month
              },
              success: function (data) {
                  setTimeout(function () {
                      $("#cal-wrap-small").fadeIn("slow", function () {
                          $(this).html(data);
                      });
                      $('#cal-wrap-small').removeClass('loader');
                  }, 500);

              }
          });
          return false;
      });

      $("#cal-wrap-small").on("click", "a.view-events", function () {
          var d = $(this).data('d');
          var m = $(this).data('m');
          var y = $(this).data('y');
          var caption = $(this).data('title');
          Messi.load(SITEURL + '/plugins/events/controller.php', {
              loadEvent: 1,
              d: d,
              m: m,
              y: y
          }, {
              title: caption
          });
      });
  });
// ]]>
</script>
<!-- End Event Manager /-->