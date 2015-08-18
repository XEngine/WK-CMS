<?php
  /**
   * Layout
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  if(!$user->getAcl("Layout")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
?>
<?php
  if (isset($_GET['modid']) and intval($_GET['modid'])) {
      if ($mod = getValuesById("id, modalias, title" . Lang::$lang, Content::mdTable, intval($_GET['modid']))) {
          $modid = $mod->id;
          $modslug = $mod->modalias;
          $title = $mod->{'title' . Lang::$lang};
		  $type = "mod_id";
          $pageid = 0;
          $pageslug = false;
		  $id = $mod->id;
      } else {
          redirect_to("index.php?do=layout");
      }
  } else {
      if (isset($_GET['pageid']) and intval($_GET['pageid'])) {
          $pageid = intval($_GET['pageid']);
          if ($page = getValuesById("id, slug, title" . Lang::$lang, Content::pTable, intval($_GET['pageid']))) {
              $pageid = $page->id;
              $pageslug = $page->slug;
              $title = $page->{'title' . Lang::$lang};
			  $type = "page_id";
			  $id = $page->id;
          } else {
              redirect_to("index.php?do=layout");
          }
      } else {
          $home = getValues("id, slug, title" . Lang::$lang, Content::pTable, "home_page = 1");
          $pageid = $home->id;
          $pageslug = $home->slug;
          $title = $home->{'title' . Lang::$lang};
		  $type = "page_id";
		  $id = $home->id;
      }
      $modid = 0;
      $modslug = false;
  }

  $layrow = $content->getLayoutOptions($pageid, $modid);
  $pagerow = $content->getPages();
  $modlist = $content->displayMenuModule();
?>
<div class="wk icon heading message teal"><a class="helper wk top right info corner label" data-help="layout"><i class="icon help"></i></a> <i class="icon block layout"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_LY_TITLE;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_N_LAYS;?></div>
    </div>
  </div>
</div>
<div id="layout" class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_LY_INFO;?></div>
  <div class="wk segment">
    <div class="wk header"><?php echo Lang::$word->_LY_VIEW_FOR;?> <?php echo $title;?></div>
    <div class="wk fitted divider"></div>
    <div class="wk small basic form segment">
      <div class="four fields">
        <div class="field">&nbsp;</div>
        <div class="field">&nbsp;</div>
        <div class="field">
          <select name="page_id" id="page_id" onchange="if(this.value!='0') window.location = 'index.php?do=layout&amp;pageid='+this[this.selectedIndex].value; else window.location = 'index.php?do=layout';">
            <option value="0"><?php echo Lang::$word->_LY_SEL_PAGE;?></option>
            <?php if($pagerow):?>
            <?php foreach ($pagerow as $prow):?>
            <?php $sel = ($pageid == $prow->id) ? ' selected="selected"' : '' ;?>
            <option value="<?php echo $prow->id;?>"<?php echo $sel;?>><?php echo $prow->{'title'.Lang::$lang};?></option>
            <?php endforeach;?>
            <?php endif;?>
          </select>
        </div>
        <div class="field">
          <?php if($modlist) :?>
          <select name="modid" id="mod_id" onchange="if(this.value!='0') window.location = 'index.php?do=layout&amp;modid='+this[this.selectedIndex].value; else window.location = 'index.php?do=layout';">
            <option value="0"><?php echo Lang::$word->_LY_SEL_MODULE;?></option>
            <?php foreach ($modlist as $mrow):?>
            <?php $sel = ($modid == $mrow->id) ? ' selected="selected"' : '' ;?>
            <option value="<?php echo $mrow->id;?>"<?php echo $sel;?>><?php echo $mrow->{'title'.Lang::$lang};?></option>
            <?php endforeach;?>
          </select>
          <?php endif;?>
        </div>
      </div>
    </div>
    <div class="wk double fitted divider"></div>
    <div class="wk-grid">
      <div id="top-position" class="bottom-space">
        <div class="wk info segment plholder"> <span class="wk top right attached label"><?php echo Lang::$word->_LY_TOP;?></span>
          <ul data-position="top" id="top-<?php echo ($modid) ? $modid : $pageid;?>" class="wk sortable top-position">
            <?php if($layrow): ?>
            <?php foreach ($layrow as $trow): ?>
            <?php if ($trow->place == "top"): ?>
            <li id="list-<?php echo $trow->plid;?>" data-type="<?php echo $type;?>" data-typeid="<?php echo $id;?>" data-id="<?php echo $trow->plid;?>" data-space="<?php echo $trow->space;?>"><?php echo $trow->{'title'.Lang::$lang};?>
              <div class="act-holder push-right">
                <div class="wk right basic pointing dropdown icon"> <i class="settings icon"></i>
                  <div class="menu"> <a class="item setspace"><i class="edit icon"></i><?php echo Lang::$word->_EDIT;?></a> <a class="item remove"><i class="delete icon"></i><?php echo Lang::$word->_REMOVE;?></a> </div>
                </div>
              </div>
            </li>
            <?php endif; ?>
            <?php endforeach; ?>
            <?php unset($trow);?>
            <?php endif; ?>
          </ul>
        </div>
      </div>
      <div class="columns horizontal-gutters">
        <div class="screen-40 tablet-40 phone-100">
          <div class="wk teal segment plholder"> <span class="wk top right attached label"><?php echo Lang::$word->_LY_LEFT;?></span>
            <ul data-position="left" id="left-<?php echo $id;?>" class="wk sortable left-position">
              <?php if($layrow): ?>
              <?php foreach ($layrow as $lrow): ?>
              <?php if ($lrow->place == "left"): ?>
              <li id="list-<?php echo $lrow->plid;?>" data-type="<?php echo $type;?>" data-typeid="<?php echo $id;?>" data-id="<?php echo $lrow->plid;?>"><?php echo $lrow->{'title'.Lang::$lang};?>
                <div class="act-holder push-right"><a class="remove"> <i class="danger trash icon"></i></a></div>
              </li>
              <?php endif; ?>
              <?php endforeach; ?>
              <?php unset($lrow);?>
              <?php endif;?>
            </ul>
          </div>
        </div>
        <div class="screen-20 tablet-20 phone-100">
          <div class="wk danger segment not-allowed"> <span class="wk top right attached label"><?php echo Lang::$word->_LY_MAIN;?></span>
            <p></p>
          </div>
        </div>
        <div class="screen-40 tablet-40 phone-100">
          <div class="wk warning segment plholder"> <span class="wk top right attached label"><?php echo Lang::$word->_LY_RIGHT;?></span>
            <ul data-position="right" id="right-<?php echo $id;?>" class="wk sortable right-position">
              <?php if($layrow): ?>
              <?php foreach ($layrow as $rrow): ?>
              <?php if ($rrow->place == "right"): ?>
              <li id="list-<?php echo $rrow->plid;?>" data-type="<?php echo $type;?>" data-typeid="<?php echo $id?>" data-id="<?php echo $rrow->plid;?>"><?php echo $rrow->{'title'.Lang::$lang};?>
                <div class="act-holder push-right"><a class="remove"> <i class="danger trash icon"></i></a></div>
              </li>
              <?php endif; ?>
              <?php endforeach; ?>
              <?php unset($rrow);?>
              <?php endif;?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div id="bottom-position" class="top-space">
      <div class="wk positive segment plholder"> <span class="wk top right attached label"><?php echo Lang::$word->_LY_BOTTOM;?></span>
        <ul data-position="bottom" id="bottom-<?php echo $id;?>" class="wk sortable bottom-position">
          <?php if($layrow): ?>
          <?php foreach ($layrow as $brow): ?>
          <?php if ($brow->place == "bottom"): ?>
          <li id="list-<?php echo $brow->plid;?>" data-type="<?php echo $type;?>" data-typeid="<?php echo $id;?>" data-id="<?php echo $brow->plid;?>" data-space="<?php echo $brow->space;?>"><?php echo $brow->{'title'.Lang::$lang};?>
            <div class="act-holder push-right">
              <div class="wk right basic pointing dropdown icon"> <i class="settings icon"></i>
                <div class="menu"> <a class="item setspace"><i class="edit icon"></i><?php echo Lang::$word->_EDIT;?></a> <a class="item remove"><i class="delete icon"></i><?php echo Lang::$word->_REMOVE;?></a> </div>
              </div>
            </div>
          </li>
          <?php endif; ?>
          <?php endforeach; ?>
          <?php unset($brow);?>
          <?php endif;?>
        </ul>
      </div>
    </div>
  </div>
</div>
<?php $slug = ($modid) ? 'modslug='.$modslug : 'pageslug='.$pageslug;?>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
    $(".bottom-position, .top-position").on("sortreceive", function (event, ui) {
        $('div.act-holder', ui.item).html('<div class="wk right basic pointing dropdown icon"> <i class="settings icon"></i><div class="menu"><a class="item setspace"><i class="edit icon"></i><?php echo Lang::$word->_EDIT;?></a><a class="item remove"><i class="delete icon"></i><?php echo Lang::$word->_REMOVE;?></a></div></div>');
        $('.wk.dropdown').dropdown();
    });
    $(".left-position, .right-position").on("sortreceive", function (event, ui) {
        $('div.act-holder', ui.item).html('<a class="remove"><i class="danger trash icon"></i></a>');
    });

    $("#bottom-<?php echo $id;?>,#left-<?php echo $id;?>,#right-<?php echo $id;?>,#top-<?php echo $id;?>").sortable({
        connectWith: '.wk.sortable',
        placeholder: 'placeholder',
        tolerance: "pointer",
        cursorAt: {
            top: 0,
            left: 0
        },
        start: function (event, ui) {
            $(ui.item).width($('#left-<?php echo $id;?>').width());
        },
        update: savePosition
    });

    $('#layout').on('doubletap', '.plholder', function () {
        var $this = $(this).children('ul');
        var pos = $($this).data('position')
        Messi.load('controller.php', {
            loadAvailPlugs: 1,
            position: pos,
            page_id: <?php echo $pageid;?> ,
            mod_id: <?php echo $modid;?>
        }, {
            title: '<?php echo Lang::$word->_LY_SELECT;?>'
        });
         
    });
			  
    $('body').on('click', '#plavailable a.list', function () {
        var pos = $(this).data('position');
        var id = $(this).data('id');
        var name = $(this).text();

        if (pos == "top" || pos == "bottom") {
            var $list = ('<li id="list-' + id + '" data-type="<?php echo $type;?>" data-typeid="<?php echo $id?>" data-id="' + id + '" data-space="10">' + name + '<div class="act-holder push-right"><div class="wk right basic pointing dropdown icon"> <i class="settings icon"></i><div class="menu"><a class="item setspace"><i class="edit icon"></i><?php echo Lang::$word->_EDIT;?></a><a class="item remove"><i class="delete icon"></i><?php echo Lang::$word->_REMOVE;?></a></div></div></div></li>');
            $('.wk.dropdown').dropdown();
        } else {
            var $list = ('<li id="list-' + id + '" data-type="<?php echo $type;?>" data-id="' + id + '">' + name + '<div class="act-holder push-right"><a class="remove"> <i class="danger trash icon"></i></a></div></li>');
        }
		
		$("ul[data-position='" + pos + "']").prepend($list);
		$(this).parent().remove()
		
        var place = "";
        var count = 0;
        $("ul[data-position='" + pos + "'] [id^=list-]").each(function () {
            count++;
            place += (this.parentNode.id + "[]" + "=" + count + "|" + this.id + "&");
        });
        $.ajax({
            type: "post",
            url: "controller.php?<?php echo $slug;?>&layout=" + pos + '-' + <?php echo $id;?>,
            data: place
        });
		
		$('.wk.dropdown').dropdown();
    });

    $('body').on('click', 'a.remove', function () {
        var $li = $(this).closest('li');
        var type = $($li).data("type");
        var type_id = $($li).data("typeid");
        var id = $($li).data("id");
		
        $li.slideUp(500, function () {
            $li.remove();
            $.ajax({
                type: "post",
                url: "controller.php",
                data: {
                    removeLayoutPlugin: 1,
					id: id,
					type: type,
					type_id: type_id,
                },
                success: function (msg) {}
            });

        });
    });
	
    $('#layout').on('click', 'a.setspace', function () {
        var $li = $(this).closest('li');
        var curspace = $($li).data("space");
        var type = $($li).data("type");
        var type_id = $($li).data("typeid");
        var id = $($li).data("id");
		
        var text = '<div class="spacegrid">';
        for (var i = 1; i <= 10; i++) {
            var cls = (curspace == i) ? "active" : null;
            text += '<span class="spacelist ' + cls + '">' + i + '</span>';
        }
        text += '</div>';

        new Messi(text, {
            title: '<?php echo Lang::$word->_LY_SPTITLE;?>',
            modal: true,
            closeButton: true,
            buttons: [{
                id: 0,
                label: '<?php echo Lang::$word->_SUBMIT;?>',
                class: 'positive',
                val: 'Y'
            }],
            callback: function (val) {
                newcol = $('.spacelist.active').text();
                $.ajax({
                    type: 'post',
                    url: "controller.php",
                    data: {
                        setPluginCols: 1,
                        id: id,
                        type: type,
                        type_id: type_id,
                        cols: newcol
                    },
                    beforeSend: function () {},
                    success: function (msg) {
                        $($li).data("space", msg);
                    }

                });
            }
        });
    });

    /* == Toggle Space Columns == */
    $('body').on('click', 'span.spacelist', function () {
        $('body span.spacelist.active').not(this).removeClass('active');
        $(this).toggleClass("active");
    });
});

function savePosition() {
    var place = "";
    var count = 0;
    $("[id^=list-]").each(function () {
        count++;
        place += (this.parentNode.id + "[]" + "=" + count + "|" + this.id + "&");
    });
    $.ajax({
        type: "post",
        url: "controller.php?<?php echo $slug;?>&layout=" + this.id,
        data: place
    });
}
// ]]>
</script>