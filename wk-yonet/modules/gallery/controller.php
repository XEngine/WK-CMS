<?php
  /**
   * Controller
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2010
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  define("_VALID_PHP", true);
  
  require_once("../../init.php");
  if (!$user->is_Admin())
      redirect_to("../../login.php");

  require_once("admin_class.php");
  Registry::set('Gallery', new Gallery());
?>
<?php
  /* == Update Configuration == */
  if (isset($_POST['processGallery'])):
	Registry::get("Gallery")->processGallery();
  endif;

  /* == Edit Gallery == */
  if (isset($_POST['quickedit'])):
          if (empty($_POST['title'])):
              print '-/-';
              exit;
          endif;
		  
		  $title = cleanOut($_POST['title']);
		  $title = strip_tags($title);
			  
          if($_POST['key'] == "title"):
		    $data['title'.Lang::$lang] = $title;
		    $db->update(Gallery::mTable, $data, "id = " . Filter::$id);
		  else:
		    $data['description'.Lang::$lang] = $title;
		    $db->update(Gallery::mTable, $data, "id = " . Filter::$id);
		  endif;
		  
	  print $title;
  endif;

  /* == Update Images Order == */
  if (isset($_GET['sortImages'])):
	  foreach ($_POST['list'] as $k => $v) :
		  $p = $k + 1;
		  $data['sorting'] = intval($p);
		  $db->update(Gallery::mTable, $data, "id=" . (int)$v);
	  endforeach;
  endif;
  
  /* == Upload Images == */
  if (isset($_POST['doFiles'])):
      Gallery::doUpload('mainfile');
  endif;

  /* == Delete Images == */
  if (isset($_POST['deleteImage'])):
      $title = sanitize($_POST['title']);
      if ($image = getValueById("thumb", Gallery::mTable, Filter::$id)):
          $path = BASEPATH . Gallery::galpath . sanitize($_POST['curDir']) . '/' . $image;
          unlink($path);
      endif;

      $result = $db->delete(Gallery::mTable, "id=" . Filter::$id);
      if ($result):
          $json['type'] = 'success';
          $json['title'] = Lang::$word->_SUCCESS;
          $json['message'] = Lang::$word->_IMAGE . ' /' . $title . '/ ' . Lang::$word->_DELETED;
          Security::writeLog(Lang::$word->_IMAGE . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "module");
      else:
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
      endif;
   print json_encode($json);
  endif;

  /* == Delete Gallery == */
  if (isset($_POST['delete'])):
      $title = sanitize($_POST['title']);
      $dirname = BASEPATH . Gallery::galpath . Registry::get("Gallery")->folder;

      if (!is_dir($dirname)):
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ERROR;
          $json['message'] = Lang::$word->_MOD_GA_DIRERROR;
		  print json_encode($json);
          exit;
      endif;

      delete_directory($dirname);
      $result = $db->delete(Gallery::cTable, "id=" . Filter::$id);
      $db->delete(Gallery::mTable, "gallery_id=" . Filter::$id);

      if ($result):
          $json['type'] = 'success';
          $json['title'] = Lang::$word->_SUCCESS;
          $json['message'] = Lang::$word->_GALLERY . ' /' . $title . '/ ' . Lang::$word->_DELETED;
          Security::writeLog(Lang::$word->_GALLERY . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "module");
      else:
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
      endif;
  print json_encode($json);
  endif;
?>