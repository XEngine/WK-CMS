<?php
  /**
   * Left Widget Layout
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php if($totalleft):?>
<section id="leftwidget" class="clearfix">
  <div class="wk-content-full">
    <?php foreach ($widgetleft as $lrow): ?>
    <aside class="clearfix<?php if($lrow->alt_class !="") echo ' '.$lrow->alt_class;?>">
      <?php if ($lrow->show_title == 1):?>
      <h3 class="wk header"><span><?php echo $lrow->{'title' . Lang::$lang};?></span></h3>
      <?php endif;?>
      <?php if ($lrow->{'body' . Lang::$lang}) echo "<div class=\"widget-body\">".cleanOut($lrow->{'body' . Lang::$lang})."</div>";?>
      <?php if ($lrow->jscode) echo cleanOut($lrow->jscode);?>
      <?php if ($lrow->system == 1):?>
      <?php $widgetfile = Content::getPluginTheme($lrow->plugalias);?>
      <?php require_once($widgetfile);?>
      <?php endif;?>
    </aside>
    <?php endforeach; ?>
    <?php unset($lrow);?>
  </div>
</section>
<?php endif;?>
