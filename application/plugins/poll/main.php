<?php
  /**
   * jQuery Poll
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

?>
<!-- Start jQuery Poll -->
<div id="pollcontainer"></div>
<script type="text/javascript">
$(function () {
    var pollcontainer = $('#pollcontainer');
    $.get('<?php echo PLUGURL;?>/poll/controller.php', '', function (data, status) {
        pollcontainer.html(data);
        pollcontainer.find('#viewresult').click(function () {
            $.get('<?php echo PLUGURL;?>poll/controller.php', 'result=1', function (data, status) {
                pollcontainer.fadeIn("fast", function () {
                    $(this).html(data);
                });
            });
            return false;
        }).end().find('#pollform .votenow').click(function () {
            var selected_val = $("#pollform").find('input[name=poll]:checked').val();
            if (selected_val != undefined) {
                $.post('<?php echo PLUGURL;?>poll/controller.php', $("#pollform").serialize(), function (data, status) {
                    $('#formcontainer').fadeIn(100, function () {
                        $("#pollform").html(data);
                    });
                });
            }
            return false;
        });
    });
});
</script>
<!-- End jQuery Poll /-->