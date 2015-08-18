<?php
  /**
   * Gallery Main
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  require_once(MODPATH . "gallery/admin_class.php");
  Registry::set('Gallery', new Gallery($content->module_data));
  
  $galrow = Registry::get("Gallery")->getGalleryImages($content->module_data); 
?>
<?php if(!$galrow):?>
<?php Filter::msgSingleAlert(Lang::$word->_MOD_GA_NOIMG);?>
<?php else:?>
<?php $galerylist = Registry::get("Gallery")->getGalleryList();?>
<h2 id="gallery-title" class="wk split header"><span><?php echo Registry::get("Gallery")->title;?></span></h2>
<?php if(count($galerylist) > 1):?>
<div class="gallery-nav">
  <div id="gallerylist" class="wk positive buttons">
    <div class="wk button"><?php echo Lang::$word->_MOD_GA_SELECT;?></div>
    <div class="wk positive pointing dropdown icon button"> <i class="dropdown icon"></i>
      <div class="menu">
        <?php foreach($galerylist as $list):?>
        <a class="item" data-id="<?php echo $list->id;?>" data-cols="<?php echo $list->cols;?>"><i class="photo icon"></i><?php echo $list->{'title' . Lang::$lang};?></a>
        <?php endforeach;?>
        <?php unset($list);?>
      </div>
    </div>
  </div>
</div>
<?php endif;?>
<div id="gallerywrap" class="clearfix">
  <?php foreach($galrow as $i => $grow):?>
  <?php $url = SITEURL.'/'.Gallery::galpath.Registry::get("Gallery")->folder.'/'.$grow->thumb;?>
  <div class="item">
    <?php if(Registry::get("Gallery")->watermark):?>
    <?php $url = MODURL.'gallery/watermark.php?folder='.Registry::get("Gallery")->folder.'&amp;image='.$grow->thumb;?>
    <?php else:?>
    <?php $url = SITEURL.'/'.Gallery::galpath.Registry::get("Gallery")->folder.'/'.$grow->thumb;?>
    <?php endif;?>
    <div class="image-overlay"> <img src="<?php echo SITEURL.'/'.Gallery::galpath.Registry::get("Gallery")->folder.'/'.$grow->thumb;?>" alt="">
      <div class="overlay-hslide"> <a href="<?php echo $url;?>" title="<?php echo $grow->{'description'.Lang::$lang};?>" class="lightbox"><i class="icon-overlay icon search"></i></a> </div>
    </div>
    <section class="gallery-data">
      <?php if(Registry::get("Gallery")->like):?>
      <a class="like toggle" data-content="<?php echo Lang::$word->_LIKE;?>" data-gid="<?php echo $content->module_data;?>" data-total="<?php echo $grow->likes;?>" data-id="<?php echo $grow->id;?>"><i class="icon heart"> </i><small><?php echo $grow->likes;?></small></a>
      <?php endif;?>
      <h3><?php echo $grow->{'title' . Lang::$lang};?></h3>
      <p class="portfolio-meta-image"> <?php echo $grow->{'description'.Lang::$lang};?> </p>
    </section>
  </div>
  <?php endforeach;?>
</div>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
	$('#gallerywrap').waitForImages(function() {
		$('#gallerywrap').Grid({
			inner: 28,
			outer: 0,
			cols: Math.round(1200 / <?php echo Registry::get("Gallery")->cols;?>)
		});
	});
    $('body').on('click', '.like', function () {
		$el = $(this).children('small')
        id = $(this).data("id");
        gid = $(this).data("gid");
		total = $(this).data("total");
        $.post(SITEURL + "/modules/gallery/controller.php", {
            doLike: 1,
            id: id,
            gid:gid,
			total:total
        }, function (data) {
            $($el).html(data);
        });
    });
	$('#gallerylist').on('click', 'a.item', function () {
		$container = $('#gallerywrap');
        var option = $(this).data('id');
		var cols = $(this).data('cols');
		var title = $(this).text();
        $.post(SITEURL + '/modules/gallery/controller.php', {
            gid: option,
			loadGallery: 1
        }, function (data) {
			$container.html(data);
			$container.waitForImages(function() {
				$container.elasticColumns('set', 'columns', cols);
				$container.elasticColumns('refresh');
			});
			$("#gallery-title span").html(title)
        });
    });
});
// ]]>
</script>
<?php endif;?>