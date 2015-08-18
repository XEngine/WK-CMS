<?php
  /**
   * Index
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  define("_VALID_PHP", true);
  require_once ("init.php");

  $row = $content->renderPage(true);
  $plgresult = $content->getPluginLayoutFront();

  $widgettop = Content::countPlace($plgresult, "top");
  $widgetbottom = Content::countPlace($plgresult, "bottom");
  $widgetleft = Content::countPlace($plgresult, "left");
  $widgetright = Content::countPlace($plgresult, "right");
  $assets = Content::countPlace($plgresult, false, false);

  $totalleft = count($widgetleft);
  $totalright = count($widgetright);
  $totaltop = count($widgettop);
  $totalbot = count($widgetbottom);

  if ($row):
      $core->getVisitors(); // visitor counter
      require_once (THEMEDIR . "/index.tpl.php");
  else:
      redirect_to(SITEURL . "/404.php");
  endif;
?>