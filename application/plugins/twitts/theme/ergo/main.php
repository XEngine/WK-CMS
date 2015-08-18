<?php
  /**
   * Latest Twitts
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  require_once(PLUGPATH . "twitts/admin_class.php");
  Registry::set('Twitts', new Twitts());
?>
<!-- Start Latest Twitts -->
<?php if(Registry::get("Twitts")->username):?>
<?php
  function twitterStyle($tweet)
  {	  
      echo '<div class="twitter_item">';
      if (Registry::get('Twitts')->show_image) {
          echo '<img src="' . $tweet['user']['profile_image_url'] . '" class="wk left floated image" alt=""/>';
      }
		echo '<div>
				 <div class="user">
					 <a href="https://www.twitter.com/' . $tweet['user']['screen_name'] . '">
						 <span class="screenname">
							 <small>#</small>' . $tweet['user']['screen_name'] . '
						 </span>
						 </a>
				 <span class="time">
					 <a href="' . $tweet['twitter_link'] . '"> ' . Filter::dodate('long_date', $tweet['created_at']) . ' </a>
				 </span>
					 
				 </div>
				 <div class="text"> ' . $tweet['text'] . ' </div>
				 ' . ($tweet['is_retweet'] ? '<div class="retweet"> Retweeted by ' . $tweet['retweeter']['name'] . ' </div>' : '');
		echo '</div>
           </div>';
  }
?>
<div id="twitt" class="clearfix">
<div class="wk-carousel" 
  data-pagination="false" 
  data-navigation="true" 
  data-transition-style="goDown" 
  data-auto-play="true" 
  data-slide-speed="<?php echo Registry::get('Twitts')->speed;?>" 
  data-rewind-speed="<?php echo Registry::get('Twitts')->timeout;?>" 
  data-stop-on-hover="true" 
  data-single-item="true"
  >
   <?php echo Registry::get('Twitts')->PrintFeed('twitterStyle');?> </div>
</div>
<?php endif;?>
<!-- End Latest Twitts /-->