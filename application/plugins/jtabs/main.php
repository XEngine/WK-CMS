<?php
  /**
   * jQuery Tabs
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  require_once(PLUGPATH . "jtabs/admin_class.php");
  
  Registry::set('jtabs',new jtabs());
  $tabrow = Registry::get("jtabs")->renderTabs();
  $count = count($tabrow);
?>
<!-- Start Tab Slider -->
<?php if($tabrow):?>
<div id="maintabs" class="wtabs">
  <ul class="wk tabs">
    <?php foreach ($tabrow as $j => $tbrow):?>
    <li><a data-tab="#tab_<?php echo $j++;?>" title="<?php echo $tbrow->{'title'.Lang::$lang};?>"><?php echo $tbrow->{'title'.Lang::$lang};?></a></li>
    <?php endforeach;?>
  </ul>
  <?php foreach ($tabrow as $j => $tbrow):?>
  <div id="tab_<?php echo $j++;?>" class="wk tab content"> <?php echo cleanOut($tbrow->{'body'.Lang::$lang});?> </div>
  <?php endforeach;?>
  <?php unset($tbrow);?>
  <?php unset($j);?>
</div>
<?php endif;?>
<!-- End Tab Slider /-->