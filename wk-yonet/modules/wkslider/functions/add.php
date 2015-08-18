<div class="wk icon heading message orange"> <a class="helper wk top right info corner label" data-help="slidecms"><i class="icon help"></i></a><i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_SLC_TITLE4;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=slidecms" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_SLC_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_SLC_INFO2. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_MOD_SLC_SUBTITLE2?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_NAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_SLC_NAME;?>" name="title">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_HEIGHT;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_SLC_HEIGHT;?>" name="height">
          </label>
        </div>
      </div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_NAVTYPE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="navtype" type="radio" value="thumbs">
              <i></i><?php echo Lang::$word->_MOD_SLC_NAVTYPE_1;?></label>
            <label class="radio">
              <input name="navtype" type="radio" value="dots" checked="checked">
              <i></i><?php echo Lang::$word->_MOD_SLC_NAVTYPE_2;?></label>
            <label class="radio">
              <input name="navtype" type="radio" value="false">
              <i></i><?php echo Lang::$word->_MOD_SLC_NAVTYPE_3;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_NAVPOS;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="navpos" type="radio" value="top">
              <i></i><?php echo Lang::$word->_MOD_SLC_NAVPOS_1;?></label>
            <label class="radio">
              <input name="navpos" type="radio" value="bottom" checked="checked">
              <i></i><?php echo Lang::$word->_MOD_SLC_NAVPOS_2;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_NAVPLACE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="navplace" type="radio" value="innernav">
              <i></i><?php echo Lang::$word->_MOD_SLC_NAVPLACE_1;?></label>
            <label class="radio">
              <input name="navplace" type="radio" value="outer" checked="checked">
              <i></i><?php echo Lang::$word->_MOD_SLC_NAVPLACE_2;?></label>
          </div>
        </div>
      </div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_ARROWS;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="navarrows" type="radio" value="1" checked="checked">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="navarrows" type="radio" value="0">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_RESMETHOD;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="fit" type="radio" value="contain" checked="checked">
              <i></i><?php echo Lang::$word->_MOD_SLC_RESMETHOD_1;?></label>
            <label class="radio">
              <input name="fit" type="radio" value="cover">
              <i></i><?php echo Lang::$word->_MOD_SLC_RESMETHOD_2;?></label>
            <label class="radio">
              <input name="fit" type="radio" value="scaledown">
              <i></i><?php echo Lang::$word->_MOD_SLC_RESMETHOD_3;?></label>
            <label class="radio">
              <input name="fit" type="radio" value="none">
              <i></i><?php echo Lang::$word->_MOD_SLC_RESMETHOD_4;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_FULLSCREEN;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="fullscreen" type="radio" value="1">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="fullscreen" type="radio" value="0" checked="checked">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="wk divider"></div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_TRANSITION;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="transition" type="radio" value="slide">
              <i></i><?php echo Lang::$word->_MOD_SLC_TRANSITION_1;?></label>
            <label class="radio">
              <input name="transition" type="radio" value="crossfade" checked="checked">
              <i></i><?php echo Lang::$word->_MOD_SLC_TRANSITION_2;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_CAPTION;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="captions" type="radio" value="1" checked="checked">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="captions" type="radio" value="0">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_AUTOPLAY;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="autoplay" type="radio" value="1">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="autoplay" type="radio" value="0" checked="checked">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_LOOP;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="loop" type="radio" value="1">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="loop" type="radio" value="0" checked="checked">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_SHUFFLE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="shuffle" type="radio" value="1">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="shuffle" type="radio" value="0" checked="checked">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_TRANSDURRATION;?></label>
          <label class="input">
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_SLC_TRANSDURRATION;?>" name="durration">
          </label>
        </div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_MOD_SLC_ADD;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=slidecms" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="addSlider" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>