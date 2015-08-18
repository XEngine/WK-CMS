<?php
  /**
   * Login Template
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php
  if ($user->logged_in)
      redirect_to(Url::Page($core->account_page));
	  
  if (isset($_POST['doLogin']))
      : $result = $user->login($_POST['username'], $_POST['password']);
  /* Login Successful */
  if ($result)
      : redirect_to(Url::Page($core->account_page));
  endif;
  endif;
?>
<div id="login">
  <div class="columns">
    <div class="screen-50 phone-100 push-center">
      <div class="nav clearfix"><a data-tab="#signin" class="active"><?php echo Lang::$word->_UA_TITLE2;?></a> <a data-tab="#reset"><?php echo Lang::$word->_UA_TITLE3;?></a></div>
      <div id="signin" class="section">
        <p><i class="information icon"></i> <?php echo Lang::$word->_UA_SUBTITLE2;?></p>
        <form method="post" id="login_form" name="login_form">
          <div class="columns">
            <div class="screen-30">
              <div class="item">
                <label><?php echo Lang::$word->_UA_TITLE2;?> <i class="small icon asterisk"></i></label>
              </div>
            </div>
            <div class="screen-70">
              <div class="item">
                <input name="username" placeholder="<?php echo Lang::$word->_UA_TITLE2;?>" type="text">
              </div>
            </div>
            <div class="screen-30">
              <div class="item">
                <label><?php echo Lang::$word->_PASSWORD;?> <i class="small icon asterisk"></i></label>
              </div>
            </div>
            <div class="screen-70">
              <div class="item">
                <input name="password" placeholder="<?php echo Lang::$word->_PASSWORD;?>" type="password">
              </div>
            </div>
            <div class="content-right"> <a href="<?php echo Url::Page($core->register_page);?>" class="right-space"><?php echo Lang::$word->_UA_CLICKTOREG;?></a>
              <button name="submit" type="submit" class="wk positive button"><?php echo Lang::$word->_UA_LOGINNOW;?></button>
            </div>
            <input name="doLogin" type="hidden" value="1">
          </div>
        </form>
        <?php print Filter::$showMsg;?> </div>
      <div id="reset" class="section">
        <p><i class="information icon"></i> <?php echo Lang::$word->_UA_SUBTITLE3;?></p>
        <form id="wk_form" name="wk_form" method="post" class="wk form">
          <div class="columns">
            <div class="screen-30">
              <div class="item">
                <label><?php echo Lang::$word->_USERNAME;?> <i class="small icon asterisk"></i></label>
              </div>
            </div>
            <div class="screen-70">
              <div class="item">
                <input name="uname" placeholder="<?php echo Lang::$word->_USERNAME;?>" type="text">
              </div>
            </div>
            <div class="screen-30">
              <div class="item">
                <label><?php echo Lang::$word->_UR_EMAIL;?> <i class="small icon asterisk"></i></label>
              </div>
            </div>
            <div class="screen-70">
              <div class="item">
                <input name="email" placeholder="<?php echo Lang::$word->_UR_EMAIL;?>" type="text">
              </div>
            </div>
            <div class="screen-30">
              <div class="item">
                <label><?php echo Lang::$word->_UA_PASS_RTOTAL;?> <i class="small icon asterisk"></i></label>
              </div>
            </div>
            <div class="screen-70">
              <div class="item">
                <input name="captcha" placeholder="<?php echo Lang::$word->_UA_PASS_RTOTAL;?>" type="text">
                <img src="<?php echo SITEURL;?>/captcha.php" alt=""> </div>
            </div>
          </div>
          <button data-url="/ajax/user.php" type="button" name="dosubmit" class="wk danger button"><?php echo Lang::$word->_UA_PASS_RSUBMIT;?></button>
          <input name="passReset" type="hidden" value="1">
        </form>
        <div id="msgholder"></div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
    $("#login .section").hide();
    $("#login .nav a:first").addClass("active").show();
    $("#login .section:first").show();
    $("#login .nav a").on('click', function () {
        $("#login .nav a").removeClass("active");
        $(this).addClass("active");
        $("#login .section").hide();
        var activeTab = $(this).data("tab");
        $(activeTab).show();
    });
});
// ]]>
</script>