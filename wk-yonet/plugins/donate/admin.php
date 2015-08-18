<?php
  /**
   * Donations
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  if(!$user->getAcl("donate")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
  
  Registry::set('Donate', new Donate());
?>
<?php switch(Filter::$paction): case "config": ?>
<?php $row = Registry::get("Donate");?>
<div class="wk icon heading message orange"> <a class="helper wk top right info corner label" data-help="donate"><i class="icon help"></i></a> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PLG_DP_TITLE2;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=donate" class="section"><?php echo $content->getPluginName(Filter::$plugname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_PLG_DP_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PLG_DP_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_PLG_DP_SUBTITLE1;?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_DP_TARGET;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->atarget;?>" name="atarget">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_DP_PAYPAL;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->paypal;?>" name="paypal">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_DP_THANKYOU;?></label>
          <?php echo Content::getPageList("slug", $row->thankyou);?> </div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_PLG_DP_UPDATE;?></button>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=donate" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processConfig" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php default: ?>
<?php $donaterow = Registry::get("Donate")->getDonations();?>
<div class="wk icon heading message orange"> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PLG_DP_TITLE2;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo $content->getPluginName(Filter::$plugname);?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PLG_DP_INFO2;?></div>
  <div class="wk segment">
    <div class="push-right">
      <div class="wk right pointing dropdown icon info button"> <i class="settings icon"></i>
        <div class="menu"> <a href="index.php?do=plugins&amp;action=config&amp;plugname=donate&amp;paction=config" class="item"><i class="setting icon"></i><?php echo Lang::$word->_PLG_DP_CONFIG;?></a> <a class="item addrecord"><i class="plus icon"></i><?php echo Lang::$word->_PLG_DP_ADD;?></a> <a href="plugins/donate/controller.php?exportDonations" class="item"><i class="table icon"></i><?php echo Lang::$word->_PLG_DP_EXPORT;?></a> <a href="plugins/donate/controller.php?emptyDonations" class="item"><i class="remove icon"></i><?php echo Lang::$word->_PLG_DP_RESET;?></a> </div>
      </div>
    </div>
    <div class="wk header"><?php echo Lang::$word->_PLG_DP_SUBTITLE2;?></div>
    <div class="wk fitted divider"></div>
    <div class="wk small basic form segment">
      <div class="four fields">
        <div class="field">&nbsp;</div>
        <div class="field">&nbsp;</div>
        <div class="field"> <?php echo $pager->items_per_page();?> </div>
        <div class="field"> <?php echo $pager->jump_menu();?> </div>
      </div>
    </div>
    <table class="wk sortable table">
      <thead>
        <tr>
          <th data-sort="int">#</th>
          <th data-sort="string"><?php echo Lang::$word->_PLG_DP_NAME;?></th>
          <th data-sort="string"><?php echo Lang::$word->_PLG_DP_EMAIL;?></th>
          <th data-sort="int"><?php echo Lang::$word->_PLG_DP_AMOUNT;?></th>
          <th data-sort="int"><?php echo Lang::$word->_PLG_DP_CREATED;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$donaterow):?>
        <tr>
          <td colspan="5"><?php echo Filter::msgSingleAlert(Lang::$word->_PLG_DP_NODONATIONS);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($donaterow as $row):?>
        <tr>
          <td><?php echo $row->id;?>.</td>
          <td><?php echo $row->name;?></td>
          <td><?php echo $row->email;?></td>
          <td><?php echo $row->amount;?></td>
          <td data-sort-value="<?php echo strtotime($row->created);?>"><?php echo Filter::dodate("long_date", $row->created);?></td>
        </tr>
        <?php endforeach;?>
        <?php unset($row);?>
        <?php endif;?>
      </tbody>
    </table>
  </div>
  <div class="wk-grid">
    <div class="two columns horizontal-gutters">
      <div class="row"> <span class="wk label"><?php echo Lang::$word->_PAG_TOTAL.': '.$pager->items_total;?> / <?php echo Lang::$word->_PAG_CURPAGE.': '.$pager->current_page.' '.Lang::$word->_PAG_OF.' '.$pager->num_pages;?></span> </div>
      <div class="row">
        <div id="pagination"><?php echo $pager->display_pages();?></div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
// <![CDATA[
 $(document).ready(function () {
    /* == Add Payment == */
    $('body').on('click', 'a.addrecord', function () {
		var text = 
			'<div class="wk small form">'
			+ '<div class="field"><label><?php echo Lang::$word->_PLG_DP_NAME;?></label>'
			+ '<label class="input"><i class="icon-append icon asterisk"></i>'
			+ '<input type="text" name="fname">'
			+ '</label></div>'
			+ '<div class="field"><label><?php echo Lang::$word->_PLG_DP_EMAIL;?></label>'
			+ '<label class="input"><i class="icon-append icon asterisk"></i>'
			+ '<input type="text" name="email">'
			+ '</label></div>'
			+ '<div class="field"><label><?php echo Lang::$word->_PLG_DP_AMOUNT;?></label>'
			+ '<label class="input"><i class="icon-prepend icon dollar"></i><i class="icon-append icon asterisk"></i>'
			+ '<input type="text" name="amount">'
			+ '</label></div>'
			+ '</div>'
        new Messi(text, {
            title: '<?php echo Lang::$word->_PLG_DP_ADD;?>',
            modal: true,
            closeButton: true,
            buttons: [{
                id: 0,
                label: '<?php echo Lang::$word->_SUBMIT;?>',
                class: 'positive',
                val: 'Y'
            }],
            callback: function (val) {
                $.ajax({
                    type: 'post',
                    url: "plugins/donate/controller.php",
                    dataType: 'json',
                    data: {
                        addPayment: 1,
                        name: $("input[name=fname]").val(),
						email: $("input[name=email]").val(),
						amount: $("input[name=amount]").val()
                    },
                    success: function (json) {
						if(json.type == "success") {
							$(".wk.table tbody").prepend(json.html)
						}
                        $.sticky(decodeURIComponent(json.message), {
                            type: json.type,
                            title: json.title
                        });
                    }
                });
            }
        });
    });
 });
// ]]>
</script>
<?php break;?>
<?php endswitch;?>