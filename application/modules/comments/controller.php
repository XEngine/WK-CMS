<?php
  /**
   * processComment
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  define("_VALID_PHP", true);
  require_once("../../init.php");
  
  require_once(MODPATH . "comments/admin_class.php");
  Registry::set('Comments', new Comments());
?>
<?php
  $post = (!empty($_POST)) ? true : false;

  if ($post) {

      if (empty($_POST['username']) and Registry::get("Comments")->username_req)
          Filter::$msgs['username'] = Lang::$word->_MOD_CM_E_NAME;

      if (Registry::get("Comments")->show_captcha) {
          Filter::checkPost('captcha', Lang::$word->_MOD_CM_E_CAPTCHA);

          if ($_SESSION['captchacode'] != $_POST['captcha'])
              Filter::$msgs['captcha'] = Lang::$word->_MOD_CM_E_CAPTCHA2;
      }

      if (empty($_POST['email']) and Registry::get("Comments")->email_req)
          Filter::$msgs['email'] = Lang::$word->_MOD_CM_E_EMAIL;

      if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $_POST['email']))
          Filter::$msgs['email'] = Lang::$word->_MOD_CM_E_EMAIL2;

      if (isset($_POST['www']) and !empty($_POST['www'])) {
          if (!preg_match("#^http://*#", $_POST["www"]))
              Filter::$msgs['www'] = Lang::$word->_MOD_CM_E_WWW;
      }

      Filter::checkPost('body', Lang::$word->_MOD_CM_E_COMMENT);

      if (empty(Filter::$msgs)) {

          $text = cleanOut($_POST['body']);
          $string = Comments::keepTags($text, '<strong><em><i><b><br><p><pre><code>', '');
          $filtered = (Registry::get("Comments")->blacklist_words) ? Registry::get("Comments")->censored($string) : $string;

          $data = array(
              'parent_id' => (isset($_POST['parent_id'])) ? intval($_POST['parent_id']) : 0,
              'page_id' => intval($_POST['page_id']),
              'user_id' => intval($user->uid),
              'username' => sanitize($_POST['username']),
              'email' => sanitize($_POST['email']),
              'body' => $filtered,
              'www' => sanitize($_POST['www']),
              'created' => "NOW()",
              'ip' => sanitize($_SERVER['REMOTE_ADDR']),
              'active' => (Registry::get("Comments")->auto_approve) ? 1 : 0);
          $page = getValuesById("slug, title" . Lang::$lang, Content::pTable, $data['page_id']);

          $db->insert(Comments::mTable, $data);

          $adata = array(
              'uid' => $user->uid,
              'url' => "page/" . $page->slug . "/",
              'icon' => "chat",
              'type' => "comment",
              'title' => $page->{'title' . Lang::$lang},
              'subject' => Lang::$word->_PPF_COM_P,
              'message' => $filtered,
              'created' => "NOW()"
			  );
			  
          $db->insert(Users::uaTable, $adata);
 
          if (Registry::get("Comments")->notify_new) {
              $sender_email = $data['email'];
              $username = $data['username'];
              $message = $filtered;
              $www = $data['www'];
              $ip = sanitize($_SERVER['REMOTE_ADDR']);

              require_once (BASEPATH . "lib/class_mailer.php");
              $mailer = Mailer::sendMail();

              $row = Core::getRowById(Content::eTable, 11);

              $body = str_replace(array(
                  '[MESSAGE]',
                  '[SENDER]',
                  '[NAME]',
                  '[WWW]',
                  '[PAGEURL]',
                  '[IP]'), array(
                  $message,
                  $sender_email,
                  $username,
                  $www,
                  Url::Page($page->slug),
                  $ip), $row->{'body' . Lang::$lang});

              $message = Swift_Message::newInstance()
						->setSubject($row->{'subject' . Lang::$lang})
						->setTo(array($core->site_email => $core->site_name))
						->setFrom(array($sender_email => $username))
						->setBody(cleanOut($body), 'text/html');

              $mailer->send($message);
          }

          $result = (Registry::get("Comments")->auto_approve) ? Lang::$word->_MOD_CM_MSGOK1 : Lang::$word->_MOD_CM_MSGOK2;

          if ($db->affected()) {
              Security::writeLog(Lang::$word->_USER . ' ' . $user->username . ' ' . Lang::$word->_LG_COMMENT_SENT, "", "no", "user");
              $json['status'] = 'success';
              $json['message'] = Filter::msgOk($result, false);
          } else {
              $json['status'] = 'alert';
              $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
          }
          print json_encode($json);


      } else {
          $json['message'] = Filter::msgStatus();
          print json_encode($json);
      }
  }
?>