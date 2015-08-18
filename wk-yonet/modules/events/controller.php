<?php
  /**
   * Controller
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  define("_VALID_PHP", true);
  
  require_once("../../init.php");
  if (!$user->is_Admin())
      redirect_to("../../login.php");
  
  require_once("admin_class.php");
  Registry::set('eventManager', new eventManager());
?>
<?php
  /* == Process Events == */
  if (isset($_POST['processEvent'])):
      Registry::get("eventManager")->processEvent();
  endif;

  /* == Get Calendar Month == */
  if (isset($_POST['getcal'])):
      Registry::get("eventManager")->renderCalendar();
  endif;

  /* == View Events == */
  if (isset($_POST['loadEvent'])):
      $html = '<div id="event-wrap">';
      if ($row = Registry::get("eventManager")->getEvent(Filter::$id)):
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
      else:
          $html .= Filter::msgSingleAlert(Lang::$word->_MOD_EM_EVENT_ERR);
	  endif;
      $html .= '</div>';
      print $html;
  endif;
  
  /* == Delete events == */
  if (isset($_POST['delete']) and $_POST['delete'] == "deleteEvent"):
      $title = sanitize($_POST['title']);
      $result = $db->delete(eventManager::mTable, "id=" . Filter::$id);
      $db->delete(eventManager::dTable, "event_id=" . Filter::$id);

      if ($result):
          $json['type'] = 'success';
          $json['title'] = Lang::$word->_SUCCESS;
          $json['message'] = Lang::$word->_MOD_EM_EVENT . ' /' . $title . '/ ' . Lang::$word->_DELETED;
          Security::writeLog(Lang::$word->_MOD_EM_EVENT . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "module");
      else:
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
      endif;
       print json_encode($json);
  endif;
?>