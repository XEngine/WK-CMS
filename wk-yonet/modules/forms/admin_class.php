<?php
  /**
   * Forms
   *
   * @package wk:cms
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  class Forms
  {
      const mTable = "mod_forms";
      const fTable = "mod_forms_fields";
	  const lTable = "mod_forms_layout";
	  
	  private static $db;

      /**
       * Forms::__construct()
       * 
       * @return
       */
      function __construct()
      {
		  self::$db = Registry::get("Database");

      }

      /**
       * Forms::getForms()
       * 
       * @return
       */
      public function getForms()
      {
          $sql = "SELECT *" 
		  . "\n FROM " . self::mTable 
		  . "\n ORDER BY title" . Lang::$lang;

          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Forms::processForm()
       * 
       * @return
       */
      public function processForm()
      {
          Filter::checkPost('title' . Lang::$lang, Lang::$word->_MOD_VF_FTITLE);
          Filter::checkPost('mailto', Lang::$word->_MOD_VF_MAILTO);
          Filter::checkPost('subject' . Lang::$lang, Lang::$word->_MOD_VF_FSUBJECT);
		  Filter::checkPost('sbutton' . Lang::$lang, Lang::$word->_MOD_VF_SBUTTON);
			  
          if (empty(Filter::$msgs)) {
              $data = array(
                  'title' . Lang::$lang => sanitize($_POST['title' . Lang::$lang]),
                  'mailto' => sanitize($_POST['mailto']),
				  'subject' . Lang::$lang => sanitize($_POST['subject' . Lang::$lang]),
                  'sendmessage' . Lang::$lang => sanitize($_POST['sendmessage' . Lang::$lang]),
                  'sbutton' . Lang::$lang => sanitize($_POST['sbutton' . Lang::$lang]),
				  'template' . Lang::$lang => $_POST['template' . Lang::$lang],
                  'emails' => sanitize($_POST['emails']),
                  'captcha' => intval($_POST['captcha']),
				  'created' => "NOW()"
				  );

              (Filter::$id) ? self::$db->update(self::mTable, $data, "id='" . Filter::$id . "'") : self::$db->insert(self::mTable, $data);
              $message = (Filter::$id) ? Lang::$word->_MOD_VF_UPDATED : Lang::$word->_MOD_VF_ADDED;

			  if (self::$db->affected()) {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk($message, false);
				  Security::writeLog($message, "", "no", "content");
			  } else {
				  $json['type'] = 'info';
				  $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
			  }
			  print json_encode($json);

		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
      }

      /**
       * Forms::saveFormData()
       * 
	   * @param bool $form_id
       * @return
       */
	  public function saveFormData($form_id = false)
	  {
		  $id = ($form_id) ? $form_id : Filter::$id;
	
		  $sql = "SELECT id, title" . Lang::$lang . "  FROM " . self::mTable 
		  . "\n WHERE id = '" . (int)$id . "'";
		  $formdata = self::$db->first($sql);
	
		  $fields = self::$db->fetch_all("SELECT * FROM " . self::fTable);
		  if ($formdata) {
			  $string = $_POST['formcode'];
			  foreach ($fields as $row) {
				  $string = str_replace("%%" . $row->id . "%%", $row->{'html' . Lang::$lang}, $string);
			  }
			  $data['html' . Lang::$lang] = str_replace("%","",$string);
			  $data['data' . Lang::$lang] = $_POST['htmlcode'];
			  self::$db->update(self::mTable, $data, "id='" . (int)$id . "'");
			  
			  
			  // Process Layout Fields
			  self::$db->delete(self::lTable, "form_id='" . (int)$id . "'");
			  $fields = explode(",", $_POST['layids']);
			  $query = "INSERT INTO " . self::lTable . " (form_id, field_id) VALUES ('";
			  $values = array();
	
			  foreach ($fields as $v) {
				  $values[] = $id . '\',  \'' . (int)$v;
			  }
	
			  $query .= implode('\'), (\'', $values) . '\')';
			  self::$db->query($query);
			  
			  
			  if(self::$db->affected()) {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk(Lang::$word->_MOD_VF_UPDATED, false);
			  } else {
				  $json['type'] = 'info';
				  $json['message'] = Filter::msgAlert(Lang::$word->NOPROCCESS, false);
			  }
			  print json_encode($json);
		  }
	  }
	  
      /**
       * Forms::sendForm()
       * 
       * @return
       */
	  public function sendForm()
	  {
		  $fieldData = $this->_renderFormSubmit();
		  $html = '<table width="100%" cellspacing="2" cellpadding="2" border="0">';
		  $email_to_send = false;
	
		  if ($fieldData) {
			  $form = Registry::get("Core")->getRowById(self::mTable, Filter::$id);
			  foreach ($fieldData as $row) {
				  switch ($row->type) {
					  case "field":
						  if ($row->required and empty($_POST[$row->name])) {
							  Filter::$msgs[$row->name] = ($row->{'msgerror' . Lang::$lang}) ? $row->{'msgerror' . Lang::$lang} : str_replace("[FIELDNAME]", $row->{'desc' . Lang::$lang}, Lang::$word->_MOD_VF_EMPTYFIELD);
						  } elseif (!empty($_POST[$row->name]) and $row->defval != "NA") {
							  switch ($row->defval) {
								  case "reqemail":
									  if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $_POST[$row->name]))
										  Filter::$msgs[$row->name] = Lang::$word->_MOD_VF_VEMAIL;
									  break;
								  case "requrl":
									  if (!preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $_POST[$row->name]))
										  Filter::$msgs[$row->name] = Lang::$word->_MOD_VF_VURL;
									  break;
								  case "reqletters":
									  if (!preg_match('/^[a-zA-Z]+$/', $_POST[$row->name]))
										  Filter::$msgs[$row->name] = Lang::$word->_MOD_VF_VLETTERS;
									  break;
								  case "reqnumbers":
									  if (!preg_match('/^\d+$/', $_POST[$row->name]))
										  Filter::$msgs[$row->name] = Lang::$word->_MOD_VF_VNUMBERS;
									  break;
								  case "reqletnum":
									  if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST[$row->name]))
										  Filter::$msgs[$row->name] = Lang::$word->_MOD_VF_VNUMLET;
									  break;
								  case "intdec":
									  if (!preg_match("/^[+\-]?([0-9]+,)*[0-9]+(\.[0-9]+)?$/", $_POST[$row->name]))
										  Filter::$msgs[$row->name] = Lang::$word->_MOD_VF_VINTDEC;
									  break;
								  case "ints":
									  if (!intval($_POST[$row->name]))
										  Filter::$msgs[$row->name] = Lang::$word->_MOD_VF_VINT;
									  break;
							  }
						  }
						  $html .= '<tr>
									   <td width="150" style="text-align: left; border-bottom:1px dotted rgb(102, 102, 102)">';
									   $html .= cleanOut($row->{'desc' . Lang::$lang}) . ':</td>
									   <td style="text-align: left; border-bottom:1px dotted rgb(102, 102, 102)">';
									   $html .= cleanOut($_POST[$row->name]) . '</td>
									  </tr>';
						  $email_to_send .= ($row->defval == "reqemail") ? cleanOut($_POST[$row->name]) : false;
						  break;
	
					  case "area":
						  if ($row->required and empty($_POST[$row->name])) {
							  Filter::$msgs[$row->name] = ($row->{'msgerror' . Lang::$lang}) ? $row->{'msgerror' . Lang::$lang} : str_replace("[FIELDNAME]", $row->{'desc' . Lang::$lang}, Lang::$word->_MOD_VF_EMPTYFIELD);
						  } elseif (!empty($_POST[$row->name]) and $row->defval) {
							  if (strlen($_POST[$row->name]) < $row->defval)
								  Filter::$msgs[$row->name] = str_replace("[CHARS]", $row->defval, Lang::$word->_MOD_VF_MINCHAR);
	
						  }
						  $html .= '<tr>
									   <td width="150" style="text-align: left; border-bottom:1px dotted rgb(102, 102, 102)">';
									   $html .= cleanOut($row->{'desc' . Lang::$lang}) . ':</td>
									   <td style="text-align: left; border-bottom:1px dotted rgb(102, 102, 102)">';
									   $html .= cleanOut($_POST[$row->name]) . '</td>
									  </tr>';
						  break;
	
					  case "datefield":
						  if ($row->required and empty($_POST[$row->name]))
							  Filter::$msgs[$row->name] = ($row->{'msgerror' . Lang::$lang}) ? $row->{'msgerror' . Lang::$lang} : str_replace("[FIELDNAME]", $row->{'desc' . Lang::$lang}, Lang::$word->_MOD_VF_EMPTYFIELD);
						  $html .= '<tr>
									   <td width="150" style="text-align: left; border-bottom:1px dotted rgb(102, 102, 102)">';
									   $html .= cleanOut($row->{'desc' . Lang::$lang}) . ':</td>
									   <td style="text-align: left; border-bottom:1px dotted rgb(102, 102, 102)">';
									   $html .= cleanOut($_POST[$row->name]) . '</td>
									  </tr>';
						  break;
	
					  case "colorfield":
						  if ($row->required and empty($_POST[$row->name]))
							  Filter::$msgs[$row->name] = ($row->{'msgerror' . Lang::$lang}) ? $row->{'msgerror' . Lang::$lang} : str_replace("[FIELDNAME]", $row->{'desc' . Lang::$lang}, Lang::$word->_MOD_VF_EMPTYFIELD);
						  $html .= '<tr>
									   <td width="150" style="text-align: left; border-bottom:1px dotted rgb(102, 102, 102)">';
									   $html .= cleanOut($row->{'desc' . Lang::$lang}) . ':</td>
									   <td style="text-align: left; border-bottom:1px dotted rgb(102, 102, 102)">';
									   $html .= cleanOut($_POST[$row->name]) . '</td>
									  </tr>';
						  break;
	
					  case "radio":
						  if (isset($_POST[$row->name])) {
							  $html .= '<tr>
										   <td width="150" style="text-align: left; border-bottom:1px dotted rgb(102, 102, 102)">';
										   $html .= cleanOut($row->{'desc' . Lang::$lang}) . ':</td>
										   <td style="text-align: left; border-bottom:1px dotted rgb(102, 102, 102)">';
										   $html .= cleanOut($_POST[$row->name]) . '</td>
										  </tr>';
						  }
						  break;
	
					  case "check":
						  if ($row->required and !isset($_POST[$row->name]))
							  Filter::$msgs[$row->name] = ($row->{'msgerror' . Lang::$lang}) ? $row->{'msgerror' . Lang::$lang} : str_replace("[NUM]", $row->required, Lang::$word->_MOD_VF_EL_CHAR_R);
						  if (isset($_POST[$row->name]) && is_array($_POST[$row->name])) {
							  if ($row->required and count($_POST[$row->name]) < $row->required) {
								  Filter::$msgs[$row->name] = ($row->{'msgerror' . Lang::$lang}) ? $row->{'msgerror' . Lang::$lang} : str_replace("[NUM]", $row->required, Lang::$word->_MOD_VF_EL_CHAR_R);
							  }
	
							  $html .= '<tr>';
							  $html .= '<td width="150" style="text-align: left; border-bottom:1px dotted rgb(102, 102, 102)">';
							  $html .= cleanOut($row->{'desc' . Lang::$lang}) . ':</td>';
							  $html .= '<td style="text-align: left; border-bottom:1px dotted rgb(102, 102, 102)">';
	
							  $checkdata = self::_implodeFields($_POST[$row->name], ', ');
							  $html .= $checkdata;
							  $html .= '</td></tr>';
						  }
						  break;
	
					  case "selbox":
						  if (isset($_POST[$row->name])) {
							  $html .= '<tr>';
							  $html .= '<td width="150" style="text-align: left; border-bottom:1px dotted rgb(102, 102, 102)">';
							  $html .= cleanOut($row->{'desc' . Lang::$lang}) . ':</td>';
							  $html .= '<td style="text-align: left; border-bottom:1px dotted rgb(102, 102, 102)">';
	
							  $selectdata = self::_implodeFields($_POST[$row->name], ', ');
							  $html .= $selectdata;
							  $html .= '</td></tr>';
						  }
						  break;
	
					  case "filefield":
						  if ($row->required and empty($_FILES[$row->name]['name'])) {
							  Filter::$msgs[$row->name] = ($row->{'msgerror' . Lang::$lang}) ? $row->{'msgerror' . Lang::$lang} : str_replace("[FIELDNAME]", $row->{'desc' . Lang::$lang}, Lang::$word->_MOD_VF_EMPTYFIELD);
						  } elseif (!empty($_FILES[$row->name]['name'])) {
							  $ext = substr(strrchr($_FILES[$row->name]["name"], '.'), 1);
							  $name = basename($_FILES[$row->name]["name"]);
							  $size = $_FILES[$row->name]["size"];
							  $temp = $_FILES[$row->name]["tmp_name"];
							  $newName = "FILE_" . time() . "." . strtolower($ext);
							  
							  $row->defval *= 1048576;
	
							  if ($size < $row->defval) {
								  if (strlen($row->attr) > 0) {
									  $exts = explode(',', $row->attr);
									  if (!in_array(strtolower($ext), $exts)) {
										  Filter::$msgs[$row->name] = Lang::$word->_MOD_VF_FILEERR2 . $row->attr;
									  }
								  }
							  } else {
								  if ($row->defval < 1000000) {
									  $rsi = round($row->defval / 1024, 2) . ' Kb';
								  } else {
									  if ($row->defval < 1000000000) {
										  $rsi = round($row->defval / 1048576, 2) . ' Mb';
									  } else {
										  $rsi = round($row->defval / 1073741824, 2) . ' Gb';
									  }
									  Filter::$msgs[$row->name] = Lang::$word->_MOD_VF_FILEERR1 . $rsi;
								  }
							  }
							  
							  if(empty(Filter::$msgs)) {
								  move_uploaded_file($temp, UPLOADS . 'files/' . $newName);
							  }
							  $url = UPLOADURL . 'files/' . $newName;
							  $html .= '<tr>
										   <td width="150" style="text-align: left; border-bottom:1px dotted rgb(102, 102, 102)">';
										   $html .= cleanOut($row->{'desc' . Lang::$lang}) . ':</td>
										   <td style="text-align: left; border-bottom:1px dotted rgb(102, 102, 102)">
										   ' . '<a href="' . $url . '">' . $_FILES[$row->name]['name'] . '</a></td>
										  </tr>';
						  }
	
						  break;
				  }
			  }
			  
			  $html .= '</table>';
	
	
			  if (isset($_POST['has_captcha'])) {
				  if (empty($_POST['captcha']))
					  Filter::$msgs['captcha'] = Lang::$word->_MOD_VF_FILEERR3;
	
				  if ($_SESSION['captchacode'] != $_POST['captcha'])
					  Filter::$msgs['captcha'] = Lang::$word->_MOD_VF_FILEERR4;
			  }
	
			  if (empty(Filter::$msgs)) {
				  require_once (BASEPATH . "lib/class_mailer.php");
				  $mailer = Mailer::sendMail();
				  $subject = $form->{'subject' . Lang::$lang};
	
				  $body = str_replace(array('[FORMNAME]', '[FORMDATA]'), 
				  array($form->{'title' . Lang::$lang}, $html), $form->{'template'.Lang::$lang});
				  
				  $fromEmail = ($email_to_send) ? $email_to_send : Registry::get("Core")->site_email;
				  $msg = Swift_Message::newInstance()
						  ->setSubject($subject)
						  ->setTo(array($form->mailto => Registry::get("Core")->site_name))
						  ->setFrom(array($fromEmail => Registry::get("Core")->site_name))
						  ->setBody(cleanOut($body), 'text/html');
	
				  $emaildata = explode(";", $form->emails);
				  if (count($emaildata) > 1) {
					  $msg->setCc($emaildata);
				  }
	              
				  if ($mailer->send($msg)) {
					  $json['status'] = 'success';
					  $json['message'] = Filter::msgOk(Lang::$word->_MOD_VF_SENTOK . '<br />' . $form->{'sendmessage' . Lang::$lang}, false);
			          Security::writeLog(Lang::$word->_MOD_VF_SENTOK . '<br />' . $form->{'sendmessage' . Lang::$lang}, "", "no", "module");
					  print json_encode($json);
				  }
	
			  } else {
				  $json['message'] = Filter::msgStatus();
				  print json_encode($json);
			  }
	
		  }
	  }

      /**
       * Forms::getFields()
       * 
       * @return
       */
      public function getFields()
      {
          $sql = "SELECT * FROM " . self::fTable 
		  . " \n ORDER BY type";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }
	  
      /**
       * Forms::_renderFormSubmit()
       * 
       * @return
       */
      private function _renderFormSubmit()
      {
          $sql = "SELECT l.*, f.title" . Lang::$lang . ", f.name, f.desc" . Lang::$lang . ", f.msgerror" . Lang::$lang . ","
		  . "\n f.tooltip" . Lang::$lang . ", f.type, f.attr, f.defval, f.required, f.multiple, f.other"  
		  . "\n FROM " . self::lTable . " l" 
		  . "\n INNER JOIN " . self::fTable . " f ON f.id = l.field_id" 
		  . "\n WHERE l.form_id = " . Filter::$id;

          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }
	  
      /**
       * Forms::getAllFields()
       * 
       * @return
       */
      public function getAllFields()
      {
          $sql = "SELECT *" 
		  . "\n FROM " . self::fTable 
		  . "\n ORDER BY type";

          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Forms::loadFormField()
       * 
	   * @param array $row
       * @return
       */
      public static function loadFormField($row)
      {
          switch ($row->type) {

              case "radio":
					$html = '
					<div class="two fields">
					  <div class="field">
						<div class="wk header">' . Lang::$word->_MOD_VF_EL_OPTIONS . '</div>
					  </div>
					  <div class="field">
						<div class="push-right">
						  <div class="wk small icon buttons"> <a id="btnrAdd" class="wk positive button"><i class="icon add"></i></a> 
						  <a id="btnDel" class="wk negative button"><i class="icon minus"></i></a> </div>
						</div>
					  </div>
					</div>
					<div class="wk thin top attached divider"></div>
					<div class="two fields">
					  <div class="field">
						<label>' . Lang::$word->_MOD_VF_EL_ITEM . '</label>
					  </div>
					  <div class="field">
						<label>' . Lang::$word->_MOD_VF_EL_DEFAULT . '</label>
					  </div>
					</div>';
					$radio_arr = explode("::", $row->attr);
					reset($radio_arr);
					$html .= '<div class="fieldholder">';
					foreach ($radio_arr as $i => $rselect) {
						$k = $i + 1;
						$sel = ($k == $row->defval) ? ' checked = "checked"' : null;
						$html .= '
						<div class="two fields clonedInput" id="container' . $k . '">
						  <div class="field">
							<input type="text" name="' . $row->name . '[]" value="' . $rselect . '">
						  </div>
						  <div class="field">
							<label class="radio">
							  <input type="radio" value="' . $k . '" name="defval[]"' . $sel . '>
							  <i></i>&nbsp;</label>
						  </div>
						</div>';
					}
					$html .= '</div>';
					unset($rselect);
					$html .= '
					 <div class="wk small block header">' . Lang::$word->_MOD_VF_EL_LAY_TYPE . '</div>
					  <div class="field">
						<div class="inline-group">
						  <label class="radio">
							<input type="radio" value="block" name="other"'; $html .=($row->other == "block") ? 'checked="checked"' : null; $html .='>
							<i></i>' . Lang::$word->_MOD_VF_EL_LAY_TYPEB . '</label>
						  <label class="radio">
							<input type="radio" value="inline" name="other"'; $html .=($row->other == "inline") ? 'checked="checked"' : null; $html .='>
							<i></i>' . Lang::$word->_MOD_VF_EL_LAY_TYPEI . '</label>
						</div>
					  </div>';
                  break;

              case "check":
					$html = '
					<div class="two fields">
					  <div class="field">
						<div class="wk header">' . Lang::$word->_MOD_VF_EL_OPTIONS . '</div>
					  </div>
					  <div class="field">
						<div class="push-right">
						  <div class="wk small icon buttons"> <a id="btncAdd" class="wk positive button"><i class="icon add"></i></a> 
						  <a id="btnDel" class="wk negative button"><i class="icon minus"></i></a> </div>
						</div>
					  </div>
					</div>
					<div class="wk thin top attached divider"></div>
					<div class="two fields">
					  <div class="field">
						<label>' . Lang::$word->_MOD_VF_EL_ITEM . '</label>
					  </div>
					  <div class="field">
						<label>' . Lang::$word->_MOD_VF_EL_DEFAULT . '</label>
					  </div>
					</div>';
					$check_arr = explode("::", $row->attr);
					$selarr = explode('::', $row->defval);
					reset($check_arr);
					$html .= '<div class="fieldholder">';
					foreach ($check_arr as $i => $cselect) {
						$k = $i + 1;
						$sel = (in_array($k, $selarr)) ? ' checked = "checked"' : null;
						$html .= '
						<div class="two fields clonedInput" id="container' . $k . '">
						  <div class="field">
							<input type="text" name="' . $row->name . '[]" value="' . $cselect . '">
						  </div>
						  <div class="field">
							<label class="checkbox">
							  <input type="checkbox" value="' . $k . '" name="defval[]"' . $sel . '>
							  <i></i>&nbsp;</label>
						  </div>
						</div>';
					}
					$html .= '</div>';
					unset($cselect);
					$html .= '
					 <div class="wk small block header">' . Lang::$word->_MOD_VF_EL_LAY_TYPE . '</div>
					  <div class="field">
						<div class="inline-group">
						  <label class="radio">
							<input type="radio" value="block" name="other"'; $html .=($row->other == "block") ? 'checked="checked"' : null; $html .='>
							<i></i>' . Lang::$word->_MOD_VF_EL_LAY_TYPEB . '</label>
						  <label class="radio">
							<input type="radio" value="inline" name="other"'; $html .=($row->other == "inline") ? 'checked="checked"' : null; $html .='>
							<i></i>' . Lang::$word->_MOD_VF_EL_LAY_TYPEI . '</label>
						</div>
					</div>
					<div class="wk small block header">' . Lang::$word->_MOD_VF_EL_CHECKVALID . '</div>
					<div class="field">
					  <div class="inline-group">
						<label class="input">
						  <i class="icon-append icon check"></i>
						  <input type="text" value="' . $row->required . '" name="required">
						</label>
					  </div>
					  <p class="wk note">' . Lang::$word->_MOD_VF_EL_REQFIELD2 . '</p>
					</div>';
                  break;

              case "selbox":
					$html = '
					<div class="two fields">
					  <div class="field">
						<div class="wk header">' . Lang::$word->_MOD_VF_EL_OPTIONS . '</div>
					  </div>
					  <div class="field">
						<div class="push-right">
						  <div class="wk small icon buttons"> <a id="btncAdd" class="wk positive button"><i class="icon add"></i></a> 
						  <a id="btnDel" class="wk negative button"><i class="icon minus"></i></a> </div>
						</div>
					  </div>
					</div>
					<div class="wk thin top attached divider"></div>
					<div class="two fields">
					  <div class="field">
						<label>' . Lang::$word->_MOD_VF_EL_ITEM . '</label>
					  </div>
					  <div class="field">
						<label>' . Lang::$word->_MOD_VF_EL_DEFAULT . '</label>
					  </div>
					</div>';
					$sellect_arr = explode("::", $row->attr);
					$selarr = explode('::', $row->defval);
					reset($sellect_arr);
					$multi = ($row->multiple) ? ' checked = "checked"' : null;
					$html .= '<div class="fieldholder temps">';
					foreach ($sellect_arr as $i => $cselect) {
						$k = $i + 1;
						$sel = (in_array($k, $selarr)) ? ' checked = "checked"' : null;
						$html .= '
						<div class="two fields clonedInput" id="container' . $k . '">
						  <div class="field">
							<input type="text" name="' . $row->name . '[]" value="' . $cselect . '">
						  </div>
						  <div class="field">
							<label class="checkbox">
							  <input type="checkbox" value="' . $k . '" name="defval[]"' . $sel . '>
							  <i></i>&nbsp;</label>
						  </div>
						</div>';
					}
					$html .= '</div>';
					unset($cselect);
					$html .= '
					<div class="wk divider"></div>
					<div class="two fields singlecheck">
					  <div class="field">
						<label class="checkbox">
						  <input type="checkbox" name="multiple" class="itemcheck" value="1"' . $multi . '>
						  <i></i>' . Lang::$word->_MOD_VF_EL_MULTIOPT . ' </label>
					  </div>
					  <div class="field">
						<label class="checkbox">
						  <input type="checkbox" name="other" class="itemcheck" value="countrylist"'; getChecked($row->other, "country"); $html .= '>
						  <i></i>' . Lang::$word->_COUNTRY_LIST . ' </label>
					  </div>
				   </div>';
                  break;

              case "filefield":
					$html = '
					<div class="wk small block header">' . Lang::$word->_MOD_VF_EL_FILEVALID . '</div>
					<div class="two fields">
					  <div class="field">
						<label>' . Lang::$word->_MOD_VF_EL_EXTENSION . '</label>
						<label class="input">
						  <input type="text" name="attr" value="' . $row->attr . '">
						</label>
						<p class="note">' . Lang::$word->_MOD_VF_EL_EXTENSION_T . '</p>
					  </div>
					  <div class="field">
						<label>' . Lang::$word->_MOD_VF_EL_FILESIZE . '</label>
						<label class="input">
						  <input type="text" name="defval" value="' . $row->defval . '">
						</label>
						<p class="note">' . Lang::$word->_MOD_VF_EL_FILESIZE_T . '</p>
					  </div>
					</div>';
					$req = ($row->required) ? ' checked = "checked"' : null;
					$html .= '
					<div class="field">
					  <label class="checkbox">
						<input type="checkbox" ' . $req . ' name="required" value="1">
						<i></i>' . Lang::$word->_MOD_VF_EL_REQFIELD . ' </label>
					</div>';
                  break;

              case "datefield":
					$html = '
					<div class="wk small block header">' . Lang::$word->_MOD_VF_EL_DATEVALID . '</div>
					<div class="field">
					  <label>' . Lang::$word->_MOD_VF_EL_DATEFORMAT . '</label>
					  <label class="input">
						<input type="text" name="defval" value="' . $row->defval . '" placeholder="' . Lang::$word->_MOD_VF_EL_DATEFORMAT . '">
					  </label>
					  <p class="note">' . Lang::$word->_MOD_VF_EL_DATEFORMAT_T . '</p>
					</div>';
                    $req = ($row->required) ? ' checked = "checked"' : null;
					$html .= '
					<div class="field">
					  <label class="checkbox">
						<input type="checkbox" ' . $req . ' name="required" value="1">
						<i></i>' . Lang::$word->_MOD_VF_EL_REQFIELD . ' </label>
					</div>';
                  break;
				  
              case "colorfield":
					$html = '
					<div class="wk small block header">' . Lang::$word->_MOD_VF_EL_COLORVALID . '</div>
					<div class="field">
					  <label>' . Lang::$word->_MOD_VF_EL_COLOROPT . '</label>
					  <label class="input">
						<input type="text" name="attr" value="' . $row->attr . '" placeholder="' . Lang::$word->_MOD_VF_EL_COLOROPT . '">
					  </label>
					  <p class="note">' . Lang::$word->_MOD_VF_EL_COLOROPT_T . '</p>
					</div>';
                    $req = ($row->required) ? ' checked = "checked"' : null;
					$html .= '
					<div class="field">
					  <label class="checkbox">
						<input type="checkbox" ' . $req . ' name="required" value="1">
						<i></i>' . Lang::$word->_MOD_VF_EL_REQFIELD . ' </label>
					</div>';
                  break;
				  
              case "imgfield":
					list($width, $height) = explode('::', $row->defval);
					$w = ($width) ? $width : 100;
					$h = ($height) ? $height : 75;
					$html = '
					<div class="wk small block header">' . Lang::$word->_MOD_VF_EL_FIELDVALID . '</div>
					<div class="two fields">
					  <div class="field">
						<label>' . Lang::$word->_MOD_VF_EL_SELIMG . '</label>
						<div class="wk action input">
						  <input name="attr" type="text" value="' . $row->attr . '" data-ext="images" readonly>
						  <div class="filepicker wk icon button"><i class="open folder icon"></i></div>
						</div>
					  </div>
					  <div class="field">
						<label>' . Lang::$word->_MOD_VF_EL_THUMBSIZE . '</label>
						<div class="two fields">
						  <div class="field">
							<input type="text" name="thumb_w" value="' . $w . '">
						  </div>
						  <div class="field">
							<input type="text" name="thumb_h" value="' . $h . '">
						  </div>
						</div>
					  </div>
					</div>';  
                  break;
				  
              case "labelfield":
			        $html = '';
                  break;
				  
              case "parafield":
					$html = '
					<div class="wk small block header">' . Lang::$word->_MOD_VF_EL_FIELDVALID . '</div>
					<div class="field">
					  <textarea id="htmlpost' . time() . '" class="htmlpost" name="attr">' . $row->attr . '</textarea>
					</div>';
                  break;

              case "hr":
			        $html = '';
                  break;
				   
              case "area":
					$html = '
					<div class="wk small block header">' . Lang::$word->_MOD_VF_EL_FIELDVALID . '</div>
					<div class="field">
					  <div class="inline-group">
						<label>' . Lang::$word->_MOD_VF_EL_MINCHAR . '</label>
						<label class="input">
						  <input type="text" name="defval" placeholder="' . Lang::$word->_MOD_VF_EL_MINCHAR . '" value="' . $row->defval . '">
						</label>
					  </div>
					  <p class="note">' . Lang::$word->_MOD_VF_EL_MINCHAR_T . '</p>
					</div>';
					$req = ($row->required) ? ' checked = "checked"' : null;
					$html .= '
					<div class="field">
					  <label class="checkbox">
						<input type="checkbox" ' . $req . ' name="required" value="1">
						<i></i>' . Lang::$word->_MOD_VF_EL_REQFIELD . ' </label>
					</div>';
                  break;

              case "field":
                    $html = '
					<div class="wk small block header">' . Lang::$word->_MOD_VF_EL_FIELDVALID . '</div>
					<div class="field">
					  <div class="inline-group">
						<label class="radio">
						  <input type="radio" value="NA" name="defval"'; $html .=($row->defval == "NA") ? 'checked="checked"' : null; $html .='>
						  <i></i>' . Lang::$word->_MOD_VF_EL_NOVALID . ' </label>
						<label class="radio">
						  <input type="radio" value="reqemail" name="defval"'; $html .=($row->defval == "reqemail") ? 'checked="checked"' : null; $html .='>
						  <i></i>' . Lang::$word->_MOD_VF_EL_VALIDEMAIL . ' </label>
						<label class="radio">
						  <input type="radio" value="requrl" name="defval"'; $html .=($row->defval == "requrl") ? 'checked="checked"' : null; $html .='>
						  <i></i>' . Lang::$word->_MOD_VF_EL_VALIDURL . ' </label>
						<label class="radio">
						  <input type="radio" value="reqletters" name="defval"'; $html .=($row->defval == "reqletters") ? 'checked="checked"' : null; $html .='>
						  <i></i>' . Lang::$word->_MOD_VF_EL_LETTERSONLY . ' </label>
						<label class="radio">
						  <input type="radio" value="reqnumbers" name="defval"'; $html .=($row->defval == "reqnumbers") ? 'checked="checked"' : null; $html .='>
						  <i></i>' . Lang::$word->_MOD_VF_EL_NUMBERSONLY . ' </label>
						<label class="radio">
						  <input type="radio" value="reqletnum" name="defval"'; $html .=($row->defval == "reqletnum") ? 'checked="checked"' : null; $html .='>
						  <i></i>' . Lang::$word->_MOD_VF_EL_LETNUMONLY . ' </label>
						<label class="radio">
						  <input type="radio" value="intdec" name="defval"'; $html .=($row->defval == "intdec") ? 'checked="checked"' : null; $html .='>
						  <i></i>' . Lang::$word->_MOD_VF_EL_INTSDEC . ' </label>
						<label class="radio">
						  <input type="radio" value="ints" name="defval"'; $html .=($row->defval == "ints") ? 'checked="checked"' : null; $html .='>
						  <i></i>' . Lang::$word->_MOD_VF_EL_INTSONLY . ' </label>
					  </div>
					</div>';
                    $req = ($row->required) ? ' checked = "checked"' : null;
					$html .= '
					<div class="field">
					  <label class="checkbox">
						<input type="checkbox" ' . $req . ' name="required" value="1">
						<i></i>' . Lang::$word->_MOD_VF_EL_REQFIELD . ' </label>
					</div>';
                  break;
				  
          }
		  return $html;
      }  

      /**
       * Forms::addFormField()
       * 
	   * @param array $type
       * @return
       */
      public static function addFormField($type)
      {
          switch ($type) {
              case "radio":
					$html = '
					<div class="two fields">
					  <div class="field">
						<div class="wk header">' . Lang::$word->_MOD_VF_EL_OPTIONS . '</div>
					  </div>
					  <div class="field">
						<div class="push-right">
						  <div class="wk small icon buttons"> <a class="wk positive button" id="btnrAdd"><i class="icon add"></i></a> 
						  <a class="wk negative button" id="btnDel"><i class="icon minus"></i></a> </div>
						</div>
					  </div>
					</div>
					<div class="wk thin top attached divider"></div>
					<div class="two fields">
					  <div class="field">
						<label>' . Lang::$word->_MOD_VF_EL_ITEM . '</label>
					  </div>
					  <div class="field">
						<label>' . Lang::$word->_MOD_VF_EL_DEFAULT . '</label>
					  </div>
					</div>
					<div class="fieldholder">
					  <div id="container1" class="two fields clonedInput">
						<div class="field">
						  <input type="text" placeholder="' . Lang::$word->_MOD_VF_EL_ITEM . '" name="radio[]">
						</div>
						<div class="field">
						  <label class="radio">
							<input type="radio" name="defval" value="1">
							<i></i>&nbsp;</label>
						</div>
					  </div>
					</div>
					<div class="wk small block header">' . Lang::$word->_MOD_VF_EL_LAY_TYPE . '</div>
					<div class="field">
					  <div class="inline-group">
						<label class="radio">
						  <input type="radio" checked="checked" name="other" value="block">
						  <i></i>' . Lang::$word->_MOD_VF_EL_LAY_TYPEB . '</label>
						<label class="radio">
						  <input type="radio" name="other" value="inline">
						  <i></i>' . Lang::$word->_MOD_VF_EL_LAY_TYPEI . '</label>
					  </div>
					</div>';

                  break;
				  
              case "check":
					$html = '
					<div class="two fields">
					  <div class="field">
						<div class="wk header">' . Lang::$word->_MOD_VF_EL_OPTIONS . '</div>
					  </div>
					  <div class="field">
						<div class="push-right">
						  <div class="wk small icon buttons"> <a class="wk positive button" id="btncAdd"><i class="icon add"></i></a> 
						  <a class="wk negative button" id="btnDel"><i class="icon minus"></i></a> </div>
						</div>
					  </div>
					</div>
					<div class="wk thin top attached divider"></div>
					<div class="two fields">
					  <div class="field">
						<label>' . Lang::$word->_MOD_VF_EL_ITEM . '</label>
					  </div>
					  <div class="field">
						<label>' . Lang::$word->_MOD_VF_EL_DEFAULT . '</label>
					  </div>
					</div>
					<div class="fieldholder">
					  <div id="container1" class="two fields clonedInput">
						<div class="field">
						  <input type="text" placeholder="' . Lang::$word->_MOD_VF_EL_ITEM . '" name="check[]">
						</div>
						<div class="field">
						  <label class="checkbox">
							<input type="checkbox" name="defval" value="1">
							<i></i>&nbsp;</label>
						</div>
					  </div>
					</div>
					<div class="wk small block header">' . Lang::$word->_MOD_VF_EL_LAY_TYPE . '</div>
					<div class="field">
					  <div class="inline-group">
						<label class="radio">
						  <input type="radio" checked="checked" name="other" value="block">
						  <i></i>' . Lang::$word->_MOD_VF_EL_LAY_TYPEB . '</label>
						<label class="radio">
						  <input type="radio" name="other" value="inline">
						  <i></i>' . Lang::$word->_MOD_VF_EL_LAY_TYPEI . '</label>
					  </div>
					</div>
					<div class="wk small block header">' . Lang::$word->_MOD_VF_EL_CHECKVALID . '</div>
					<div class="field">
					  <div class="inline-group">
						<label class="input">
						  <i class="icon-append icon check"></i>
						  <input type="text" name="required">
						</label>
					  </div>
					  <p class="wk note">' . Lang::$word->_MOD_VF_EL_REQFIELD2 . '</p>
					</div>';
                  break;
				  
              case "selbox":
					$html = '
					<div class="two fields">
					  <div class="field">
						<div class="wk header">' . Lang::$word->_MOD_VF_EL_OPTIONS . '</div>
					  </div>
					  <div class="field">
						<div class="push-right">
						  <div class="wk small icon buttons"> <a class="wk positive button" id="btncAdd"><i class="icon add"></i></a> 
						  <a class="wk negative button" id="btnDel"><i class="icon minus"></i></a> </div>
						</div>
					  </div>
					</div>
					<div class="wk thin top attached divider"></div>
					<div class="two fields">
					  <div class="field">
						<label>' . Lang::$word->_MOD_VF_EL_ITEM . '</label>
					  </div>
					  <div class="field">
						<label>' . Lang::$word->_MOD_VF_EL_DEFAULT . '</label>
					  </div>
					</div>
					<div class="fieldholder temps">
					  <div id="container1" class="two fields clonedInput">
						<div class="field">
						  <input type="text" placeholder="' . Lang::$word->_MOD_VF_EL_ITEM . '" name="selbox[]">
						</div>
						<div class="field">
						  <label class="checkbox">
							<input type="checkbox" name="defval" value="1">
							<i></i>&nbsp;</label>
						</div>
					  </div>
					</div>
					<div class="wk divider"></div>
					<div class="two fields singlecheck">
					  <div class="field">
						<label class="checkbox">
						  <input type="checkbox" name="multiple" class="itemcheck" value="1">
						  <i></i>' . Lang::$word->_MOD_VF_EL_MULTIOPT . ' </label>
					  </div>
					  <div class="field">
						<label class="checkbox">
						  <input type="checkbox" name="other" class="itemcheck" value="countrylist">
						  <i></i>' . Lang::$word->_COUNTRY_LIST . ' </label>
					  </div>
				   </div>';	
                  break;
				  
              case "filefield":
					$html = '
					<div class="wk small block header">' . Lang::$word->_MOD_VF_EL_FILEVALID . '</div>
					<div class="two fields">
					  <div class="field">
						<label>' . Lang::$word->_MOD_VF_EL_EXTENSION . '</label>
						<label class="input">
						  <input type="text" name="attr" placeholder="' . Lang::$word->_MOD_VF_EL_EXTENSION . '">
						</label>
						<p class="note">' . Lang::$word->_MOD_VF_EL_EXTENSION_T . '</p>
					  </div>
					  <div class="field">
						<label>' . Lang::$word->_MOD_VF_EL_FILESIZE . '</label>
						<label class="input">
						  <input type="text" name="defval" placeholder="' . Lang::$word->_MOD_VF_EL_FILESIZE . '">
						</label>
						<p class="note">' . Lang::$word->_MOD_VF_EL_FILESIZE_T . '</p>
					  </div>
					</div>
					<div class="field">
					  <div class="inline-group">
					    <label class="checkbox">
						<input type="checkbox" name="required" value="1">
						<i></i>' . Lang::$word->_MOD_VF_EL_REQFIELD . ' </label>
					  </div>
					</div>';
                  break;
				  
              case "datefield":
					$html = '
					<div class="wk small block header">' . Lang::$word->_MOD_VF_EL_DATEVALID . '</div>
					<div class="field">
					  <label>' . Lang::$word->_MOD_VF_EL_DATEFORMAT . '</label>
					  <label class="input">
						<input type="text" name="defval" placeholder="' . Lang::$word->_MOD_VF_EL_DATEFORMAT . '">
					  </label>
					  <p class="note">' . Lang::$word->_MOD_VF_EL_DATEFORMAT_T . '</p>
					</div>
					<div class="field">
					  <div class="inline-group">
					    <label class="checkbox">
						  <input type="checkbox" name="required" value="1">
						  <i></i>' . Lang::$word->_MOD_VF_EL_REQFIELD . ' </label>
					  </div>
					</div>';
                  break;
				  
              case "colorfield":
					$html = '
					<div class="wk small block header">' . Lang::$word->_MOD_VF_EL_COLORVALID . '</div>
					<div class="field">
					  <label>' . Lang::$word->_MOD_VF_EL_COLOROPT . '</label>
					  <label class="input">
						<input type="text" name="attr" placeholder="' . Lang::$word->_MOD_VF_EL_COLOROPT . '">
					  </label>
					  <p class="note">' . Lang::$word->_MOD_VF_EL_COLOROPT_T . '</p>
					</div>
					<div class="field">
					  <div class="inline-group">
					    <label class="checkbox">
						<input type="checkbox" name="required" value="1">
						<i></i>' . Lang::$word->_MOD_VF_EL_REQFIELD . ' </label>
					  </div>
					</div>';
                  break;
				  
              case "imgfield":
					$html = '
					<div class="wk small block header">' . Lang::$word->_MOD_VF_EL_FIELDVALID . '</div>
					<div class="two fields">
					  <div class="field">
						<label>' . Lang::$word->_MOD_VF_EL_SELIMG . '</label>
						<div class="wk action input">
						  <input name="attr" type="text" data-ext="images" readonly>
						  <div class="filepicker wk icon button"><i class="open folder icon"></i></div>
						</div>
					  </div>
					  <div class="field">
						<label>' . Lang::$word->_MOD_VF_EL_THUMBSIZE . '</label>
						<div class="two fields">
						  <div class="field">
							<input type="text" name="thumb_w">
						  </div>
						  <div class="field">
							<input type="text" name="thumb_h">
						  </div>
						</div>
					  </div>
					</div>';  
                  break;
				  
              case "labelfield":
			        $html = '';
                  break;
				  
              case "parafield":
					$html = '
					<div class="wk small block header">' . Lang::$word->_MOD_VF_EL_FIELDVALID . '</div>
					<div class="field">
					  <textarea id="htmlpost' . time() . '" class="htmlpost" name="attr">html content supported</textarea>
					</div>';
                  break;

              case "hr":
			        $html = '';
                  break;
				  	  
              case "area":
					$html = '
					<div class="wk small block header">' . Lang::$word->_MOD_VF_EL_FIELDVALID . '</div>
					<div class="field">
					  <div class="inline-group">
						<label>' . Lang::$word->_MOD_VF_EL_MINCHAR . '</label>
						<label class="input">
						  <input type="text" name="defval" placeholder="' . Lang::$word->_MOD_VF_EL_MINCHAR . '">
						</label>
					  </div>
					  <p class="note">' . Lang::$word->_MOD_VF_EL_MINCHAR_T . '</p>
					</div>
					<div class="field">
					  <label class="checkbox">
						<input type="checkbox" name="required" value="1">
						<i></i>' . Lang::$word->_MOD_VF_EL_REQFIELD . ' </label>
					</div>';
                  break;
				  
              case "field":
                    $html = '
					<div class="wk small block header">' . Lang::$word->_MOD_VF_EL_FIELDVALID . '</div>
					<div class="field">
					  <div class="inline-group">
						<label class="radio">
						  <input type="radio" value="NA" name="defval">
						  <i></i>' . Lang::$word->_MOD_VF_EL_NOVALID . ' </label>
						<label class="radio">
						  <input type="radio" value="reqemail" name="defval">
						  <i></i>' . Lang::$word->_MOD_VF_EL_VALIDEMAIL . ' </label>
						<label class="radio">
						  <input type="radio" value="requrl" name="defval">
						  <i></i>' . Lang::$word->_MOD_VF_EL_VALIDURL . ' </label>
						<label class="radio">
						  <input type="radio" value="reqletters" name="defval">
						  <i></i>' . Lang::$word->_MOD_VF_EL_LETTERSONLY . ' </label>
						<label class="radio">
						  <input type="radio" value="reqnumbers" name="defval">
						  <i></i>' . Lang::$word->_MOD_VF_EL_NUMBERSONLY . ' </label>
						<label class="radio">
						  <input type="radio" value="reqletnum" name="defval">
						  <i></i>' . Lang::$word->_MOD_VF_EL_LETNUMONLY . ' </label>
						<label class="radio">
						  <input type="radio" value="intdec" name="defval">
						  <i></i>' . Lang::$word->_MOD_VF_EL_INTSDEC . ' </label>
						<label class="radio">
						  <input type="radio" value="ints" name="defval">
						  <i></i>' . Lang::$word->_MOD_VF_EL_INTSONLY . ' </label>
					  </div>
					</div>
					<div class="field">
					  <label class="checkbox">
						<input type="checkbox" name="required" value="1">
						<i></i>' . Lang::$word->_MOD_VF_EL_REQFIELD . ' </label>
					</div>';
                  break;
		  }
		  return $html;
		  
	  }
	  
      /**
       * Forms::processField()
       * 
       * @return
       */
      public function processField()
      {

          Filter::checkPost('title' . Lang::$lang, Lang::$word->_MOD_VF_FTITLEREQ);
          Filter::checkPost('desc' . Lang::$lang, Lang::$word->_MOD_VF_FLABREQ);

		  if (isset($_POST['type']) and $_POST['type'] == "imgfield") {
			  if (empty($_POST['attr'])) {
				  Filter::$msgs['attr'] = Lang::$word->_MOD_VF_EL_SELIMG;
			  }
		  }
		  
          if (empty(Filter::$msgs)) {
              $data = array(
                  'title' . Lang::$lang => sanitize($_POST['title' . Lang::$lang]),
                  'desc' . Lang::$lang => sanitize($_POST['desc' . Lang::$lang]),
                  'msgerror' . Lang::$lang => isset($_POST['msgerror' . Lang::$lang]) ? sanitize($_POST['msgerror' . Lang::$lang]) : "NULL",
                  'tooltip' . Lang::$lang => isset($_POST['tooltip' . Lang::$lang]) ? sanitize($_POST['tooltip' . Lang::$lang]) : "NULL",
				  );

              switch ($_POST['type']) {
                  case "radio":
					  $data2 = array(
						  'defval' => isset($_POST['defval']) ? intval($_POST['defval']) : "NULL",
						  'type' => "radio",
						  'other' => sanitize($_POST['other'])
						  );
				  
					  if (Filter::$id) {
						  self::$db->update(self::fTable, array_merge($data, $data2), "id=" . Filter::$id);
						  $rows = Registry::get("Core")->getRowById(self::fTable, Filter::$id);
						  $htmldata['html' . Lang::$lang] = Filter::clean($this->_renderRadio($rows));
						  if (isset($_POST[$rows->name])) {
							  if (is_array($_POST[$rows->name])) {
								  $htmldata['attr'] = self::_implodeFields($_POST[$rows->name]);
							  }
						  } else {
							  $htmldata['attr'] = "NULL";
						  }
						  self::$db->update(self::fTable, $htmldata, "id=" . Filter::$id);
						  $msg = Lang::$word->_MOD_VF_FUPDATED;
					  } else {
						  $data2['name'] = self::randName('radio');
						  if (isset($_POST['radio'])) {
							  if (is_array($_POST['radio'])) {
								  $data['attr'] = self::_implodeFields($_POST['radio']);
							  }
						  } else {
							  $data['attr'] = "NULL";
						  }
						  $lid = self::$db->insert(self::fTable, array_merge($data, $data2));
						  $rows = Registry::get("Core")->getRowById(self::fTable, $lid);
						  $htmldata['html' . Lang::$lang] = Filter::clean($this->_renderRadio($rows));
						  self::$db->update(self::fTable, $htmldata, "id=" . $lid);
						  $msg = Lang::$word->_MOD_VF_FADDED;
						  $json['option'] = '<option value="' . $lid . '">' . $data['title' . Lang::$lang] . '</option>';
					  }
				  
					  $json['type'] = 'success';
					  $json['message'] = Filter::msgOk($msg, false);
					  print json_encode($json);
					  break;

                  case "check":
					  $data2 = array(
						  'type' => "check",
						  'required' => sanitize($_POST['required']),
						  'other' => sanitize($_POST['other'])
						  );

						  if (isset($_POST['defval'])) {
							  if (is_array($_POST['defval'])) {
								  $data['defval'] = self::_implodeFields($_POST['defval']);
							  }
						  } else {
							  $data['defval'] = "NULL";
						  }
					  if (Filter::$id) {
						  self::$db->update(self::fTable, array_merge($data, $data2), "id=" . Filter::$id);
						  $rows = Registry::get("Core")->getRowById(self::fTable, Filter::$id);
						  $htmldata['html' . Lang::$lang] = Filter::clean($this->_renderCheckbox($rows));
						  if (isset($_POST[$rows->name])) {
							  if (is_array($_POST[$rows->name])) {
								  $htmldata['attr'] = self::_implodeFields($_POST[$rows->name]);
							  }
						  } else {
							  $htmldata['attr'] = "NULL";
						  }
						  self::$db->update(self::fTable, $htmldata, "id=" . Filter::$id);
						  $msg = Lang::$word->_MOD_VF_FUPDATED;
					  } else {
						  $data2['name'] = self::randName('check');
						  if (isset($_POST['check'])) {
							  if (is_array($_POST['check'])) {
								  $data['attr'] = self::_implodeFields($_POST['check']);
							  }
						  } else {
							  $data['attr'] = "NULL";
						  }
						  $lid = self::$db->insert(self::fTable, array_merge($data, $data2));
						  $rows = Registry::get("Core")->getRowById(self::fTable, $lid);
						  $htmldata['html' . Lang::$lang] = Filter::clean($this->_renderCheckbox($rows));
						  self::$db->update(self::fTable, $htmldata, "id=" . $lid);
						  $msg = Lang::$word->_MOD_VF_FADDED;
						  $json['option'] = '<option value="' . $lid . '">' . $data['title' . Lang::$lang] . '</option>';
					  }
	
					  $json['type'] = 'success';
					  $json['message'] = Filter::msgOk($msg, false);
					  print json_encode($json);
					  break;

				  case "selbox":
					  $data2 = array(
						  'type' => "selbox",
						  'other' => isset($_POST['other']) ? "countrylist" : "NULL",
						  'multiple' => isset($_POST['multiple']) ? intval($_POST['multiple']) : 0
						  );
	
					  if (isset($_POST['defval'])) {
						  if (is_array($_POST['defval'])) {
							  $data['defval'] = self::_implodeFields($_POST['defval']);
						  }
					  } else {
						  $data['defval'] = "NULL";
					  }
					  if (Filter::$id) {
						  self::$db->update(self::fTable, array_merge($data, $data2), "id=" . Filter::$id);
						  $rows = Registry::get("Core")->getRowById(self::fTable, Filter::$id);
						  if (isset($_POST[$rows->name])) {
							  if (is_array($_POST['' . $rows->name])) {
								  $htmldata['attr'] = self::_implodeFields($_POST[$rows->name]);
							  }
						  } else {
							  $htmldata['attr'] = "NULL";
						  }

						  $htmldata['html' . Lang::$lang] = Filter::clean($this->_renderSelect($rows));
						  self::$db->update(self::fTable, $htmldata, "id=" . Filter::$id);
						  $msg = Lang::$word->_MOD_VF_FUPDATED;
					  } else {
						  $data2['name'] = self::randName('selbox');
						  if (isset($_POST['selbox'])) {
							  if (is_array($_POST['selbox'])) {
								  $data['attr'] = self::_implodeFields($_POST['selbox']);
							  }
						  } else {
							  $data['attr'] = "NULL";
						  }
						  $lid = self::$db->insert(self::fTable, array_merge($data, $data2));
						  $rows = Registry::get("Core")->getRowById(self::fTable, $lid);
						  $htmldata['html' . Lang::$lang] = Filter::clean($this->_renderSelect($rows));
						  self::$db->update(self::fTable, $htmldata, "id=" . $lid);
						  $msg = Lang::$word->_MOD_VF_FADDED;
						  $json['option'] = '<option value="' . $lid . '">' . $data['title' . Lang::$lang] . '</option>';
					  }
	
					  $json['type'] = 'success';
					  $json['message'] = Filter::msgOk($msg, false);
					  print json_encode($json);
					  break;

				  case "filefield":
					  $data2 = array(
						  'defval' => empty($_POST['defval']) ? 3 : intval($_POST['defval']),
						  'attr' => empty($_POST['attr']) ? 'zip,rar,jpg,png,pdf' : sanitize($_POST['attr']),
						  'required' => isset($_POST['required']) ? 1 : 0,
						  'type' => "filefield"
						  );
	
					  if (Filter::$id) {
						  self::$db->update(self::fTable, array_merge($data, $data2), "id=" . Filter::$id);
						  $rows = Registry::get("Core")->getRowById(self::fTable, Filter::$id);
						  $htmldata['html' . Lang::$lang] = Filter::clean($this->_renderFile($rows));
						  self::$db->update(self::fTable, $htmldata, "id='" . Filter::$id . "'");
						  $msg = Lang::$word->_MOD_VF_FUPDATED;
					  } else {
						  $data2['name'] = self::randName('filefield');
						  $lid = self::$db->insert(self::fTable, array_merge($data, $data2));
						  $rows = Registry::get("Core")->getRowById(self::fTable, $lid);
						  $htmldata['html' . Lang::$lang] = Filter::clean($this->_renderFile($rows));
						  self::$db->update(self::fTable, $htmldata, "id=" . $lid);
						  $msg = Lang::$word->_MOD_VF_FADDED;
						  $json['option'] = '<option value="' . $lid . '">' . $data['title' . Lang::$lang] . '</option>';
					  }
	
					  $json['type'] = 'success';
					  $json['message'] = Filter::msgOk($msg, false);
					  print json_encode($json);
					  break;
					  
				  case "datefield":
					  $data2 = array(
						  'defval' => empty($_POST['defval']) ? 'dddd, dd mmm, yyyy' : sanitize($_POST['defval']),
						  'required' => isset($_POST['required']) ? 1 : 0,
						  'type' => "datefield"
						  );
	
					  if (Filter::$id) {
						  self::$db->update(self::fTable, array_merge($data, $data2), "id=" . Filter::$id);
						  $rows = Registry::get("Core")->getRowById(self::fTable, Filter::$id);
						  $htmldata['html' . Lang::$lang] = Filter::clean($this->_renderDatepicker($rows));
						  self::$db->update(self::fTable, $htmldata, "id='" . Filter::$id . "'");
						  $msg = Lang::$word->_MOD_VF_FUPDATED;
					  } else {
						  $data2['name'] = self::randName('datefield');
						  $lid = self::$db->insert(self::fTable, array_merge($data, $data2));
						  $rows = Registry::get("Core")->getRowById(self::fTable, $lid);
						  $htmldata['html' . Lang::$lang] = Filter::clean($this->_renderDatepicker($rows));
						  self::$db->update(self::fTable, $htmldata, "id=" . $lid);
						  $msg = Lang::$word->_MOD_VF_FADDED;
						  $json['option'] = '<option value="' . $lid . '">' . $data['title' . Lang::$lang] . '</option>';
					  }
	
					  $json['type'] = 'success';
					  $json['message'] = Filter::msgOk($msg, false);
					  print json_encode($json);
					  break;
					  
				  case "colorfield":
					  $data2 = array(
						  'required' => isset($_POST['required']) ? 1 : 0,
						  'type' => "colorfield",
						  'attr' => sanitize($_POST['attr'])
						  );
	
					  if (Filter::$id) {
						  self::$db->update(self::fTable, array_merge($data, $data2), "id=" . Filter::$id);
						  $rows = Registry::get("Core")->getRowById(self::fTable, Filter::$id);
						  $htmldata['html' . Lang::$lang] = Filter::clean($this->_renderColor($rows));
						  self::$db->update(self::fTable, $htmldata, "id=" . Filter::$id);
						  $msg = Lang::$word->_MOD_VF_FUPDATED;
					  } else {
						  $data2['name'] = self::randName('colorfield');
						  $lid = self::$db->insert(self::fTable, array_merge($data, $data2));
						  $rows = Registry::get("Core")->getRowById(self::fTable, $lid);
						  $htmldata['html' . Lang::$lang] = Filter::clean($this->_renderColor($rows));
						  self::$db->update(self::fTable, $htmldata, "id=" . $lid);
						  $msg = Lang::$word->_MOD_VF_FADDED;
						  $json['option'] = '<option value="' . $lid . '">' . $data['title' . Lang::$lang] . '</option>';
					  }
	
					  $json['type'] = 'success';
					  $json['message'] = Filter::msgOk($msg, false);
					  print json_encode($json);
					  break;

				  case "imgfield":
					  $data2 = array(
						  'defval' => (empty($_POST['thumb_w']) or empty($_POST['thumb_h'])) ? '100::75' : intval($_POST['thumb_w']) . '::' . intval($_POST['thumb_h']),
						  'type' => "imgfield",
						  'attr' => sanitize($_POST['attr']),
						  );
	
					  if (Filter::$id) {
						  self::$db->update(self::fTable, array_merge($data, $data2), "id=" . Filter::$id);
						  $rows = Registry::get("Core")->getRowById(self::fTable, Filter::$id);
						  $htmldata['html' . Lang::$lang] = Filter::clean($this->_renderImage($rows));
						  self::$db->update(self::fTable, $htmldata, "id=" . Filter::$id);
						  $msg = Lang::$word->_MOD_VF_FUPDATED;
					  } else {
						  $data2['name'] = self::randName('imgfield');
						  $lid = self::$db->insert(self::fTable, array_merge($data, $data2));
						  $rows = Registry::get("Core")->getRowById(self::fTable, $lid);
						  $htmldata['html' . Lang::$lang] = Filter::clean($this->_renderImage($rows));
						  self::$db->update(self::fTable, $htmldata, "id=" . $lid);
						  $msg = Lang::$word->_MOD_VF_FADDED;
						  $json['option'] = '<option value="' . $lid . '">' . $data['title' . Lang::$lang] . '</option>';
					  }
	
					  $json['type'] = 'success';
					  $json['message'] = Filter::msgOk($msg, false);
					  print json_encode($json);
					  break;
					  
				  case "labelfield":
					  $data2 = array(
						  'type' => "labelfield",
						  'html' . Lang::$lang => Filter::clean('<div class="wk block header">' . sanitize($_POST['desc' . Lang::$lang]) . '</div>')
						  );
	
					  if (Filter::$id) {
						  self::$db->update(self::fTable, array_merge($data, $data2), "id=" . Filter::$id);
						  $msg = Lang::$word->_MOD_VF_FUPDATED;
					  } else {
						  $data2['name'] = self::randName('labelfield');
						  $lid = self::$db->insert(self::fTable, array_merge($data, $data2));
						  $msg = Lang::$word->_MOD_VF_FADDED;
						  $json['option'] = '<option value="' . $lid . '">' . $data['title' . Lang::$lang] . '</option>';
					  }
	
					  $json['type'] = 'success';
					  $json['message'] = Filter::msgOk($msg, false);
					  print json_encode($json);
					  break;

				  case "hr":
					  $data2 = array(
						  'type' => "hr",
						  'html' . Lang::$lang => Filter::clean('<div class="wk thin attached divider"></div>')
						  );
	
					  if (Filter::$id) {
						  self::$db->update(self::fTable, array_merge($data, $data2), "id=" . Filter::$id);
						  $msg = Lang::$word->_MOD_VF_FUPDATED;
					  } else {
						  $data2['name'] = self::randName('hr');
						  $lid = self::$db->insert(self::fTable, array_merge($data, $data2));
						  $msg = Lang::$word->_MOD_VF_FADDED;
						  $json['option'] = '<option value="' . $lid . '">' . $data['title' . Lang::$lang] . '</option>';
					  }
	
					  $json['type'] = 'success';
					  $json['message'] = Filter::msgOk($msg, false);
					  print json_encode($json);
					  break;
					    
				  case "parafield":
					  $data2 = array(
						  'type' => "parafield",
						  'attr' => $_POST['attr'],
						  'html' . Lang::$lang => Filter::clean('<div class="wk divider"></div>' . $_POST['attr'] . '<div class="wk divider"></div>')
						  );
	
					  if (Filter::$id) {
						  self::$db->update(self::fTable, array_merge($data, $data2), "id=" . Filter::$id);
						  $msg = Lang::$word->_MOD_VF_FUPDATED;
					  } else {
						  $data2['name'] = self::randName('parafield');
						  $lid = self::$db->insert(self::fTable, array_merge($data, $data2));
						  $msg = Lang::$word->_MOD_VF_FADDED;
						  $json['option'] = '<option value="' . $lid . '">' . $data['title' . Lang::$lang] . '</option>';
					  }
	
					  $json['type'] = 'success';
					  $json['message'] = Filter::msgOk($msg, false);
					  print json_encode($json);
					  break;
					  
				  case "area":
					  $data2 = array(
						  'defval' => empty($_POST['defval']) ? 'NULL' : intval($_POST['defval']),
						  'required' => isset($_POST['required']) ? 1 : 0,
						  'type' => "area"
						  );
	
					  if (Filter::$id) {
						  self::$db->update(self::fTable, array_merge($data, $data2), "id=" . Filter::$id);
						  $rows = Registry::get("Core")->getRowById(self::fTable, Filter::$id);
						  $htmldata['html' . Lang::$lang] = Filter::clean($this->_renderArea($rows));
						  self::$db->update(self::fTable, $htmldata, "id=" . Filter::$id);
						  $msg = Lang::$word->_MOD_VF_FUPDATED;
					  } else {
						  $data2['name'] = self::randName('area');
						  $lid = self::$db->insert(self::fTable, array_merge($data, $data2));
						  $rows = Registry::get("Core")->getRowById(self::fTable, $lid);
						  $htmldata['html' . Lang::$lang] = Filter::clean($this->_renderArea($rows));
						  self::$db->update(self::fTable, $htmldata, "id=" . $lid);
						  $msg = Lang::$word->_MOD_VF_FADDED;
						  $json['option'] = '<option value="' . $lid . '">' . $data['title' . Lang::$lang] . '</option>';
					  }
	
					  $json['type'] = 'success';
					  $json['message'] = Filter::msgOk($msg, false);
					  print json_encode($json);
					  break;
					  
                  case "field":
					  $data2 = array(
						  'defval' => empty($_POST['defval']) ? 'NULL' : sanitize($_POST['defval']),
						  'required' => isset($_POST['required']) ? 1 : 0,
						  'type' => "field"
						  );
	
					  if (Filter::$id) {
						  self::$db->update(self::fTable, array_merge($data, $data2), "id=" . Filter::$id);
						  $rows = Registry::get("Core")->getRowById(self::fTable, Filter::$id);
						  $htmldata['html' . Lang::$lang] = Filter::clean($this->_renderText($rows));
						  self::$db->update(self::fTable, $htmldata, "id=" . Filter::$id);
						  $msg = Lang::$word->_MOD_VF_FUPDATED;
					  } else {
						  $data2['name'] = self::randName('text');
						  $lid = self::$db->insert(self::fTable, array_merge($data, $data2));
						  $rows = Registry::get("Core")->getRowById(self::fTable, $lid);
						  $htmldata['html' . Lang::$lang] = Filter::clean($this->_renderText($rows));
						  self::$db->update(self::fTable, $htmldata, "id=" . $lid);
						  $msg = Lang::$word->_MOD_VF_FADDED;
						  $json['option'] = '<option value="' . $lid . '">' . $data['title' . Lang::$lang] . '</option>';
					  }
	
					  $json['type'] = 'success';
					  $json['message'] = Filter::msgOk($msg, false);
					  print json_encode($json);
					  break;
              }
			  if (!Filter::$id) {
				  if ($langdata = self::$db->fetch_all("SELECT * FROM " . Content::lgTable . " WHERE flag !='" . Core::$language . "'")) {
						foreach ($langdata as $lang) {
							$ldata['title_' . $lang->flag] = sanitize($_POST['title' . Lang::$lang]);
							self::$db->update(self::fTable, $ldata, "id=" . $lid);
						} 
				  }
			  }

		  } else {
			  $json['type'] = 'error';
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
      }

      /**
       * Forms::_renderRadio()
       * 
	   * @param array $row
       * @return
       */
      private function _renderRadio($row)
      {
          $html = '';
          if (is_object($row)) {
			  $html .= '<label class="label">' . "\n";
			  $html .= cleanSanitize($row->{'desc' . Lang::$lang});
			  if($row->required)
				  $html .= '<i class="icon asterisk"></i>' . "\n";
			  $html .= '</label>' . "\n";
			  $html .= '<div class="' . $row->other . '-group">' . "\n";
			  $radiodata = explode("::", $row->attr);
			  if (count($radiodata) > 1) {
				  reset($radiodata);
				  foreach ($radiodata as $i => $rdata) {
					  $k = $i + 1;
					  $sel = ($k == $row->defval) ? ' checked = "checked"' : null;
					  $html .= '<label class="radio">';
					  $html .= '<input type="radio" value="' . $rdata . '" name="' . $row->name . '"' . $sel . ' />';
					  $html .= '<i></i>' . $rdata . '</label>';
				  }
				  unset($rdata);
			  }
              $html .= '</div>' . "\n";
			  if($row->{'tooltip' . Lang::$lang})
				  $html .= '<p class="note">' . cleanSanitize($row->{'desc' . Lang::$lang}) . ' <i class="icon help" data-content="' . $row->{'tooltip' . Lang::$lang} . '"></i></p>' . "\n";
          }
          return $html;
      }

      /**
       * Forms::_renderCheckbox()
       * 
	   * @param array $row
       * @return
       */
      private function _renderCheckbox($row)
      {
          $html = '';
          if (is_object($row)) {
			  $html .= '<label class="label">' . "\n";
			  $html .= cleanSanitize($row->{'desc' . Lang::$lang});
			  if($row->required)
				  $html .= '<i class="icon asterisk"></i>' . "\n";
			  $html .= '</label>' . "\n";
			  $html .= '<div class="' . $row->other . '-group">' . "\n";
			  $checkdata = explode("::", $row->attr);
			  $selarr = explode('::', $row->defval);
			  if (count($checkdata) >= 1) {
				  reset($checkdata);
				  foreach ($checkdata as $i => $cdata) {
					  $k = $i + 1;
					  $sel = (in_array($k, $selarr)) ? ' checked = "checked"' : null;
					  $html .= '<label class="checkbox">';
					  $html .= '<input type="checkbox" value="' . $cdata . '" name="' . $row->name . '[]"' . $sel . ' />';
					  $html .= '<i></i>' . $cdata . '</label>';
				  }
				  unset($rdata);
			  }
              $html .= '</div>' . "\n";
			  if($row->{'tooltip' . Lang::$lang})
				  $html .= '<p class="note">' . cleanSanitize($row->{'desc' . Lang::$lang}) . ' <i class="icon help" data-content="' . $row->{'tooltip' . Lang::$lang} . '"></i></p>' . "\n";
          }
          return $html;
      }

      /**
       * Forms::_renderSelect()
       * 
	   * @param array $row
       * @return
       */
	  private function _renderSelect($row)
	  {
		  $html = '';
		  if (is_object($row)) {
			  $html .= '<label class="label">' . "\n";
			  $html .= cleanSanitize($row->{'desc' . Lang::$lang});
			  if($row->required)
				  $html .= '<i class="icon asterisk"></i>' . "\n";
			  $html .= '</label>' . "\n";
			  $seldata = explode("::", $row->attr);
			  $selarr = explode('::', $row->defval);
			  $multiple = $row->multiple ? ' multiple="multiple" data-placeholder="' . Lang::$word->_SELECTMULTI . '"' : null;
			  $html .= '<select name="' . $row->name . '[]"' . $multiple . ' class="selectbox">' . "\n";
			  
			  if ($row->other == "countrylist") {
				  $html .= '<option value="0">' . Lang::$word->_COUNTRY . ' </option>';
				  foreach (Registry::get("Content")->getCountryList() as $country)
					  $html .= '<option value="' . $country->name . '">' . $country->name . '</option>';
				  unset($country);
			  } else {
				  if (count($seldata) > 1) {
					  reset($seldata);
					  foreach ($seldata as $i => $sdata) {
						  $k = $i + 1;
						  $sel = (in_array($k, $selarr)) ? ' selected = "selected"' : null;
						  $html .= '<option value="' . $sdata . '"' . $sel . '>' . $sdata . '</option>';
					  }
					  unset($rdata);
				  }
			  }

			  $html .= '</select>' . "\n";
			  if($row->{'tooltip' . Lang::$lang})
				  $html .= '<p class="note">' . cleanSanitize($row->{'desc' . Lang::$lang}) . ' <i class="icon help" data-content="' . $row->{'tooltip' . Lang::$lang} . '"></i></p>' . "\n";
		  }
		  return $html;
	  }

      /**
       * Forms::_renderDatepicker()
       * 
	   * @param array $row
       * @return
       */
      private function _renderDatepicker($row)
      {
          $html = '';
          if (is_object($row)) {
			  $html .= '<label class="label">' . "\n";
			  $html .= cleanSanitize($row->{'desc' . Lang::$lang});
			  $html .= '</label>' . "\n";
			  $html .= '<label class="input">' . "\n";
			  if($row->required)
				  $html .= '<i class="icon-append icon asterisk"></i>' . "\n";
			  $html .= '<i class="icon-prepend icon calendar"></i>' . "\n";
              $html .= '<input name="' . $row->name . '" type="text" placeholder="' . cleanSanitize($row->{'desc' . Lang::$lang}) . '" onclick="$(this).pickadate({format: \'' . $row->defval . '\'}).pickadate(\'show\');"/>' . "\n";
			  $html .= '</label>' . "\n";
			  if($row->{'tooltip' . Lang::$lang})
				  $html .= '<p class="note">' . cleanSanitize($row->{'desc' . Lang::$lang}) . ' <i class="icon help" data-content="' . $row->{'tooltip' . Lang::$lang} . '"></i></p>' . "\n";
          }
          return $html;
      }

      /**
       * Forms::_renderColor()
       * 
	   * @param array $row
       * @return
       */
      private function _renderColor($row)
      {
          $html = '';
          if (is_object($row)) {
			  $html .= '<label class="label">' . "\n";
			  $html .= cleanSanitize($row->{'desc' . Lang::$lang});
			  $html .= '</label>' . "\n";
			  $html .= '<label class="input">' . "\n";
			  if($row->required)
				  $html .= '<i class="icon-append icon asterisk"></i>' . "\n";
			  $html .= '<i class="icon-prepend adjust icon"></i>' . "\n";
			  $coldata = explode(",", $row->attr);
			  $colors = '';
			  if (count($coldata) > 1) {
				  $res = '';
				  foreach($coldata as $crow) {
					  if(strlen($res) > 0) {
						  $res .= ",";
					  }
					  $res .= "'" . $crow . "'";
				  }
				  $colors = '{swatches:[' . $res . ']}';  
			  }
              $html .= '<input name="' . $row->name . '" type="text" data-color-format="hex" class="colorpicker" onclick="$(this).ColorPickerSliders(' . $colors . ').trigger(\'colorpickersliders.showPopup\');"/>' . "\n";
			  $html .= '</label>' . "\n";
			  if($row->{'tooltip' . Lang::$lang})
				  $html .= '<p class="note">' . cleanSanitize($row->{'desc' . Lang::$lang}) . ' <i class="icon help" data-content="' . $row->{'tooltip' . Lang::$lang} . '"></i></p>' . "\n";
          }
          return $html;
      } 

      /**
       * Forms::_renderFile()
       * 
	   * @param array $row
       * @return
       */
      private function _renderFile($row)
      {
          $html = '';
          if (is_object($row)) {
			  $html .= '<label class="label">' . "\n";
			  $html .= cleanSanitize($row->{'desc' . Lang::$lang});
			  $html .= '</label>' . "\n";
			  $html .= '<label class="input">' . "\n";
			  if($row->required)
				  $html .= '<i class="icon-prepend icon asterisk"></i>' . "\n";
              $html .= '<input name="' . $row->name . '" type="file" class="filefield">' . "\n";
			  $html .= '</label>' . "\n";
			  if($row->{'tooltip' . Lang::$lang})
				  $html .= '<p class="note">' . cleanSanitize($row->{'desc' . Lang::$lang}) . ' <i class="icon help" data-content="' . $row->{'tooltip' . Lang::$lang} . '"></i></p>' . "\n";
          }
          return $html;
      }

      /**
       * Forms::_renderImage()
       * 
	   * @param array $row
       * @return
       */
      private function _renderImage($row)
      {
          $html = '';
          if (is_object($row)) {
			  $html .= '<label class="label">' . "\n";
			  $html .= cleanSanitize($row->{'desc' . Lang::$lang});
			  $html .= '</label>' . "\n";
			  list($thumb_w, $thumb_h) = explode("::", $row->defval);
              $html .= '<a href="' . UPLOADURL . $row->attr . '" class="lightbox" title="' . $row->{'desc' . Lang::$lang} . '">'
			           . '<img src="' . SITEURL . '/thumbmaker.php?src=' . UPLOADURL . $row->attr . '&amp;h=' . $thumb_h . '&amp;w=' . $thumb_w . '" alt="" /></a>' . "\n";
			  if($row->{'tooltip' . Lang::$lang})
				  $html .= '<p class="note">' . cleanSanitize($row->{'desc' . Lang::$lang}) . ' <i class="icon help" data-content="' . $row->{'tooltip' . Lang::$lang} . '"></i></p>' . "\n";
          }
          return $html;
      }

      /**
       * Forms::_renderText()
       * 
	   * @param array $row
       * @return
       */
      private function _renderText($row)
      {
          $html = '';
          if (is_object($row)) {
			  $html .= '<label class="label">' . "\n";
			  $html .= cleanSanitize($row->{'desc' . Lang::$lang});
			  $html .= '</label>' . "\n";
			  $html .= '<label class="input">' . "\n";
			  if($row->required)
				  $html .= '<i class="icon-append icon asterisk"></i>' . "\n";
              $html .= '<input name="' . $row->name . '" type="text" placeholder="' . cleanSanitize($row->{'desc' . Lang::$lang}) . '">' . "\n";
			  $html .= '</label>' . "\n";
			  if($row->{'tooltip' . Lang::$lang})
				  $html .= '<p class="note">' . cleanSanitize($row->{'desc' . Lang::$lang}) . ' <i class="icon help" data-content="' . $row->{'tooltip' . Lang::$lang} . '"></i></p>' . "\n";
          }
          return $html;
      }

      /**
       * Forms::_renderTextarea()
       * 
	   * @param array $row
       * @return
       */
      private function _renderArea($row)
      {
          $html = '';
          if (is_object($row)) {
			  $html .= '<label class="label">' . "\n";
			  $html .= cleanSanitize($row->{'desc' . Lang::$lang});
			  $html .= '</label>' . "\n";
			  $html .= '<label class="textarea">' . "\n";
			  if($row->required)
				  $html .= '<i class="icon-append icon asterisk"></i>' . "\n";
              $html .= '<textarea name="' . $row->name . '" placeholder="' . cleanSanitize($row->{'desc' . Lang::$lang}) . '"></textarea>' . "\n";
			  $html .= '</label>' . "\n";
			  if($row->{'tooltip' . Lang::$lang})
				  $html .= '<p class="note">' . cleanSanitize($row->{'desc' . Lang::$lang}) . ' <i class="icon help" data-content="' . $row->{'tooltip' . Lang::$lang} . '"></i></p>' . "\n";
          }
          return $html;
      }

      /**
       * Forms::_renderLabel()
       * 
	   * @param array $row
       * @return
       */
      private function _renderLabel($row)
      {
          $html = '';
          if (is_object($row)) {
			  $html .= '<h2>' . "\n";
			  $html .= cleanSanitize($row->{'desc' . Lang::$lang});
			  $html .= '</h2>' . "\n";
          }
          return $html;
      }

      /**
       * Forms::_renderParagraph()
       * 
	   * @param array $row
       * @return
       */
      private function _renderParagraph($row)
      {
          $html = '';
          if (is_object($row)) {
			  $html .= '<div class="wk divider"></div>' . "\n";
			  $html .= cleanOut($row->{'desc' . Lang::$lang});
			  $html .= '<div class="wk divider"></div>' . "\n";
          }
          return $html;
      }

      /**
       * Forms::_renderHr()
       * 
	   * @param array $row
       * @return
       */
      private function _renderHr($row)
      {
          $html = '';
          if (is_object($row)) {
			  $html .= '<div class="wk divider"> </div>';
          }
          return $html;
      }


      /**
       * Forms::fieldTypes()
       * 
       * @return
       */
      public static function fieldTypes()
      {

          $arr = array(
		          'field' => Lang::$word->_MOD_VF_FIELD, 
		          'area' => Lang::$word->_MOD_VF_AREA, 
		          'radio' => Lang::$word->_MOD_VF_RADIO, 
		          'check' => Lang::$word->_MOD_VF_CHECK, 
		          'selbox' => Lang::$word->_MOD_VF_SELBOX, 
		          'datefield' => Lang::$word->_MOD_VF_DATEFIELD, 
		          'colorfield' => Lang::$word->_MOD_VF_COLORFIELD,
				  'filefield' => Lang::$word->_MOD_VF_FILEFIELD,
				  'imgfield' => Lang::$word->_MOD_VF_IMGFIELD,
				  'labelfield' => Lang::$word->_MOD_VF_LABELFIELD,
				  'parafield' => Lang::$word->_MOD_VF_PARAFIELD,
				  'hr' => Lang::$word->_MOD_VF_HRFIELD,
          );

          $html = '';
		  $html .= "<option value=\"\">" . Lang::$word->_MOD_VF_CFIELD_S . "</option>\n";
          foreach ($arr as $key => $val) {
              $html .= "<option value=\"$key\">$val</option>\n";
          }
          unset($val);
          return $html;
	  }

	  /**
	   * Forms::_implodeFields()
	   * 
	   * @param mixed $array
	   * @return
	   */
	  private static function _implodeFields($array, $sep = '::')
	  {
          if (is_array($array)) {
			  $result = array();
			  foreach ($array as $row) {
				  if ($row != '') {
					  array_push($result, sanitize($row));
				  }
			  }
			  return implode($sep, $result);
          }
		  return false;
	  }
	       
      /**
       * Forms::randName()
       * 
	   * @param array $type
       * @return
       */
      private static function randName($type)
      {
		  $code = '';
		  for($x = 0; $x<2; $x++) {
			  $code .= '_'.substr(sha1(rand(0,999999999999999)),2,6);
		  }
		  $code = substr($code,1);
		  return $type . $code;
		  
	  }
  }
?>