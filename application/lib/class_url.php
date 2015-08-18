<?php
  /**
   * Class Url
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */

  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  final class Url
  {
      public static $data = array();


      /**
       * Url::__construct()
       * 
       * @return
       */
      public function __construct()
      {
          self::$data = array(
               //Module directories. Only change Keys (Left Side)
              "moddir" => array(
                  "digishop" => "digishop",
                  "blog" => "blog",
                  "portfolio" => "portfolio",
				  "booking" => "booking",
                  "psdrive" => "psdrive",
                  "forum" => "forum"
				  ),

               //Pages
              "pagedata" => array(
				  "page" => "page" // <- Change here
				  ),

               //Module. Only change Values (Right Side)
              "module" => array(
                  //Digishop
                  "digishop" => "digishop",
                  "digishop-cat" => "category",
                  "digishop-checkout" => "checkout",

                  //Blog
                  "blog" => "blog",
                  "blog-cat" => "category",
                  "blog-search" => "search",
                  "blog-archive" => "archive",
                  "blog-author" => "author",
                  "blog-tag" => "tag",

                  //Portfolio
                  "portfolio" => "portfolio",
                  "portfolio-cat" => "category",

                  //Booking
                  "booking" => "booking",
				  
                  //Forum
                  "forum" => "forum",
                  "forum-topic" => "topic",
                  "forum-user" => "user",

                  //PS Drive
                  "psdrive" => "psdrive",
                  "psdrive-cat" => "category",
                  "psdrive-share" => "share",
                  "psdrive-tag" => "tag",
                  "booking" => "booking"
				  )
          );

          return self::$data;

      }

      /**
       * Url::Page()
       * 
       * @return
       */
      public static function Page($slug, $pars = false)
      {
          $segment = self::$data['pagedata'];
		  
		  $url = SITEURL . '/' . $segment['page'] . '/' . $slug . '/' . $pars;
		  
		  return $url;

      }
	  
      /**
       * Url::Blog()
       * 
       * @return
       */
      public static function Blog($type, $slug = false, $pars = false)
      {
          $segment = self::$data['module'];
          switch ($type) {
              case 'blog':
                  $url = SITEURL . '/' . $segment['blog'] . '/' . $pars;
                  break;

              case 'blog-cat':
				  $url = SITEURL . '/' . $segment['blog'] . '/' . $segment['blog-cat'] . '/' . $slug . '/' . $pars;
                  break;

              case 'blog-search':
				  $url = SITEURL . '/' . $segment['blog'] . '/' . $segment['blog-search'] . '/' . $pars;
                  break;

              case 'blog-archive':
				  $url = SITEURL . '/' . $segment['blog'] . '/' . $segment['blog-archive'] . '/' . $pars;
                  break;

              case 'blog-author':
				  $url = SITEURL . '/' . $segment['blog'] . '/' . $segment['blog-author'] . '/' . $slug . '/' . $pars;
                  break;

              case 'blog-tags':
				  $url = SITEURL . '/' . $segment['blog'] . '/' . $segment['blog-tag'] . '/' . urlencode($slug) . '/' . $pars;
                  break;

              default:
				  $url = SITEURL . '/' . $segment['blog'] . '/' . $slug . '/' . $pars;
                  break;

          }
		  
		  return $url;

      }
	  
      /**
       * Url::Digishop()
       * 
       * @return
       */
      public static function Digishop($type, $slug = false, $pars = false)
      {
          $segment = self::$data['module'];
          switch ($type) {
              case 'digishop':
                  $url = SITEURL . '/' . $segment['digishop'] . '/' . $pars;
                  break;

              case 'digishop-cat':
				  $url = SITEURL . '/' . $segment['digishop'] . '/' . $segment['digishop-cat'] . '/' . $slug . '/' . $pars;
                  break;

              case 'digishop-checkout':
				  $url = SITEURL . '/' . $segment['digishop'] . '/' . $segment['digishop-checkout'] . '/' . $pars;
                  break;

              default:
				  $url = SITEURL . '/' . $segment['digishop'] . '/' . $slug . '/' . $pars;
                  break;

          }
		  
		  return $url;

      }
	  
      /**
       * Url::Portfolio()
       * 
       * @return
       */
      public static function Portfolio($type, $slug = false, $pars = false)
      {
          $segment = self::$data['module'];
          switch ($type) {
              case 'portfolio':
                  $url = SITEURL . '/' . $segment['portfolio'] . '/' . $pars;
                  break;

              case 'portfolio-cat':
				  $url = SITEURL . '/' . $segment['portfolio'] . '/' . $segment['portfolio-cat'] . '/' . $slug . '/' . $pars;
                  break;

              default:
				  $url = SITEURL . '/' . $segment['portfolio'] . '/' . $slug . '/' . $pars;
                  break;

          }
		  
		  return $url;

      }
	  
      /**
       * Url::Booking()
       * 
       * @return
       */
      public static function Booking($type, $slug = false, $pars = false)
      {
          $segment = self::$data['module'];
          switch ($type) {
              case 'booking':
                  $url = SITEURL . '/' . $segment['booking'] . '/' . $pars;
                  break;
				  
              default:
				  $url = SITEURL . '/' . $segment['booking'] . '/' . $slug . '/' . $pars;
                  break;

          }
		  
		  return $url;

      }
	  
	  
      /**
       * Url::Forum()
       * 
       * @return
       */
      public static function Forum($type, $slug = false, $pars = false)
      {
          $segment = self::$data['module'];
          switch ($type) {
              case 'forum':
                  $url = SITEURL . '/' . $segment['forum'] . '/' . $pars;
                  break;

              case 'forum-topic':
				  $url = SITEURL . '/' . $segment['forum'] . '/' . $segment['forum-topic'] . '/' . $slug . '/' . $pars;
                  break;

              case 'forum-user':
				  $url = SITEURL . '/' . $segment['forum'] . '/' . $segment['forum-user'] . '/' . $pars;
                  break;

              default:
				  $url = SITEURL . '/' . $segment['forum'] . '/' . $slug . '/' . $pars;
                  break;

          }
		  
		  return $url;

      }
	  
      /**
       * Url::Psdrive()
       * 
       * @return
       */
      public static function Psdrive($type, $slug = false, $pars = false)
      {
          $segment = self::$data['module'];
          switch ($type) {
              case 'psdrive':
                  $url = SITEURL . '/' . $segment['psdrive'] . '/' . $pars;
                  break;

              case 'psdrive-cat':
				  $url = SITEURL . '/' . $segment['psdrive'] . '/' . $segment['psdrive-cat'] . '/' . $slug . '/' . $pars;
                  break;

              case 'psdrive-search':
				  $url = SITEURL . '/' . $segment['psdrive'] . '/' . $segment['psdrive-search'] . '/' . $pars;
                  break;

              case 'psdrive-share':
				  $url = SITEURL . '/' . $segment['psdrive'] . '/' . $segment['psdrive-share'] . '/' . $pars;
                  break;
				  
              case 'psdrive-tags':
				  $url = SITEURL . '/' . $segment['psdrive'] . '/' . $segment['psdrive-tag'] . '/' . urlencode($slug) . '/' . $pars;
                  break;

              default:
				  $url = SITEURL . '/' . $segment['psdrive'] . '/' . $slug . '/' . $pars;
                  break;

          }
		  
		  return $url;

      }
  }