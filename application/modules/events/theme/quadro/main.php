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
  Registry::set('eventManager', new eventManager());
?>
<!-- Start Event Manager -->
<div id="calendar">
  <?php Registry::get("eventManager")->renderCalendar();?>
</div>
<script type="text/javascript">
// <![CDATA[
  $(document).ready(function () {
      $("#calendar").on("click", "a.changedate", function () {
          $('#calendar').addClass('loader');
          var caldata = $(this).data('id');
          var month = caldata.split(":")[0];
          var year = caldata.split(":")[1];
          $.ajax({
              type: "POST",
              url: SITEURL + "/modules/events/calendar.php",
              data: {
                  'year': year,
                  'month': month,
                  'getcal': 1
              },
              success: function (data) {
                  setTimeout(function () {
                      $("#calendar").fadeIn("slow", function () {
                          $(this).html(data);
                      });
                      $('#calendar').removeClass('loader');
                  }, 500);

              }
          });
          return false;
      });

      $("#calendar").on("click", "a.loadevent", function () {
          var id = $(this).data('id');
          var caption = $(this).data('title');
          Messi.load(SITEURL + '/modules/events/controller.php', {
              loadEvent: 1,
              id: id
          }, {
              title: caption
          });
      });
  });
// ]]>
</script> 
<!-- End Event Manager /-->