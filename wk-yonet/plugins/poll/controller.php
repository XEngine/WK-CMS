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
  Registry::set('Poll', new Poll());
?>
<?php
  /* == Update Poll == */
  if (isset($_POST['updatePoll'])):
      Registry::get("Poll")->updatePoll();
  endif;

  /* == Add Poll == */
  if (isset($_POST['addPoll'])):
      Registry::get("Poll")->addPoll();
  endif;

  /* == View Poll == */
  if (isset($_POST['viewPoll'])):
      print Registry::get("Poll")->showPollResults(Filter::$id);
  endif;

  /* == Delete poll == */
  if (isset($_POST['delete']) and $_POST['delete'] == "deletePoll"):
      $title = sanitize($_POST['title']);
	  $result = $db->delete(Poll::qTable, "id=" . Filter::$id);
	  $db->delete(Poll::vTable, "option_id IN(SELECT id FROM " . Poll::oTable . " WHERE question_id='" . Filter::$id . "')");
	  $db->delete(Poll::oTable, "question_id=" . Filter::$id);

      if ($result):
          $json['type'] = 'success';
          $json['title'] = Lang::$word->_SUCCESS;
          $json['message'] = Lang::$word->_PLG_PL_POLL . ' /' . $title . '/ ' . Lang::$word->_DELETED;
          Security::writeLog(Lang::$word->_PLG_PL_POLL . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "module");
      else:
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
      endif;
       print json_encode($json);
  endif;
?>