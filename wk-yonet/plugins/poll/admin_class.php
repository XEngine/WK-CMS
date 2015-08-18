<?php
  /**
   * Poll Class
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  class Poll
  {

	  const oTable = "plug_poll_options";
	  const qTable = "plug_poll_questions";
	  const vTable = "plug_poll_votes";
	  
	  private static $db;


      /**
       * Poll::__construct()
       * 
       * @return
       */
      function __construct(){
		   self::$db = Registry::get("Database");
		}

	  /**
	   * Poll::getNewsItems()
	   * 
	   * @return
	   */
	  public function getPolls()
	  {
		  
		  $sql = "SELECT * FROM " . self::qTable. " ORDER BY created DESC";
		  $row = self::$db->fetch_all($sql);
		  
		  return ($row) ? $row : 0;
	  }

	  /**
	   * Poll::getPollOptions()
	   * 
	   * @return
	   */
	  public function getPollOptions()
	  {
		  
		  $sql = "SELECT * FROM " . self::oTable. " WHERE question_id = '" . Filter::$id . "' ORDER BY position";
		  $row = self::$db->fetch_all($sql);
		  
		  return ($row) ? $row : 0;
	  }
	  	  
	  /**
	   * Poll::addPoll()
	   * 
	   * @return
	   */
	  public function addPoll()
	  {
	
		  Filter::checkPost('question' . Lang::$lang, Lang::$word->_PLG_PL_QUESTION);
	
		  $question = array_filter($_POST['value'], 'strlen');
		  if (empty($question))
			  Filter::$msgs['value'] = Lang::$word->_PLG_PL_OPTIONS;
	
		  if (empty(Filter::$msgs)) {
			  $qdata = array(
				  'question' . Lang::$lang => sanitize($_POST['question' . Lang::$lang]),
				  'created' => "NOW()",
				  'status' => intval($_POST['status'])
				  );
	
			  if ($qdata['status'] == 1) {
				  $status['status'] = "DEFAULT(status)";
				  self::$db->update(self::qTable, $status);
			  }
	
			  self::$db->insert(self::qTable, $qdata);
			  $lastID = self::$db->insertid();

			  foreach ($_POST['value'] as $key => $val) {
				  $data = array(
						'value' . Lang::$lang => sanitize($val), 
						'question_id' => $lastID,
						'position' => $key
				  );
				  $res = self::$db->insert(self::oTable, $data);
			  }
	
			  if ($res) {
				  Security::writeLog(Lang::$word->_PLG_PL_ADDED, "", "no", "plugin");
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk(Lang::$word->_PLG_PL_ADDED, false);
			  } else {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
			  }
			  print json_encode($json);
	
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }

	  /**
	   * Poll::addPoll()
	   * 
	   * @return
	   */
	  public function updatePoll()
	  {
	
		  Filter::checkPost('question' . Lang::$lang, Lang::$word->_PLG_PL_QUESTION);
	
		  if (!array_filter($_POST['value' . Lang::$lang]))
			  Filter::checkPost('value' . Lang::$lang, Lang::$word->_PLG_PL_OPTIONS);
	
		  if (empty(Filter::$msgs)) {
			  $qdata = array(
				  'question' . Lang::$lang => sanitize($_POST['question' . Lang::$lang]),
				  'status' => intval($_POST['status'])
			      );
	
			  if ($qdata['status'] == 1) {
				  $status['status'] = "DEFAULT(status)";
				  self::$db->update(self::qTable, $status);
			  }
	
			  self::$db->update(self::qTable, $qdata, "id=" . Filter::$id);
	
			  foreach ($_POST['value' . Lang::$lang] as $key => $val) {
				  $data = array(
					  'value' . Lang::$lang => sanitize($val),
					  'question_id' => Filter::$id
					  //'position' => intval($key)
					  );
	
				  $res = self::$db->update(self::oTable, $data, "id=" . $key);
			  }
	
			  if ($res) {
				  Security::writeLog(Lang::$word->_PLG_PL_UPDATED, "", "no", "plugin");
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk(Lang::$word->_PLG_PL_UPDATED, false);
			  } else {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
			  }
			  print json_encode($json);
	
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }
	   
	  /**
	   * Poll::showPollResults()
	   * 
	   * @return
	   */
      public function showPollResults($poll_id)
      {
          $sql = Registry::get("Database")->query("SELECT COUNT(*) as totalvotes" 
		  . "\n FROM " . self::vTable 
		  . "\n WHERE option_id" 
		  . "\n IN(SELECT id FROM " . self::oTable . " WHERE question_id='" . (int)$poll_id . "')");
          while ($row = self::$db->fetch($sql))
              $total = $row->totalvotes;
          $query = self::$db->query("SELECT " . self::oTable . ".id, " . self::oTable . ".value" . Lang::$lang . ", COUNT(*) as votes" 
		  . "\n FROM " . self::vTable . ", " . self::oTable 
		  . "\n WHERE " . self::vTable . ".option_id = " . self::oTable . ".id" 
		  . "\n AND " . self::vTable . ".option_id" 
		  . "\n IN(SELECT id FROM " . self::oTable . " WHERE question_id='" . (int)$poll_id . "')" 
		  . "\n GROUP BY " . self::vTable . ".option_id ORDER BY position ");
          $display = '';
          while ($row = self::$db->fetch($query))
          {
              $percent = round(($row->votes * 100) / $total);
              $display .= "<div class=\"option\">" . $row->{'value' . Lang::$lang} . " (<em>" . $percent . "%, " . $row->votes . " " . Lang::$word->_PLG_PL_VOTES . "</em> )\n";
              $display .= "<div class=\"option-bar-out\"><div class=\"optionbar\" style=\"width:" . $percent . "%;\"></div></div></div>\n";
          }
          $display .= "<p>" . Lang::$word->_PLG_PL_TOTAL . " " . $total . "</p>\n";

          return $display;
      }
	  
	  /**
	   * Poll::showPollQuestion()
	   * 
	   * @return
	   */
	  public function showPollQuestion()
	  {
	
		  $sql = "SELECT id, question" . Lang::$lang . " FROM " . self::qTable . " WHERE status = 1";
		  $row = self::$db->first($sql);
	
		  print "<div class=\"question\" >" . $row->{'question' . Lang::$lang} . "</div>\n";
		  $id = intval($row->id);
	
		  if (isset($_GET["result"]) == 1 || isset($_COOKIE["CMSPRO_voted" . $id]) == 'yes') {
			  print $this->getPollResults($id);
			  exit;
		  } else {
			  $sql = self::$db->query("SELECT id, value" . Lang::$lang . " FROM " . self::oTable . " WHERE question_id={$id} ORDER BY position");
			  if (self::$db->numrows($sql)) {
				  print "<div id=\"formcontainer\" class=\"wk form\">\n";
				  print "<form method=\"post\" id=\"pollform\">\n";
				  print "<input type=\"hidden\" name=\"pollid\" value=\"" . $id . "\" />\n";
				  while ($row = self::$db->fetch($sql)) {
					  print "<div class=\"option-bar\"><label class=\"radio\"><input type=\"radio\" name=\"poll\" value=\"" . $row->id . "\" id=\"option-" . $row->id . "\"/>\n";
					  print "<i></i>" . $row->{'value' . Lang::$lang}  . "</label></div>\n";
				  }
				  print "<div class=\"wk buttons\"><a class=\"wk positive button votenow\">".Lang::$word->_PLG_PL_NOW."</a>\n";
				  print "<a href=\"" .  SITEURL . "poll/controller.php?result=1\" id=\"viewresult\" class=\"wk secondary button\">".Lang::$word->_PLG_PL_RESULT."</a></div>\n";
				  print "</form>\n";
				  print "</div>";
			  }
		  }
	  }

	  /**
	   * Poll::countTotalVotes()
	   * 
	   * @return
	   */
	  private function countTotalVotes($id)
	  {
		  
		  $sql = "SELECT COUNT(*) as totalvotes FROM " . self::vTable . "" 
		  . " \n WHERE option_id IN(SELECT id FROM " . self::oTable . " WHERE question_id=" . (int)$id . ")";
		  
		  $row = self::$db->first($sql);
		  return $row->totalvotes;
	  }

	  /**
	   * Poll::getPollResults()
	   * 
	   * @return
	   */
	  public function getPollResults($id)
	  {
		  
		  $query = "SELECT " . self::oTable . ".id, " . self::oTable . ".value" . Lang::$lang . ", COUNT(*) as votes FROM " . self::vTable . ", " . self::oTable . "" 
		  . " \n WHERE " . self::vTable . ".option_id=" . self::oTable . ".id" 
		  . " \n AND " . self::vTable . ".option_id IN(SELECT id FROM " . self::oTable . " WHERE question_id='" . (int)$id . "')" 
		  . " \n GROUP BY " . self::vTable . ".option_id";
		  
		  $html = '';
		  $showall = self::$db->fetch_all($query);
		  $total = $this->countTotalVotes($id);
		  
		  foreach ($showall as $row) {
			  $percent = round(($row->votes * 98) / $total);
			  $html .= "<div class=\"wk success active striped progress\">
			  <div class=\"bar\" style=\"width:" . $percent . "%;\">" . $percent . "%</div></div>\n";
			  $html .= "<div class=\"option\">" . $row->{'value' . Lang::$lang} . " (<em>" . $percent . "%, " . $row->votes . Lang::$word->_PLG_PL_VOTES."</em> )</div>\n";
		  }
		  $html .= "<div class=\"wk positive label totalvote\">".Lang::$word->_PLG_PL_TOTAL . $total . "</div>\n";

		  return $html;
	  }  

	  /**
	   * Poll::updatePollResult()
	   * 
	   * @return
	   */	  
	  public function updatePollResult()
	  {
	
		  $sql = self::$db->query("SELECT * FROM " . self::oTable . " WHERE id='" . intval($_POST["poll"]) . "'");
		  if (self::$db->numrows($sql)) {
			  $data['option_id'] = intval($_POST["poll"]);
			  $data['voted_on'] = "NOW()";
			  $data['ip'] = sanitize($_SERVER['REMOTE_ADDR']);
	
			  self::$db->insert(self::vTable, $data);
			  if (self::$db->affected()) {
				  setcookie("CMSPRO_voted" . intval($_POST['pollid']), 'yes', time() + 86400 * 300);
				  print "<div class=\"wk success message\">" . Lang::$word->_PLG_PL_THANKS . "</div>";
			  }
		  }
	
	  }
  }
?>