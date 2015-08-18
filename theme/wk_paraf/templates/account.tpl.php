<?php
  /**
   * Account Template
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  if (!$user->logged_in)
      redirect_to(Url::Page($core->login_page));
	  
  $listpackrow  = $member->getMembershipListFrontEnd();
  $mrow = $user->getUserMembership();
  $gatelist = $member->getGateways(true);
  $usr = $user->getUserData();
?>
<h1 class="wk double header"><span><?php echo Lang::$word->_UA_TITLE1;?></span></h1>
<p><i class="information icon"></i> <?php echo Lang::$word->_UA_INFO1;?></p>
<div id="acctab" class="wtabs">
  <ul class="wk tabs">
    <li><a data-tab="#uprofile"><i class="icon user"></i> <?php echo Lang::$word->_UA_SUBTITLE1;?></a></li>
    <li><a data-tab="#umember"><i class="icon certificate"></i> <?php echo Lang::$word->_UA_SEL_MEMBERSHIP;?></a></li>
    <?php if(file_exists(MODPATHF . 'digishop/account.tpl.php')):?>
    <li><a data-tab="#digishop"><i class="icon cart disk"></i> <?php echo getValue("title" . Lang::$lang, Content::mdTable, "modalias = 'digishop'");?></a></li>
    <?php endif;?>
    <?php if(file_exists(MODPATHF . 'blog/account.tpl.php')):?>
    <?php require_once (MODPATH . "blog/admin_class.php");?>
    <?php Registry::set('Blog', new Blog(true));?>
    <?php if(Registry::get("Blog")->upost):?>
    <li><a data-tab="#blog"><i class="icon tasks"></i> <?php echo getValue("title" . Lang::$lang, Content::mdTable, "modalias = 'blog'");?></a></li>
    <?php endif;?>
    <?php endif;?>
    <?php if(file_exists(MODPATHF . 'booking/account.tpl.php')):?>
    <li><a data-tab="#booking"><i class="icon ticket"></i> <?php echo getValue("title" . Lang::$lang, Content::mdTable, "modalias = 'booking'");?></a></li>
    <?php endif;?>
    <?php if(file_exists(MODPATHF . 'invoice/account.tpl.php')):?>
    <li><a data-tab="#invoice"><i class="icon edit"></i> <?php echo getValue("title" . Lang::$lang, Content::mdTable, "modalias = 'invoice'");?></a></li>
    <?php endif;?>
  </ul>
  <div id="uprofile" class="wk tab content">
    <div class="wk secondary form segment">
      <form id="wk_form" name="wk_form" method="post">
        <h3><?php echo Lang::$word->_UA_SUBTITLE1;?></h3>
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_USERNAME;?></label>
            <input name="username" type="text" disabled="disabled" value="<?php echo $usr->username;?>">
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_PASSWORD;?></label>
            <input name="password" type="password">
          </div>
        </div>
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_UR_FNAME;?></label>
            <input name="fname" type="text" value="<?php echo $usr->fname;?>">
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_UR_LNAME;?></label>
            <input name="lname" type="text" value="<?php echo $usr->lname;?>">
          </div>
        </div>
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_UR_EMAIL;?></label>
            <label class="input">
              <input name="email" type="text" value="<?php echo $usr->email;?>">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_UR_IS_NEWSLETTER;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="newsletter" type="radio" value="1" <?php echo getChecked($usr->newsletter, 1);?>>
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="newsletter" type="radio" value="0" <?php echo getChecked($usr->newsletter, 0);?>>
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
        </div>
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_UR_AVATAR;?></label>
            <label class="input">
              <input type="file" name="avatar" class="filefield">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_UR_AVATAR;?></label>
            <div class="wk avatar image">
              <?php if($usr->avatar):?>
              <img src="<?php echo UPLOADURL;?>avatars/<?php echo $usr->avatar;?>" alt="<?php echo $usr->username;?>">
              <?php else:?>
              <img src="<?php echo UPLOADURL;?>avatars/blank.png" alt="<?php echo $usr->username;?>">
              <?php endif;?>
            </div>
          </div>
        </div>
        <?php echo $content->rendertCustomFields('profile', $usr->custom_fields);?>
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_UR_LASTLOGIN;?></label>
            <input type="text" value="<?php echo Filter::dodate("long_date", $usr->lastlogin);?>" name="lastlogin" disabled="disabled">
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_UR_DATE_REGGED;?></label>
            <input type="text" value="<?php echo Filter::dodate("long_date", $usr->created);?>" name="lastlogin" disabled="disabled">
          </div>
        </div>
        <div class="three fields">
          <div class="field">
            <label>Facebook</label>
            <label class="input"><i class="icon-append icon url"></i>
              <input type="text" value="<?php echo $usr->fb_link;?>" name="fb_link">
            </label>
          </div>
          <div class="field">
            <label>Twitter</label>
            <label class="input"><i class="icon-append icon url"></i>
              <input type="text" value="<?php echo $usr->tw_link;?>" name="tw_link">
            </label>
          </div>
          <div class="field">
            <label>Goole Plus</label>
            <label class="input"><i class="icon-append icon url"></i>
              <input type="text" value="<?php echo $usr->gp_link;?>" name="gp_link">
            </label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_UR_BIO;?></label>
          <textarea name="info"><?php echo $usr->info;?></textarea>
        </div>
        <button data-url="/ajax/controller.php" type="button" name="dosubmit" class="wk danger button"><?php echo Lang::$word->_UA_UPDATE;?></button>
        <input name="doProfile" type="hidden" value="1">
      </form>
    </div>
    <div id="msgholder"></div>
  </div>
  <div id="umember" class="wk tab content">
    <div class="wk secondary segment">
      <h3><?php echo Lang::$word->_UA_SEL_MEMBERSHIP;?></h3>
      <div class="wk divided list">
        <div class="item">
          <div class="right floated tiny positive wk button">
            <?php if($usr->membership_id == 0) :?>
            <?php echo Lang::$word->_UA_NO_MEMBERSHIP;?>
            <?php else:?>
            <?php echo $mrow->{'title'.Lang::$lang};?>
            <?php endif;?>
          </div>
          <div class="content">
            <div class="header"><?php echo Lang::$word->_UA_CUR_MEMBERSHIP;?></div>
          </div>
        </div>
        <div class="item">
          <div class="right floated tiny positive wk button">
            <?php if($usr->membership_id == 0) :?>
            --/--
            <?php else:?>
            <?php echo Filter::dodate("long_date", $mrow->mem_expire);?>
            <?php endif;?>
          </div>
          <div class="content">
            <div class="header"><?php echo Lang::$word->_UA_VALID_UNTIL;?></div>
          </div>
        </div>
      </div>
    </div>
	<?php if($listpackrow ):?>
    <div class="wk secondary segment">
      <h3><?php echo Lang::$word->_MS_SUBTITLE3;?></h3>
      <?php $total = count($listpackrow);?>
      <?php $color = array("positive","info","warning","negative","purple","teal","black");?>
      <div id="mempacks">
        <div class="columns">
          <div class="<?php echo numberToWords($total);?> columns small-gutters">
            <?php foreach ($listpackrow as $i => $prow):?>
            <div class="row">
              <div class="wk <?php echo $color[$i];?> segment">
                <h4 class=""><?php echo $prow->{'title'.Lang::$lang};?></h4>
                <p class="wk 2 fluid buttons"> <span class="wk <?php echo $color[$i];?> small button"><?php echo $core->formatMoney($prow->price);?></span> <span class="wk <?php echo $color[$i];?> small button"><?php echo $prow->days . ' ' .$member->getPeriod($prow->period);?></span></p>
                <p class="item"><span class="wk <?php echo $color[$i];?> small fluid button"><?php echo Lang::$word->_MS_RECURRING;?> <b><?php echo ($prow->recurring) ? '<i class="icon check"></i>' : '<i class="icon ban circle"></i>';?></b></span></p>
                <p><small><?php echo $prow->{'description'.Lang::$lang};?></small> </p>
                <a class="add-cart wk <?php echo $color[$i];?> fluid button" data-price="<?php echo $prow->price;?>" data-id="<?php echo $prow->id;?>">
                <?php if($prow->price <> 0):?>
                <i class="icon dollar"></i>
                <?php endif;?>
                <?php echo ($prow->price <> 0) ? Lang::$word->_UA_BUY : Lang::$word->_UA_ACTIVATE;?></a> </div>
            </div>
            <?php endforeach;?>
          </div>
        </div>
      </div>
    </div>
    <div id="gresults"></div>
	<?php endif;?>
  </div>
  <?php if(file_exists(MODPATHF . 'digishop/account.tpl.php')):?>
  <div id="digishop" class="wk tab content">
    <?php require_once(MODPATHF . 'digishop/account.tpl.php');?>
  </div>
  <?php endif;?>
  <?php if(file_exists(MODPATHF . 'blog/account.tpl.php') and Registry::get("Blog")->upost):?>
  <div id="blog" class="wk tab content">
    <?php require_once(MODPATHF . 'blog/account.tpl.php');?>
  </div>
  <?php endif;?>
  <?php if(file_exists(MODPATHF . 'booking/account.tpl.php')):?>
  <div id="booking" class="wk tab content">
    <?php require_once(MODPATHF . 'booking/account.tpl.php');?>
  </div>
  <?php endif;?>
  <?php if(file_exists(MODPATHF . 'invoice/account.tpl.php')):?>
  <div id="invoice" class="wk tab content">
    <?php require_once(MODPATHF . 'invoice/account.tpl.php');?>
  </div>
  <?php endif;?>
</div>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
    $("#mempacks").on("click", "a.add-cart", function () {
        id = $(this).data('id');
        price = $(this).data('price');
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: SITEURL + "/ajax/controller.php",
            data: {
                addtocart: 1,
                id: id
            },
            success: function (json) {
                $("#gresults").html(json.message);

            }
        });
        return false;
    });
});
// ]]>
</script>