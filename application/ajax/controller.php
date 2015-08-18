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
  require_once("../init.php");

  if (!$user->logged_in)
      redirect_to("../index.php");
?>
<?php
  /* == Proccess Membership == */
  if (isset($_POST['addtocart'])):
  
      $row = Core::getRowById(Membership::mTable, Filter::$id);
      if ($row):
          $gaterows = Registry::get("Membership")->getGateways(true);

          if ($row->trial && $user->trialUsed()) :
              $json['message'] = Filter::msgSingleAlert(Lang::$word->_MS_TRIAL_USED, false);
              print json_encode($json);
              exit;
          endif;
          if ($row->price == 0) :
              $data = array(
                  'membership_id' => $row->id,
                  'mem_expire' => $user->calculateDays($row->id),
                  'trial_used' => ($row->trial == 1) ? 1 : 0
				  );

              $db->update(Users::uTable, $data, "id=" . $user->uid);
              $json['message'] = Filter::msgSingleOk(Lang::$word->_MS_MEM_ACTIVE_OK . ' ' . $row->{'title' . Lang::$lang}, false);
              Security::writeLog(Lang::$word->_MEMBERSHIP . ' ' . $row->{'title' . Lang::$lang} . Lang::$word->_LG_MEM_ACTIVATED . $user->username, "user", "no", "content");
              print json_encode($json);

          else :
              if ($gaterows):
                  $content = '<div class="content-center">';
				  //$content .= '<div class="wk buttons">';
                  foreach ($gaterows as $grows) :
                      $form_url = BASEPATH . "gateways/" . $grows->dir . "/form.tpl.php";
                      if ($row->price <> 0 && file_exists($form_url)) :
                          ob_start();
                          include ($form_url);
                          $content .= ob_get_contents();
                          ob_end_clean();
                      endif;
                  endforeach;
                  //$content .= '</div>';
				  $content .= '</div>';
                  $json['message'] = $content;
                  print json_encode($json);
              endif;
          endif;
		  
      else :
		  $json['message'] = Filter::msgSingleError(Lang::$word->_SYSERROR, false);
		  print json_encode($json);
		  exit;
      endif;

  endif;

 /* == Proccess User == */
  if (isset($_POST['doProfile'])):
      $user->updateProfile();
  endif;
?>