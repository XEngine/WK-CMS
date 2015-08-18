<?php
  /**
   * Header
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<!doctype html>
<head>
<?php echo $content->getMeta(); ?>
<script type="text/javascript">
var SITEURL = "<?php echo SITEURL; ?>";
</script>
<link href="<?php echo THEMEURL . '/cache/' . Minify::cache(array('css/base.css','css/button.css','css/image.css','css/icon.css','css/breadcrumb.css','css/popup.css','css/form.css','css/input.css','css/table.css','css/label.css','css/segment.css','css/message.css','css/divider.css','css/dropdown.css','css/list.css','css/header.css','css/menu.css','css/datepicker.css','css/progress.css','css/utility.css','css/comments.css','css/feed.css','css/editor.css'),'css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo THEMEURL . '/cache/' . Minify::cache(array('assets/css/main.css','assets/css/normalize.css'),'css');?>" rel="stylesheet" type="text/css" />

<?php Content::getThemeStyle();?>
<script src="<?php echo SITEURL;?>/assets/jquery.js"></script>
<script src="<?php echo SITEURL;?>/assets/jquery-ui.js"></script>
<script src="<?php echo SITEURL;?>/assets/modernizr.mq.js"></script>
<script src="<?php echo SITEURL;?>/assets/global.js"></script>
<script src="<?php echo SITEURL;?>/assets/jquery.ui.touch-punch.js"></script>
<script src="<?php echo THEMEURL;?>/master.js"></script>
<?php $content->getPluginAssets($assets);?>
<?php $content->getModuleAssets();?>
<?php if($core->eucookie):?>
<script type="text/javascript" src="<?php echo SITEURL;?>/assets/eu_cookies.js"></script>
<script type="text/javascript"> 
$(document).ready(function () {
    $("body").acceptCookies({
        position: 'top',
        notice: '<?php echo Lang::$word->_EU_NOTICE;?>',
        accept: '<?php echo Lang::$word->_EU_ACCEPT;?>',
        decline: '<?php echo Lang::$word->_EU_DECLINE;?>',
        decline_t: '<?php echo Lang::$word->_EU_DECLINE_T;?>',
        whatc: '<?php echo Lang::$word->_EU_W_COOKIES;?>'
    })
});
</script>
<?php endif;?>
</head>
<body<?php ($content->_url[0] == "page") ? $core->renderThemeBg() : null;?>>
<header class="clearfix">
  <div class="top-bar">
    <div class="wk secondary menu">
      <div class="wk-grid">
      
        <?php if($core->showlogin):?>
        <!-- Login Start -->
        <?php if($user->logged_in):?>
        <a class="item" href="<?php echo Url::Page($core->account_page);?>"><i class="icon user"></i> <b><?php echo Lang::$word->_WELCOME;?>: <?php echo $user->username;?>!</b></a>
        <?php if ($user->is_Admin()):?>
        <a class="item" href="<?php echo SITEURL;?>/admin/"><i class="icon laptop"></i> Admin Panel</a>
        <?php endif;?>
        <a class="item" href="<?php echo SITEURL;?>/logout.php"><i class="icon unlock"></i> <?php echo Lang::$word->_N_LOGOUT;?></a>
        <?php else:?>
        <div class="item"><b><?php echo Lang::$word->_WELCOME;?> <?php echo $user->username;?></b> </div>
        <a class="item" href="<?php echo Url::Page($core->register_page);?>"><?php echo Lang::$word->_UA_REGISTER;?></a> <a class="item" href="<?php echo Url::Page($core->login_page);?>"><i class="lock icon"></i> <?php echo Lang::$word->_UA_LOGIN;?></a>
        <?php endif;?>
        <!--/ Login End -->
        <?php endif;?>
        
        <div class="right menu">
          <form id="livesearch" action="<?php echo Url::Page($core->search_page);?>" method="post" name="search-form">
            <?php if($core->showsearch):?>
            <!-- Livesearch Start -->
            <div class="item">
              <div class="wk icon input">
                <input id="searchfield" name="keywords" placeholder="<?php echo Lang::$word->_SEARCH;?>..." type="text" autocomplete="off">
                <i class="search link icon"></i> </div>
              <div id="suggestions"></div>
            </div>
            <!--/ Livesearch End -->
            <?php endif;?>
            
            <?php if($core->show_lang):?>
            <!-- Langswitcher Start -->
            <div class="wk dropdown item"> <?php echo Lang::$word->_LANGUAGE;?> <i class="dropdown icon"></i>
              <div id="langmenu" class="menu">
                <?php foreach($core->langList() as $lang):?>
                <?php if(Core::$language == $lang->flag):?>
                <div class="item active" data-text="<?php echo $lang->name;?>"><i class="icon warning flag"></i><?php echo $lang->name;?></div>
                <?php else:?>
                <a href="<?php echo str_replace("url=","",$_SERVER['QUERY_STRING']);?>" class="item" data-lang="<?php echo $lang->flag;?>" data-text="<?php echo $lang->name;?>"><i class="icon flag"></i><?php echo $lang->name;?></a>
                <?php endif?>
                <?php endforeach;?>
              </div>
            </div>
            <!--/ Langswitcher End -->
            <?php endif;?>
            
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="middle-bar">
    <div class="wk-grid">
      <div class="wk-content">
        <div class="logo"> <a href="<?php echo SITEURL;?>/"><?php echo ($core->logo) ? '<img src="'.SITEURL.'/uploads/'.$core->logo.'" alt="'.$core->company.'" />': $core->company;?></a> <a id="menu-button"></a></div>
      </div>
    </div>
  </div>
  <nav id="menu-wrap" class="clearfix">
    <div class="wk-grid">
      <?php $mainmenu = $content->getMenuList(); $content->getMenu($mainmenu,0, "menu", "sm topmenu");?>
    </div>
  </nav>
</header>