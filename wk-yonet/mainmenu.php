<?php
  /**
   * Mainmenu
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2010
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<div class="wk styled pushed sidebar active" id="sidemenu">
  <div class="logo"><a href="index.php"><?php echo ($core->logo) ? '<img src="'.SITEURL.'/uploads/logo150.png" alt="'.$core->company.'" />': $core->company;?></a></div>
  <nav>
    <ul>
      <li><a href="index.php" class="red<?php if (!Filter::$do) echo " active";?>"><i class="icon dashboard"></i><span><?php echo Lang::$word->_N_DASH;?></span></a></li>
      <?php if($user->getAcl("Menus")):?>
      <li><a href="index.php?do=menus" class="sky<?php if (Filter::$do == 'menus') echo " active";?>"><i class="icon reorder"></i><span><?php echo Lang::$word->_N_MENUS;?></span></a></li>
      <?php endif;?>
      <?php if($user->getAcl("Pages")):?>
      <li><a href="index.php?do=pages" class="green<?php if (Filter::$do == 'pages') echo " active";?>"><i class="icon file"></i><span><?php echo Lang::$word->_N_PAGES;?></span></a></li>
      <?php endif;?>
      <?php if($user->getAcl("Modules")):?>
      <li><a href="index.php?do=modules" class="blue<?php if (Filter::$do == 'modules') echo " active";?>"><i class="icon puzzle piece"></i><span><?php echo Lang::$word->_N_MODS;?></span></a></li>
      <?php endif;?>
      <?php if($user->getAcl("Plugins")):?>
      <li><a href="index.php?do=plugins" class="orange<?php if (Filter::$do == 'plugins') echo " active";?>"><i class="icon umbrella"></i><span><?php echo Lang::$word->_N_PLUGS;?></span></a></li>
      <?php endif;?>
      <?php if($user->getAcl("Memberships") or $user->getAcl("Gateways") or $user->getAcl("Transactions")):?>
      <li><a class="coral <?php echo (Filter::$do == 'memberships' or Filter::$do == 'gateways' or Filter::$do == 'transactions') ? "expanded" : "collapsed";?>"><i class="icon bookmark"></i><span><?php echo Lang::$word->_N_MEMBS;?><b>...</b></span></a>
        <ul>
          <?php if($user->getAcl("Memberships")):?>
          <li><a href="index.php?do=memberships" class="coral<?php if (Filter::$do == 'memberships') echo  " active";?>"><i class="icon setting"></i><span><?php echo Lang::$word->_N_MEMBSET;?></span></a></li>
          <?php endif;?>
          <?php if($user->getAcl("Gateways")):?>
          <li><a href="index.php?do=gateways" class="coral<?php if (Filter::$do == 'gateways') echo " active";?>"><i class="icon share"></i><span><?php echo Lang::$word->_N_GATES;?></span></a></li>
          <?php endif;?>
          <?php if($user->getAcl("Transactions")):?>
          <li><a href="index.php?do=transactions" class="coral<?php if (Filter::$do == 'transactions') echo " active";?>"><i class="icon payment"></i><span><?php echo Lang::$word->_N_TRANS;?></span></a></li>
          <?php endif;?>
        </ul>
      </li>
      <?php endif;?>
      <?php if($user->getAcl("Layout")):?>
      <li><a href="index.php?do=layout" class="teal<?php if (Filter::$do == 'layout') echo " active";?>"><i class="icon block layout"></i><span><?php echo Lang::$word->_N_LAYS;?></span></a></li>
      <?php endif;?>
      <?php if($user->getAcl("Users")):?>
      <li><a href="index.php?do=users" class="dust<?php if (Filter::$do == 'users') echo " active";?>"><i class="icon user"></i><span><?php echo Lang::$word->_N_USERS;?></span></a></li>
      <?php endif;?>
      <?php if($user->getAcl("Configuration") or $user->getAcl("Templates") or $user->getAcl("Newsletter") or $user->getAcl("Language") or $user->getAcl("Maintenance") or $user->getAcl("Logs") or $user->getAcl("Backup") or $user->getAcl("FM") or $user->getAcl("Fields") or $user->getAcl("System")):?>
      <li><a class="mortar <?php echo (Filter::$do == 'config' or Filter::$do == 'templates' or Filter::$do == 'newsletter' or Filter::$do == 'language' or Filter::$do == 'maintenance' or Filter::$do == 'logs' or Filter::$do == 'fields' or Filter::$do == 'backup' or Filter::$do == 'filemanager' or Filter::$do == 'system') ? "expanded" : "collapsed";?>"><i class="icon setting"></i><span><?php echo Lang::$word->_N_CONF;?><b>...</b></span></a>
        <ul class="subnav">
          <?php if($user->getAcl("Configuration")):?>
          <li><a href="index.php?do=config" class="mortar<?php if (Filter::$do == 'config') echo " active";?>"><i class="icon setting"></i><span><?php echo Lang::$word->_CG_TITLE1;?></span></a></li>
          <?php endif;?>
          <?php if($user->getAcl("Templates")):?>
          <li><a href="index.php?do=templates" class="mortar<?php if (Filter::$do == 'templates') echo " active";?>"><i class="icon mail"></i><span><?php echo Lang::$word->_N_EMAILS;?></span></a></li>
          <?php endif;?>
          <?php if($user->getAcl("Newsletter")):?>
          <li><a href="index.php?do=newsletter" class="mortar<?php if (Filter::$do == 'newsletter') echo " active";?>"><i class="icon mail reply"></i><span><?php echo Lang::$word->_N_NEWSL;?></span></a></li>
          <?php endif;?>
          <?php if($user->getAcl("Fields")):?>
          <li><a href="index.php?do=fields" class="mortar<?php if (Filter::$do == 'fields') echo " active";?>"><i class="icon tasks"></i><span><?php echo Lang::$word->_N_FIELDS;?></span></a></li>
          <?php endif;?>
          <?php if($user->getAcl("Language")):?>
          <li><a href="index.php?do=language" class="mortar<?php if (Filter::$do == 'language') echo " active";?>"><i class="icon chat"></i><span><?php echo Lang::$word->_N_LANGS;?></span></a></li>
          <?php endif;?>
          <?php if($user->getAcl("Maintenance")):?>
          <li><a href="index.php?do=maintenance" class="mortar<?php if (Filter::$do == 'maintenance') echo " active";?>"><i class="icon wrench"></i><span><?php echo Lang::$word->_N_SMTCN;?></span></a></li>
          <?php endif;?>
          <?php if($user->getAcl("Backup")):?>
          <li><a href="index.php?do=backup" class="mortar<?php if (Filter::$do == 'backup') echo " active";?>"><i class="icon hdd"></i><span><?php echo Lang::$word->_N_BACK;?></span></a></li>
          <?php endif;?>
          <?php if($user->getAcl("FM")):?>
          <li><a href="index.php?do=filemanager" class="mortar<?php if (Filter::$do == 'filemanager') echo " active";?>"><i class="icon folder"></i><span><?php echo Lang::$word->_N_FM;?></span></a></li>
          <?php endif;?>
          <?php if($user->getAcl("System")):?>
          <li><a href="index.php?do=system" class="mortar<?php if (Filter::$do == 'system') echo " active";?>"><i class="icon laptop"></i><span><?php echo Lang::$word->_N_SYSTEM;?></span></a></li>
          <?php endif;?>
          <?php if($user->getAcl("Logs")):?>
          <li><a href="index.php?do=logs" class="mortar<?php if (Filter::$do == 'logs') echo " active";?>"><i class="icon shield"></i><span><?php echo Lang::$word->_N_LOGS;?></span></a></li>
          <?php endif;?>
        </ul>
      </li>
      <?php endif;?>
    </ul>
  </nav>
  <div class="sublist"></div>
</div>