<?php
  /**
   * loadComments
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  define("_VALID_PHP", true);
  require_once ("../../init.php");

  require_once (MODPATH . "comments/admin_class.php");
  Registry::set('Comments', new Comments());

  if (isset($_GET['pg']) and isset($_GET['pid'])) :
      $page = intval($_GET['pg']);
      $pid = intval($_GET['pid']);

      $start = ($page - 1) * Registry::get("Comments")->perpage;
      $limit = $start . ',' . Registry::get("Comments")->perpage;

      $sql = "SELECT c.*, UNIX_TIMESTAMP(c.created) as cdate, u.avatar, u.username as uname" 
	  . "\n FROM " . Comments::mTable . " as c" 
	  . "\n LEFT JOIN " . Users::uTable . " as u ON u.id = c.user_id" 
	  . "\n WHERE c.page_id = " . intval($pid) 
	  . "\n AND c.active = 1" 
	  . "\n ORDER BY c.created " . Registry::get("Comments")->sorting . " LIMIT  " . $limit;
	  
      $comrows = $db->fetch_all($sql);
  endif;
?>
<?php if(isset($_GET['pg']) and isset($_GET['pid'])):?>
<?php if(!$comrows):?>
<?php echo Filter::msgSingleInfo(Lang::$word->_MOD_CM_NOCOMMENTS);?>
<?php else:?>
<?php foreach ($comrows as $comrow):?>
<div class="comment clearfix" data-id="<?php echo $comrow->id;?>">
  <div class="avatar"> <img src="<?php echo UPLOADURL;?>avatars/<?php echo ($comrow->avatar) ? $comrow->avatar : "blank.png";?>" alt=""> </div>
  <div class="content"> <span class="author"><?php echo ($comrow->user_id ? '<a href="' . Url::Page($core->profile_page, $comrow->uname. '/') . '"> ' .$comrow->uname. '</a>' : ($comrow->uname ? $comrow->uname : Lang::$word->_GUEST));?></span>
    <div class="metadata"> <span class="date"><i class="icon time"></i> <?php echo timesince($comrow->cdate);?></span> </div>
    <div class="text"> <?php echo cleanOut($comrow->body);?></div>
  </div>
</div>
<?php endforeach;?>
<?php unset($comrow);?>
<?php endif;?>
<?php endif;?>