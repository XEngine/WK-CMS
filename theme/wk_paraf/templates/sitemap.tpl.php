<?php
  /**
   * Sitemap Template
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  $sitemap = $content->getSitemap();
?>
<div class="two columns gutters">
  <div class="row">
    <h3><?php echo Lang::$word->_N_PAGES;?></h3>
    <div class="wk divided list">
      <?php foreach($sitemap as $srow):?>
      <div class="item"><i class="icon angle right"></i><a href="<?php echo Url::Page($srow->slug);?>"><?php echo $srow->pgtitle;?></a></div>
      <?php endforeach;?>
      <?php unset($srow);?>
    </div>
  </div>
  <?php if($core->checkTable("mod_blog")):?>
  <?php $artrow = $content->getArticleSitemap();?>
  <div class="row">
    <h3><?php echo getValue("title" . Lang::$lang, "modules", "modalias = 'blog'");?></h3>
    <div class="wk divided list">
      <?php foreach($artrow as $srow):?>
      <div class="item"><i class="icon angle right"></i><a href="<?php echo Url::Blog("item", $srow->slug);?>"><?php echo $srow->atitle;?></a></div>
      <?php endforeach;?>
      <?php unset($srow);?>
    </div>
  </div>
  <?php endif;?>
  <?php if($core->checkTable("mod_digishop")):?>
  <?php $digirow = $content->getDigishopSitemap();?>
  <div class="row">
    <h3><?php echo getValue("title" . Lang::$lang, "modules", "modalias = 'digishop'");?></h3>
    <div class="wk divided list">
      <?php foreach($digirow as $srow):?>
      <div class="item"><i class="icon angle right"></i><a href="<?php echo Url::Digishop("item", $srow->slug);?>"><?php echo $srow->dtitle;?></a></div>
      <?php endforeach;?>
      <?php unset($srow);?>
    </div>
  </div>
  <?php endif;?>
  <?php if($core->checkTable("mod_portfolio")):?>
  <?php $digirow = $content->getPortfolioSitemap();?>
  <div class="row">
    <h3><?php echo getValue("title" . Lang::$lang, "modules", "modalias = 'portfolio'");?></h3>
    <div class="wk divided list">
      <?php foreach($digirow as $srow):?>
      <div class="item"><i class="icon angle right"></i><a href="<?php echo dUrl::Portfolio("item", $srow->slug);?>"><?php echo $srow->ptitle;?></a></div>
      <?php endforeach;?>
      <?php unset($srow);?>
    </div>
  </div>
  <?php endif;?>
  <?php if($core->checkTable("mod_psdrive")):?>
  <?php $psdriverow = $content->getPsDriveSitemap();?>
  <div class="row">
    <h3><?php echo getValue("title" . Lang::$lang, "modules", "modalias = 'psdrive'");?></h3>
    <div class="wk divided list">
      <?php foreach($psdriverow as $srow):?>
      <div class="item"><i class="icon angle right"></i><a href="<?php echo Url::Psdrive("item", $srow->slug);?>"><?php echo $srow->ptitle;?></a></div>
      <?php endforeach;?>
      <?php unset($srow);?>
    </div>
  </div>
  <?php endif;?>
</div>