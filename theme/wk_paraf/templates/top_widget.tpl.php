<?php
  /**
   * Top Widget Layout
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php if($totaltop):?>
<?php $tcounter = countInArray($widgettop, "space", "10");?>
<section class="topwidget clearfix">
  <?php if($totaltop > 1 and $tcounter == false):?>
  <div class="wk-grid">
    <?php endif;?>
    <div class="columns<?php if($totaltop > 1 and $tcounter == false):?> small-vertical-gutters<?php endif;?>">
      <?php foreach ($widgettop as $trow): ?>
      <div class="screen-<?php echo $trow->space;?>0 phone-100">
        <?php if($totaltop > 1 and $tcounter == false):?>
        <div class="wk-content">
          <?php endif;?>
          <div class="topwidget-wrap<?php if($trow->alt_class !="") echo ' '.$trow->alt_class;?>">
            <?php if ($trow->show_title == 1):?>
            <h3 class="wk header"><?php echo $trow->{'title' . Lang::$lang};?></h3>
            <?php endif;?>
            <?php if ($trow->{'body' . Lang::$lang}) echo "<div class=\"widget-body\">".cleanOut($trow->{'body' . Lang::$lang})."</div>";?>
            <?php if ($trow->jscode) echo cleanOut($trow->jscode);?>
            <?php if ($trow->system == 1):?>
            <?php $widgetfile = Content::getPluginTheme($trow->plugalias);?>
            <?php require($widgetfile);?>
            <?php endif;?>
          </div>
        </div>
        <?php if($totaltop > 1 and $tcounter == false):?>
      </div>
      <?php endif;?>
      <?php endforeach; ?>
      <?php unset($trow);?>
    </div>
    <?php if($totaltop > 1 and $tcounter == false):?>
  </div>
  <?php endif;?>
</section>
<?php endif;?>