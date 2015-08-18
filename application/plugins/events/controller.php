<?php
  /**
   * Calendar
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2010
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  define("_VALID_PHP", true);
  require_once("../../init.php");

  require_once(MODPATH . "events/admin_class.php");
  Registry::set('eventManager',new eventManager());
  
  $day = isset($_POST['d']) ? sanitize($_POST['d'],2) : 0;
  $month = isset($_POST['m']) ? sanitize($_POST['m'],2) : 0;
  $year = isset($_POST['y']) ? sanitize($_POST['y'],4) : 0;
  $eventrow = Registry::get("eventManager")->getAllEvents($year, $month, $day)
?>
<?php

  if (isset($_POST['loadEvent'])):
      $html = '<div id="event-wrap">';
      if ($eventrow):
	      foreach($eventrow as $row):
		  $html .= '
		  <div class="wk message">
			<div class="content">
			  <div class="header"> ' . $row->{'title' . Lang::$lang} . ' </div>
			  <div class="wk breadcrumb"><i class="icon time"></i>
				<div class="section">' . Lang::$word->_MOD_EM_TSE . '</div>
				<div class="divider"> / </div>
				<div class="section">' . $row->time_start . '</div>
				<div class="divider"> / </div>
				<div class="section">' . $row->time_end . '</div>';
				if ($row->{'venue' . Lang::$lang}):
				$html .= '<div class="divider"> / </div>
				<div class="section">@' . $row->{'venue' . Lang::$lang} . '</div>';
				endif;
				$html .= ' </div>
			</div>
		  </div>'; 
          $html .= cleanOut(Filter::out_url($row->{'body' . Lang::$lang}));
          $html .= '<div class="wk divider"></div>';
          $html .= '<h4 class="wk header">' . Lang::$word->_MOD_EM_CONTACT . '</h4>';
          $html .= '<div class="wk celled list">';
          $html .= '<div class="item"><i class="icon user"></i> ' . $row->contact_person . '</div>';
          $html .= '<div class="item"><i class="icon mail"></i> ' . $row->contact_email . '</div>';
          $html .= '<div class="item"><i class="icon phone"></i> ' . $row->contact_phone . '</div>';
          $html .= '</div>';
		  endforeach;
      else:
          $html .= Filter::msgSingleAlert(Lang::$word->_MOD_EM_EVENT_ERR);
	  endif;
      $html .= '</div>';
      print $html;
  endif;
  
?>
<?php /*?><?php if(!$eventrow):?>
<?php echo Filter::msgSingleAlert(Lang::$word->_MOD_EM_EVENT_ERR);?>
<?php else:?>
<div class="event-wrapper">
  <div class="event-list">
  <?php foreach($eventrow as $row):?>
    <h3 class="event-title"><?php echo Lang::$word->_MOD_EM_TSE . ': ' . $row->stime . '/' . $row->etime . '</span>' . $row->{'title' . Lang::$lang};?></h3>
    <?php if ($row->{'venue' . Lang::$lang}):?>
    <h6 class="event-venue"><?php echo $row->{'venue' . Lang::$lang};?></h6>
    <?php endif;?>
    <hr />
    <div class="event-desc"><?php echo cleanOut($row->{'body' . Lang::$lang});?></div>
    <span class="contact-info-toggle"><?php echo Lang::$word->_MOD_EM_CONTACT;?></span>
    <div class="event-contact">
      <?php if ($row->{'venue' . Lang::$lang}):?>
      <div><?php echo $row->contact_person;?></div>
      <?php endif;?>
      <?php if ($row->{'venue' . Lang::$lang}):?>
      <div><?php echo $row->contact_email;?></div>
      <?php endif;?>
      <?php if ($row->{'venue' . Lang::$lang}):?>
      <div><?php echo $row->contact_phone;?></div>
      <?php endif;?>
    </div>
    <?php endforeach;?>
  </div>
</div>
<?php endif;?><?php */?>
<?php //$db->pre($db);?>