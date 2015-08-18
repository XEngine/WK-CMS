<?php
  /**
   * Footer
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
 
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<!-- Footer -->
<footer>
  <div class="wojo-grid">
    <div class="footer-wrap">
      <div class="wojo-content-full">
        <div class="columns horizontal-gutters">
          <div class="screen-40 tablet-40 phone-100">
            <div class="logo"><a href="<?php echo SITEURL;?>"><?php echo ($core->logo) ? '<img src="'.SITEURL.'/uploads/'.$core->logo.'" alt="'.$core->company.'" />': $core->company;?></a> </div>
          </div>
          <div class="screen-60 tablet-60 phone-100">
            <div class="copyright">
              <div class="small-bottom-space"> <a href="<?php echo SITEURL;?>/" data-content="<?php echo Lang::$word->_HOME;?>"><i class="circular black inverted icon home link"></i></a> <a href="http://validator.w3.org/check/referer" target="_blank" data-content="Our website is valid HTML5"><i class="circular black inverted icon html5 link"></i></a> <a href="<?php echo SITEURL;?>/rss.php" data-content="Rss"><i class="circular black inverted icon rss link"></i></a> <a href="<?php echo Url::Page($core->sitemap_page);?>" data-content="<?php echo Lang::$word->_SM_SITE_MAP;?>"><i class="circular black inverted icon map link"></i></a> </div>
              Copyright &copy;<?php echo date('Y').' <a href="'.SITEURL.'/">'.$core->site_name.'</a>';?> All Rights Reserved. | Powered by: CMS Pro! v <?php echo $core->version;?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
<!-- Footer /-->
<?php if($core->analytics):?>
<!-- Google Analytics --> 
<?php echo cleanOut($core->analytics);?> 
<!-- Google Analytics /-->
<?php endif;?>