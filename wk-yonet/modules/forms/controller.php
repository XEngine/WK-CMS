<?php
  /**
   * Controller
   *
   * @package wk:cms
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */

  define("_VALID_PHP", true);

  require_once ("../../init.php");
  if (!$user->is_Admin())
      redirect_to("../../login.php");

  require_once ("admin_class.php");
  Registry::set('Forms', new Forms());
?>
<?php
  /* == Load Field List == */
  if (isset($_POST['loadFormFields'])):
      $availfields = Registry::get("Forms")->getAllFields();
      if ($availfields):
          print '<div id="allfields" class="wk two fluid items">';
          foreach ($availfields as $arow):
              print '<div class="item">';
              print '<a class="insertfield" data-id="' . $arow->id . '" data-name="' . $arow->{'title' . Lang::$lang} . '">' . $arow->{'title' . Lang::$lang} . '</a>';
              print '</div>';
          endforeach;
          print '</div>';
      endif;
  endif;

  /* == Save Forms Data == */
  if (isset($_POST['saveFormData'])):
      Registry::get("Forms")->saveFormData();
  endif;

  /* == Add Field == */
  if (isset($_POST['addField'])):
      $type = sanitize($_POST['type']);
	  $html = '';
	  $html .=  '
	  <div class="wk small block header">' . Lang::$word->_MOD_VF_CFIELD. ' <i class="icon double angle right"></i> ' . $type . '</div>
	  <div class="two fields">
		<div class="field">
		  <label>' . Lang::$word->_MOD_VF_EL_FLDTITLE . '</label>
		  <label class="input"> <i class="icon-append icon asterisk"></i>
			<input type="text" name="title' . Lang::$lang . '" placeholder="' . Lang::$word->_MOD_VF_EL_FLDTITLE . '">
		  </label>
		</div>
		<div class="field">
		  <label>' . Lang::$word->_MOD_VF_EL_FLDLABEL . '</label>
		  <label class="input"> <i class="icon-append icon asterisk"></i>
			<input type="text" name="desc' . Lang::$lang . '" placeholder="' . Lang::$word->_MOD_VF_EL_FLDLABEL . '">
		  </label>
		</div>
	  </div>';
	  if ($type != "labelfield" and $type != "parafield" and $type != "hr"):
	  $html .= '
	  <div class="wk small block header">' . Lang::$word->_MOD_VF_EL_OPTATTRIB . '</div>
	  <div class="two fields">
		<div class="field">
		  <label>' . Lang::$word->_MOD_VF_EL_ERRORMSG . '</label>
		  <label class="input">
			<input type="text" name="msgerror' . Lang::$lang . '" placeholder="' . Lang::$word->_MOD_VF_EL_ERRORMSG . '">
		  </label>
		</div>
		<div class="field">
		  <label>' . Lang::$word->_MOD_VF_EL_TOOLTIP . '</label>
		  <label class="input">
			<input type="text" name="tooltip' . Lang::$lang . '" placeholder="' . Lang::$word->_MOD_VF_EL_TOOLTIP . '">
		  </label>
		</div>
	  </div>';
	  endif;
	  $html .= Forms::addFormField($type);
	  $html .= '<div class="field">';
	  $html .= '<button class="wk positive button push-right" name="dofields" type="button">' . Lang::$word->_MOD_VF_ADD_FIELD . '</button>';
	  $html .= '</div>';
	  $html .= '<input name="processField" type="hidden" value="1">';
	  $html .= '<input name="type" type="hidden" value="' . $type . '">';
	  $json['data'] = $html;
	  print json_encode($json);
  endif;

  /* == Edit Field == */
  if (isset($_POST['editField'])):
      $row = Core::getRowById(Forms::fTable, Filter::$id);
	  $html = '';
	  $html .=  '
	  <div class="wk small block header">' . Lang::$word->_MOD_VF_EDIT_FIELD. ' <i class="icon double angle right"></i> ' . $row->{'title' . Lang::$lang}  . '</div>
	  <div class="two fields">
		<div class="field">
		  <label>' . Lang::$word->_MOD_VF_EL_FLDTITLE . '</label>
		  <label class="input"> <i class="icon-append icon asterisk"></i>
			<input type="text" name="title' . Lang::$lang . '" placeholder="' . $row->{'title' . Lang::$lang} . '" value="' . $row->{'title' . Lang::$lang} . '">
		  </label>
		</div>
		<div class="field">
		  <label>' . Lang::$word->_MOD_VF_EL_FLDLABEL . '</label>
		  <label class="input"> <i class="icon-append icon asterisk"></i>
			<input type="text" name="desc' . Lang::$lang . '" placeholder="' . $row->{'desc' . Lang::$lang} . '" value="' . $row->{'desc' . Lang::$lang} . '">
		  </label>
		</div>
	  </div>';
	  
	  if ($row->type != "labelfield" and $row->type != "parafield" and $row->type != "hr"):
	  $html .= '
	  <div class="wk small block header">' . Lang::$word->_MOD_VF_EL_OPTATTRIB . '</div>
	  <div class="two fields">
		<div class="field">
		  <label>' . Lang::$word->_MOD_VF_EL_ERRORMSG . '</label>
		  <label class="input">
			<input type="text" name="msgerror' . Lang::$lang . '" placeholder="' . $row->{'msgerror' . Lang::$lang} . '" value="' . $row->{'msgerror' . Lang::$lang} . '">
		  </label>
		</div>
		<div class="field">
		  <label>' . Lang::$word->_MOD_VF_EL_TOOLTIP . '</label>
		  <label class="input">
			<input type="text" name="tooltip' . Lang::$lang . '" placeholder="' . $row->{'tooltip' . Lang::$lang} . '" value="' . $row->{'tooltip' . Lang::$lang} . '">
		  </label>
		</div>
	  </div>';
	  endif;
	  $html .= Forms::loadFormField($row);
	  $html .= '<div class="field">';
	  $html .= '<button class="wk positive button push-right" name="dofields" type="button">' . Lang::$word->_MOD_VF_UPDATE_FIELD . '</button>';
	  $html .= '</div>';
	  $html .= '<input type="hidden" name="type" value="' . $row->type . '">';
	  $html .= '<input type="hidden" name="id" value="' . $row->id . '">';
	  $html .= '<input name="processField" type="hidden" value="1">';
	  $json['data'] = $html;
	  print json_encode($json);
  endif;

  /* == Process Form Field == */
  if (isset($_POST['processField'])):
	  Registry::get("Forms")->processField();
  endif;

  /* == Process Form == */
  if (isset($_POST['processForm'])):
	  Registry::get("Forms")->processForm();
  endif;

  /* == Delete Form == */
  if (isset($_POST['delete']) and $_POST['delete'] == "deleteForm"):
      $title = sanitize($_POST['title']);
      $result = $db->delete(Forms::mTable, "id=" . Filter::$id);

      if ($result):
          $json['type'] = 'success';
          $json['title'] = Lang::$word->_SUCCESS;
          $json['message'] = Lang::$word->_MOD_VF_FORM . ' /' . $title . '/ ' . Lang::$word->_DELETED;
          Security::writeLog(Lang::$word->_MOD_VF_FORM . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "module");
      else:
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
      endif;
      print json_encode($json);
  endif;
?>