<?php
  /**
   * Main
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php $data = $core->getStats();?>
<?php $data2 = $core->getNextEvent();?>
<?php $data3 = $core->totalMembershipIncome();?>
<?php $data4 = $core->getLatestUser();?>
<?php $data5 = $core->getNotes();?>
<?php $data6 = $core->getDigiShopStats();?>
<?php $data7 = $core->getBookingStats();?>
<div class="wk icon heading message red"> <i class="icon home"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MN_TITLE;?> </div>
    <div class="wk breadcrumb">
      <div class="active section"><i class="icon dashboard"></i> <?php echo Lang::$word->_N_DASH;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MN_INFO;?></div>
  <div class="wk segment">
    <div class="wk header"><?php echo Lang::$word->_MN_SUBTITLE;?></div>
    <div class="wk fitted divider"></div>
    <?php if($user->userlevel == 9):?>
    <div class="wk-grid">
      <div class="four columns small-horizontal-gutters">
        <div class="row">
          <div class="wk info basic segment">
            <div class="screen-30"><i class="huge dimmed bullseye icon"></i> </div>
            <div class="screen-70">
              <div class="wk caps"><?php echo Lang::$word->_MN_TOTAL_V;?></div>
              <div class="wk big font"><?php echo ($data) ? $data->views : '0.00';?></div>
            </div>
            <div class="screen-50">
              <div class="wk caps"><?php echo Lang::$word->_MN_TOTAL_AVERAGE_V;?></div>
              <div><?php echo ($data) ? number_format($data->average,2) : '0.00';?></div>
            </div>
            <div class="screen-50 content-right">
              <div class="wk caps"><?php echo Lang::$word->_MN_TOTAL_AVERAGE_U;?></div>
              <div><?php echo ($data) ? number_format($data->uaverage,2) : '0.00';?></div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="wk warning basic segment">
            <div class="screen-30"><i class="huge dimmed calendar icon"></i> </div>
            <div class="screen-70">
              <div class="wk caps"><?php echo Lang::$word->_MN_UPEVENT;?></div>
              <div class="wk big font"><?php echo ($data2) ? Filter::dodate("short_date", $data2->date_start) : "-/-";?></div>
            </div>
            <div class="screen-100">
              <div class="wk caps">
                <?php if($data2):?>
                <a href="index.php?do=modules&amp;action=config&amp;modname=events&amp;maction=edit&amp;id=<?php echo $data2->id;?>"><?php echo $data2->title;?></a>
                <?php else:?>
                Nothing Yet
                <?php endif;?>
              </div>
              <div><?php echo ($data2) ? $data2->venue : "-/-";?></div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="wk positive basic segment">
            <div class="screen-30"><i class="huge dimmed payment icon"></i> </div>
            <div class="screen-70">
              <div class="wk caps"><?php echo Lang::$word->_MN_TOTAL_INCOME;?></div>
              <div class="wk big font"><?php echo ($data3) ? $core->formatMoney($data3->totalsale, false) : '0.00';?></div>
            </div>
            <div class="screen-100">
              <div class="wk caps"><?php echo Lang::$word->_MN_TOTAL_AVERAGE_S;?></div>
              <div><?php echo ($data3) ? $core->formatMoney($data3->average, false) : '0.00';?></div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="wk teal basic segment">
            <div class="screen-30"><i class="huge dimmed user icon"></i> </div>
            <div class="screen-70">
              <div class="wk caps"><?php echo Lang::$word->_MN_NEWEST_MEMBER;?></div>
              <div class="wk big font"><a href="index.php?do=users&amp;action=edit&amp;id=<?php echo $data4->id;?>"><?php echo $data4->username;?></a></div>
            </div>
            <div class="screen-100">
              <div class="wk caps"><?php echo Lang::$word->_MN_REG_SINCE;?></div>
              <div><?php echo timesince($data4->cdate);?></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="wk divider"></div>
    <div class="wk-grid">
      <div class="two columns small-horizontal-gutters">
        <?php if($data6):?>
        <div class="row">
          <div class="wk purple basic segment">
            <div class="screen-30"><i class="huge dimmed payment icon"></i> </div>
            <div class="screen-70">
              <div class="wk caps"><?php echo Lang::$word->_MN_DIGITOTAL;?></div>
              <div class="wk big font"><?php echo $core->formatMoney($data6->totalsale, false)?></div>
            </div>
            <div class="screen-100">
              <div class="wk caps"><?php echo Lang::$word->_MN_TOTAL_AVERAGE_S;?></div>
              <div><?php echo $core->formatMoney($data6->average, false);?></div>
            </div>
          </div>
        </div>
        <?php endif;?>
        <?php if($data7):?>
        <div class="row">
          <div class="wk danger basic segment">
            <div class="screen-30"><i class="huge dimmed payment icon"></i> </div>
            <div class="screen-70">
              <div class="wk caps"><?php echo Lang::$word->_MN_BOOKTOTAL;?></div>
              <div class="wk big font"><?php echo $core->formatMoney($data7->totalsale, false)?></div>
            </div>
            <div class="screen-100">
              <div class="wk caps"><?php echo Lang::$word->_MN_TOTAL_AVERAGE_S;?></div>
              <div><?php echo $core->formatMoney($data7->average, false);?></div>
            </div>
          </div>
        </div>
        <?php endif;?>
      </div>
    </div>
    <div class="wk divider"></div>
    <?php endif;?>
    <div class="clearfix small-bottom-space"> <a href="index.php" class="wk right labeled icon button push-left sdelete"><i class="trash icon"></i><?php echo Lang::$word->_MN_EMPTY_STATS;?></a>
      <div class="wk selection dropdown push-right" data-select-range="true">
        <div class="text"><?php echo Lang::$word->_MN_RANGE;?></div>
        <i class="dropdown icon"></i>
        <div class="menu">
          <div class="item" data-value="day"><?php echo Lang::$word->_MN_TODAY;?></div>
          <div class="item" data-value="week"><?php echo Lang::$word->_MN_WEEK;?></div>
          <div class="item" data-value="month"><?php echo Lang::$word->_MN_MONTH;?></div>
          <div class="item" data-value="year"><?php echo Lang::$word->_MN_YEAR;?></div>
        </div>
        <input name="range" type="hidden" value="">
      </div>
    </div>
    <div id="chart" style="height:400px;overflow:hidden"></div>
    <div class="wk divider"></div>
    <a id="newnote" class="wk icon positive button push-right"><i class="icon add"></i> <?php echo Lang::$word->_MN_NOTES_ADD;?></a>
    <div class="wk header"><?php echo Lang::$word->_MN_NOTES;?> </div>
    <div class="wk double fitted divider"></div>
    <div id="notes" class="scrollbox borderless">
      <?php if($data5):?>
      <?php foreach($data5 as $nrow):?>
      <div class="wk note <?php echo $nrow->color;?>">
        <div class="aside"><?php echo strtolower(Lang::$word->_CREATED);?><br>
          <?php echo timesince($nrow->cdate);?></div>
        <a data-id="<?php echo $nrow->id;?>" class="note-close"><i class="close icon"></i></a>
        <div class="header"><?php echo $nrow->content;?></div>
        <small>-<?php echo Lang::$word->_MN_NOTES_CREATED;?> <?php echo $nrow->username;?></small></div>
      <?php endforeach;?>
      <?php unset($nrow);?>
      <?php endif;?>
    </div>
    <div class="wk double fitted divider"></div>
    <div class="wk-grid">
      <div class="two columns small-horizontal-gutters">
        <div class="row">
          <div class="wk fitted segment">
            <div class="wk fluid inverted input top attached">
              <input placeholder="<?php echo Lang::$word->_SEARCH2;?>" type="text" name="address" id="address">
            </div>
            <div id="gmap" style="width:100%;height:350px;"></div>
          </div>
        </div>
        <div class="row">
          <div class="wk fluid input inverted top attached">
            <input placeholder="<?php echo Lang::$word->_SEARCH2;?>" type="text" name="location" id="location">
          </div>
          <div id="weather">
            <div class="weather-body clearfix">
              <div class="push-left weather-left">
                <div class="today-img content-center"></div>
                <h1 class="text-center today-temp"></h1>
              </div>
              <div class="push-right weather-place">
                <h1 class="weather-city"></h1>
                <div class="weather-region"></div>
                <h3 class="weather-currently"></h3>
              </div>
            </div>
            <div class="weather-footer clearfix">
              <div class="columns">
                <div class="screen-25 weather-footer-block">
                  <div class="1-days-day"></div>
                  <div class="1-days-image"></div>
                  <div class="1-days-temp"></div>
                </div>
                <div class="screen-25 weather-footer-block">
                  <div class="2-days-day"></div>
                  <div class="2-days-image"></div>
                  <div class="2-days-temp"></div>
                </div>
                <div class="screen-25 weather-footer-block">
                  <div class="3-days-day"></div>
                  <div class="3-days-image"></div>
                  <div class="3-days-temp"></div>
                </div>
                <div class="screen-25 weather-footer-block">
                  <div class="4-days-day"></div>
                  <div class="4-days-image"></div>
                  <div class="4-days-temp"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="globalAssets/jquery.flot.js"></script> 
<script type="text/javascript" src="globalAssets/flot.resize.js"></script> 
<script type="text/javascript" src="globalAssets/excanvas.min.js"></script> 
<script type="text/javascript" src="assets/js/location.js"></script> 
<script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3&amp;sensor=false"></script> 
<script type="text/javascript" src="assets/js/home.js"></script> 
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
    $.Home({
	  addNote: "<?php echo Lang::$word->_MN_NOTES_ADD;?>",
	  enterNote: "<?php echo Lang::$word->_MN_NOTES_ENTER;?>",
	  lat:43.652527,
	  long:-79.381961,
	  temp: 'c',
	  city: 'Toronto',
    });
});
// ]]>
</script> 