<?php
  /**
   * jQuery Poll
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  define("_VALID_PHP", true);
  require_once("../../init.php");
  
  require_once(PLUGPATH . "poll/admin_class.php");
  Registry::set('Poll',new Poll());
?>
<?php
  if (!isset($_POST['poll']) || !isset($_POST['pollid'])):
      print Registry::get("Poll")->showPollQuestion();
  else:
      if (isset($_COOKIE["CMSPRO_voted" . $_POST['pollid']]) != 'yes')
          Registry::get("Poll")->updatePollResult();

      print Registry::get("Poll")->getPollResults(intval($_POST['pollid']));
  endif
?>