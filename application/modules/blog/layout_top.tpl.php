<?php
  /**
   * Blog Layout Top
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php if(!$latestrow):?>
<?php echo Filter::msgSingleAlert(Lang::$word->_MOD_AM_NO_ART_CATS);?>
<?php else:?>
<?php if($length == 3):?>
<h3><a href="<?php echo SITEURL;?>/blog_rss.php?cid=<?php echo $single->id;?>" class="push-right"><i class="icon rss"></i></a>
  <?php if($single->icon):?>
  <i class="<?php echo $single->icon;?>"></i>
  <?php endif;?>
  <?php echo Lang::$word->_MOD_AM_BLCAT.' / '.$single->{'name'.Lang::$lang};?></h3>
<?php if($single->{'description'.Lang::$lang}):?>
<p><?php echo cleanSanitize($single->{'description'.Lang::$lang});?></p>
<div class="wk divider"></div>
<?php endif;?>
<?php endif;?>
<div id="articles" class="relative layout-top">
  <?php foreach ($latestrow as $row):?>
  <article class="clearfix">
    <?php if($row->show_created):?>
    <aside>
      <div><span class="day"><?php echo $row->day;?></span><span class="year"><?php echo Blog::getShortMonths($row->month) . ' ' . $row->year;?></span></div>
    </aside>
    <?php endif;?>
    <section>
      <div class="header clearfix">
        <div class="title">
          <h3><a href="<?php echo Url::Blog("item", $row->slug);?>" class="inverted"><?php echo $row->atitle;?></a></h3>
        </div>
        <div class="wk small horizontal divided list">
          <?php if($row->show_author):?>
          <div class="item"> <i class="icon user"></i> <a href="<?php echo Url::Blog("blog-author", $row->username);?>" class="inverted"><?php echo $row->username;?></a> </div>
          <?php endif;?>
          <div class="item"> <i class="icon sitemap"></i> <a href="<?php echo Url::Blog("blog-cat", $row->catslug);?>" class="inverted"><?php echo $row->catname;?></a> </div>
          <div class="item"> <i class="icon chat"></i> <?php echo $row->totalcomments;?> <?php echo Lang::$word->_MOD_AM_COMMENTS;?></div>
        </div>
      </div>
      <?php if($row->thumb):?>
      <figure class="small-top-space small-bottom-space">
        <div class="image-overlay wk center floated image"> <img src="<?php echo SITEURL.'/'.Blog::imagepath . $row->thumb;?>" alt="">
          <div class="overlay-fade"> <a title="<?php echo $row->{'caption'.Lang::$lang};?>" href="<?php echo Url::Blog("item", $row->slug);?>"><i class="icon-overlay icon url"></i></a></div>
        </div>
      </figure>
      <?php endif;?>
      <?php $desc = cleanSanitize($row->{'short_desc'.Lang::$lang});?>
      <div class="description"><?php echo $desc;?> <a href="<?php echo Url::Blog("item", $row->slug);?>"><?php echo Lang::$word->_MOD_AM_MORE;?><i class="icon right angle"></i></a></div>
    </section>
  </article>
  <?php endforeach;?>
  <?php unset($row);?>
  <div id="pagination" class="content-center"><?php echo $pager->display_pages();?></div>
</div>
<?php endif;?>