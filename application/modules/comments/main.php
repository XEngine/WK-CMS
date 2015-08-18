<?php
  /**
   * Comments Main
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  require_once(MODPATH . "comments/admin_class.php");
  Registry::set('Comments', new Comments());

  $counter = countEntries(Comments::mTable, "page_id", $row->id);
  $pages = ceil($counter/Registry::get("Comments")->perpage)
?>
<hr>
<h4 class="wk header"><?php echo ($counter <> 0) ?  $counter . " " . Lang::$word->_MOD_CM_HAS_C . "<em>" . $row->{'title' . Lang::$lang} . "</em>" : Lang::$word->_MOD_CM_NOCOMMENTS;?></h4>
<div id="comments" class="wk threaded comments"></div>
<?php if($counter > Registry::get("Comments")->perpage):?>
<div id="pagination" class="content-center">
  <div class="wk pagination menu">
    <?php for($j=1; $j<=$pages; $j++):?>
    <a class="item" data-id="<?php echo $j;?>"><?php echo $j;?></a>
    <?php endfor;?>
  </div>
</div>
<?php endif;?>
<?php if(Registry::get("Comments")->public_access):?>
<?php include("form.tpl.php");?>
<?php elseif(!Registry::get("Comments")->public_access and $user->logged_in):?>
<?php include("form.tpl.php");?>
<?php else:?>
<?php echo Filter::msgSingleAlert(Lang::$word->_MOD_CM_MSGERR3);?>
<?php endif;?>
<script type="text/javascript">
// <![CDATA[
function loadComments() {
    $("#pagination [data-id=1]").addClass("active");
	$('#comments').addClass('loader');
    $.ajax({
        url: SITEURL + "/modules/comments/loadComments.php",
        data: {
            pg: 1,
            pid: <?php echo $row->id;?>
        },
        cache: false,
        success: function (data) {
            $("#comments").fadeIn("slow", function () {
                $(this).html(data);
                setTimeout(function () {
                    $('#comments').removeClass('loader');
                }, 500);
            });


        }
    });
}
$.fn.limit = function (options) {
	var defaults = {
		limit: 200,
		id_result: false,
		alertClass: false
	}
	var options = $.extend(defaults, options);
	return this.each(function () {
		var characters = options.limit;
		if (options.id_result != false) {
			$("#" + options.id_result).append("<?php echo Lang::$word->_MOD_CHAR_REMAIN1;?>" + characters + "<?php echo Lang::$word->_MOD_CHAR_REMAIN2;?>");
		}
		$(this).keyup(function () {
			if ($(this).val().length > characters) {
				$(this).val($(this).val().substr(0, characters));
			}
			if (options.id_result != false) {
				var remaining = characters - $(this).val().length;
				$("#" + options.id_result).html("<?php echo Lang::$word->_MOD_CHAR_REMAIN1;?>" + remaining + "<?php echo Lang::$word->_MOD_CHAR_REMAIN2;?>");
				if (remaining <= 10) {
					$("#" + options.id_result).addClass(options.alertClass);
				} else {
					$("#" + options.id_result).removeClass(options.alertClass);
				}
			}
		});
	});
};
$(document).ready(function () {
    loadComments();
    $(".wk.pagination a").click(function () {
		$('#comments').addClass('loader');
        $(".wk.pagination a").removeClass("active");
        $(this).addClass("active");
        var page = $(this).attr("data-id");
        $.ajax({
            url: SITEURL + "/modules/comments/loadComments.php",
            data: {
                pg: page,
                pid: <?php echo $row->id; ?>
            },
            cache: false,
            success: function (data) {
                $("#comments").fadeIn("slow", function () {
                    $(this).html(data);
                    setTimeout(function () {
                        $('#comments').removeClass('loader');
                    }, 500);
                });


            }
        });
    });
	
    $("#combody").limit({
        limit: <?php echo Registry::get("Comments")->char_limit;?>,
        id_result : "counter",
        alertClass : "error"
    });
});
// ]]>
</script>