<?php
  /**
   * Rss Parser
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  require_once('autoloader.php');

  require_once(PLUGPATH . "rss/admin_class.php");
  Registry::set('Rss',new Rss());

  $feed = new SimplePie();
  $feed->set_feed_url(Registry::get("Rss")->url);
  $feed->init();
  $feed->handle_content_type();
?>
<!-- Start Rss Parser -->
<h4><a href="<?php echo $feed->get_permalink(); ?>"><?php echo $feed->get_title();?></a></h4>
<p><?php echo $feed->get_description(); ?></p>
<div class="wk divided list">
  <?php
	$i = 0;
	foreach ($feed->get_items() as $item) :
		$i++;
		$title = $item->get_title();
		$url = $item->get_permalink();
		$pubdate = strftime(Registry::get("Rss")->dateformat, strtotime($item->get_date('Y-m-d H:i:s')));
		$summary = $item->get_description();
		$summary = (Registry::get("Rss")->body_trim <> 0) ? sanitize($summary,Registry::get("Rss")->body_trim) : $summary;
  ?>
  <div class="item"> <i class="rss icon"></i>
    <div class="content"> <a class="header" href="<?php echo $url;?>"><?php echo $title;?>
      <?php if(Registry::get("Rss")->show_date):?>
      <small><?php echo $pubdate;?></small>
      <?php endif;?>
      </a>
      <?php if(Registry::get("Rss")->show_body):?>
      <div class="description"><?php echo $summary;?></div>
      <?php endif;?>
    </div>
  </div>
  <?php if ($i >= Registry::get("Rss")->perpage) break;?>
  <?php endforeach;?>
</div>
<!-- End Rss Parser /-->