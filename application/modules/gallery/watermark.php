<?php
  /**
   * Watermark
   *
   * @package Webkokteyli CMS
   * @author wkcms.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  define("_VALID_PHP", true);
  
  require_once ("../../init.php");
  require_once (MODPATH . "gallery/admin_class.php");
  Registry::set('Gallery', new Gallery());

  $img = sanitize($_GET['image']);
  $folder = sanitize($_GET['folder']);

  $imagesource = BASEPATH . Gallery::galpath . $folder . '/' . $img;

  if (!file_exists($imagesource))
      die();
  $filetype = substr($imagesource, strlen($imagesource) - 4, 4);
  if ($filetype == ".gif")
      $image = @imagecreatefromgif($imagesource);
  if ($filetype == ".jpg")
      $image = @imagecreatefromjpeg($imagesource);
  if ($filetype == ".png")
      $image = @imagecreatefrompng($imagesource);
  if (empty($image))
      die();
  $watermark = @imagecreatefrompng(UPLOADS . 'watermark.png');
  $imagewidth = imagesx($image);
  $imageheight = imagesy($image);
  $watermarkwidth = imagesx($watermark);
  $watermarkheight = imagesy($watermark);

  /* For centerd watermark */
  $startwidth = (($imagewidth - $watermarkwidth) / 2);
  $startheight = (($imageheight - $watermarkheight) / 2);

  /* Bottom Right Corner  */
  //$startwidth = (($imagewidth - $watermarkwidth));
  //$startheight = (($imageheight - $watermarkheight));

  imagecopy($image, $watermark, $startwidth, $startheight, 0, 0, $watermarkwidth, $watermarkheight);
  header("Content-type: image/jpeg");
  header('Content-Disposition: inline; filename=' . $imagesource);
  imagejpeg($image);
  imagedestroy($image);
  imagedestroy($watermark);

?>