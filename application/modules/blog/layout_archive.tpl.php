<?php
  /**
   * Articles Layout Archive
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php $latestrow = Registry::get("Blog")->renderArchiveList();?>
<?php if(!$latestrow):?>
<?php Filter::msgSingleAlert(Lang::$word->_MOD_AM_ARCHIVEERR);?>
<?php else:?>
<h1 class="wk double header"><span><?php echo '<small class="wk label">' . count($latestrow) . '</small> ' .Lang::$word->_MOD_AM_ARCHIVEFID;?></span></h1>
<div class="wk relaxed selection divided list">
  <?php foreach ($latestrow as $row):?>
  <div class="item">
    <div class="right floated wk label"><?php echo Filter::dodate("short_date", $row->created);?></div>
    <a href="<?php echo Url::Blog("item", $row->slug);?>"><img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL.'/'.Blog::imagepath . $row->thumb;?>&amp;h=100&amp;w=100&amp;s=1&amp;a=tl" alt="" class="wk avatar image"></a>
    <div class="content">
      <div class="header"><a href="<?php echo Url::Blog("item", $row->slug);?>" class="inverted"><?php echo $row->atitle;?></a></div>
      <?php if($row->show_author):?>
      <i class="icon user"></i> <a href="<?php echo Url::Blog("blog-author", $row->username);?>" class="inverted"><?php echo $row->username;?></a>
      <?php endif;?>
      <i class="icon sitemap"></i> <a href="<?php echo Url::Blog("blog-cat", $row->slug);?>" class="inverted"><?php echo $row->catname;?></a> <i class="icon chat"></i> <?php echo $row->totalcomments;?> <?php echo Lang::$word->_MOD_AM_COMMENTS;?> </div>
  </div>
  <?php endforeach;?>
</div>
<?php unset($row);?>
<?php endif;?>