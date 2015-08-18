<?php
  /**
   * Right Widget Layout
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php if($totalright):?>
<section id="rightwidget" class="clearfix">
  <div class="wk-content-full">
    <?php foreach ($widgetright as $rrow): ?>
    <aside class="clearfix<?php if($rrow->alt_class !="") echo ' '.$rrow->alt_class;?>">
      <?php if ($rrow->show_title == 1):?>
      <h3 class="wk header"><span><?php echo $rrow->{'title' . Lang::$lang};?></span></h3>
      <?php endif;?>
      <?php if ($rrow->{'body' . Lang::$lang}) echo "<div class=\"widget-body\">".cleanOut($rrow->{'body' . Lang::$lang})."</div>";?>
      <?php if ($rrow->jscode) echo cleanOut($rrow->jscode);?>
      <?php if ($rrow->system == 1):?>
      <?php $widgetfile = Content::getPluginTheme($rrow->plugalias);?>
      <?php require_once($widgetfile);?>
      <?php endif;?>
    </aside>
    <?php endforeach; ?>
    <?php unset($rrow);?>
  </div>
</section>
<?php endif;?>
