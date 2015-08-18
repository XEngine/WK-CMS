<?php

  /**
   * Geodata
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  define("_VALID_PHP", true);

  require_once ("../../init.php");

  function is_bot()
  {
      $botlist = array(
          "Teoma",
          "alexa",
          "froogle",
          "Gigabot",
          "inktomi",
          "looksmart",
          "URL_Spider_SQL",
          "Firefly",
          "NationalDirectory",
          "Ask Jeeves",
          "TECNOSEEK",
          "InfoSeek",
          "WebFindBot",
          "girafabot",
          "crawler",
          "www.galaxy.com",
          "Googlebot",
          "Scooter",
          "Slurp",
          "msnbot",
          "appie",
          "FAST",
          "WebBug",
          "Spade",
          "ZyBorg",
          "rabaz",
          "Baiduspider",
          "Feedfetcher-Google",
          "TechnoratiSnoop",
          "Rankivabot",
          "Mediapartners-Google",
          "Sogou web spider",
          "WebAlta Crawler",
          "TweetmemeBot",
          "Butterfly",
          "Twitturls",
          "Me.dium",
          "Twiceler");

      foreach ($botlist as $bot) {
          if (strpos($_SERVER['HTTP_USER_AGENT'], $bot) !== false)
              return true;
      }
      return false;
  }
  
  if (is_bot())
      die();
?>
<?php
  $sql = "SELECT *, COUNT(*) AS total FROM plug_online GROUP BY countrycode ORDER BY total DESC LIMIT 15";
  $result = $db->fetch_all($sql);
  print '<div class="wk divided list">';
  if ($result):
      foreach ($result as $row):
          print '<div class="item">
		  <div class="push-right">' . $row->total . '</div>
		    <div class="push-left"><img class="wk image" alt="" src="' . SITEURL . '/plugins/online/images/flags/' . strtolower($row->countrycode) . '.gif"></div>
			  <div class="content">' . $row->country . '</div>
		  </div>';
      endforeach;
  print '</div>';
  endif
?>