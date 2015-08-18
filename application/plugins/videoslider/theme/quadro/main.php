<?php
  /**
   * videoSlider Slider
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  require_once(PLUGPATH . "videoslider/admin_class.php");
  Registry::set('vSlider',new vSlider());

  $vidrow = Registry::get("vSlider")->getSlides();
?>
<!-- Start videoSlider Slider -->
<?php if(!$vidrow):?>
<?php echo Filter::msgSingleAlert(Lang::$word->_PLG_VS_NOIMG);?>
<?php else:?>
<div id="pl_plugin">
  <div id="pl_videoContainer">
    <div id="pl_video"> </div>
  </div>
  <div id="pl_playlistContainer">
    <ul id="pl_playlist">
      <?php foreach ($vidrow as $vsrow):?>
      <li><a href="<?php echo $vsrow->vidurl;?>"></a></li>
      <?php endforeach;?>
      <?php unset($vsrow);?>
    </ul>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function () {
      $("#pl_playlistContainer").enscroll({
          showOnHover: true,
          addPaddingToPane: false,
          verticalTrackClass: 'scrolltrack',
          verticalHandleClass: 'scrollhandle'
      });
      $("ul#pl_playlist").vidplaylist({
          autoPlay: <?php echo Registry::get("vSlider")->autoPlay;?>,
          allowFullScreen: <?php echo Registry::get("vSlider")->allowFullScreen;?>,
          deepLinks: true,
          onChange: function () {},
          start: 1,
          youtube: {
              autohide: '<?php echo Registry::get("vSlider")->autohide;?>',
              rel: '<?php echo Registry::get("vSlider")->rel;?>',
              theme: '<?php echo Registry::get("vSlider")->theme;?>',
              color: '<?php echo Registry::get("vSlider")->ycolor;?>',
              showinfo: '<?php echo Registry::get("vSlider")->showinfo;?>',
              vq: '<?php echo Registry::get("vSlider")->vq;?>'
          },
          vimeo: {
              title: '<?php echo Registry::get("vSlider")->title;?>',
              byline: '<?php echo Registry::get("vSlider")->byline;?>',
              portrait: '<?php echo Registry::get("vSlider")->portrait;?>',
              color: '<?php echo Registry::get("vSlider")->vcolor;?>'
          },
          holderId: 'pl_video',
          secure: 'auto'
      });
  });
</script>
<?php endif;?>
<!-- End videoSlider Slider /-->