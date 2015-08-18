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

  function get_tag($tag, $xml)
  {
      preg_match_all('/<' . $tag . '>(.*)<\/' . $tag . '>$/imU', $xml, $match);
      return $match[1];
  }
?>
<?php
  if (is_bot())
      die();

  $stringIp = ($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
  $intIp = ip2long($stringIp);
  
  $inDB = $db->first("SELECT * FROM plug_online WHERE ip=" . $intIp);

  if (!$inDB) {
      if (isset($_COOKIE['CMSPRO_geoData'])) {
          list($city, $countryName, $countryAbbrev) = explode('|', sanitize($_COOKIE['CMSPRO_geoData']));
      } else {
          $xml = file_get_contents('http://api.hostip.info/?ip=' . $stringIp);

          $city = get_tag('gml:name', $xml);
          $city = $city[1];
          $countryName = get_tag('countryName', $xml);
          $countryName = $countryName[0];
          $countryAbbrev = get_tag('countryAbbrev', $xml);
          $countryAbbrev = $countryAbbrev[0];

          setcookie('CMSPRO_geoData', $city . '|' . $countryName . '|' . $countryAbbrev, time() + 60 * 60 * 24 * 30, '/');
      }

      $countryName = str_replace('(Unknown Country?)', 'UNKNOWN', $countryName);

      if (!$countryName) {
          $countryName = 'UNKNOWN';
          $countryAbbrev = 'XX';
          $city = '(Unknown City?)';
      }

      $data = array(
          'ip' => sanitize($intIp),
          'city' => sanitize($city),
          'country' => sanitize($countryName),
          'countrycode' => sanitize($countryAbbrev),
          );
      $db->insert("plug_online", $data);

  } else {
      $db->query("UPDATE plug_online SET created=NOW() WHERE ip=" . $intIp);
  }

  $db->query("DELETE FROM plug_online WHERE created < SUBTIME(NOW(),'0 0:10:0')");

  print $totalOnline = countEntries("plug_online");
?>