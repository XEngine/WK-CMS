<?php $row = Core::getRowById(slideCMS::mTable, Filter::$id);?>

<?php //TODO :: LANGUAGE AYARLARI ?>
<div class="wk icon heading message orange"> <a class="helper wk top right info corner label" data-help="slidecms"><i class="icon help"></i></a> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_SLC_TITLE4;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=slidecms" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_SLC_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_SLC_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_MOD_SLC_SUBTITLE1 . $row->title;?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_NAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->title;?>" name="title">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_HEIGHT;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->height;?>" name="height">
          </label>
        </div>
        <div class="field">
          <label>Slayt Uzunluğu</label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->width;?>" name="height">
          </label>
        </div>
      </div>
      <div class="wk divider"></div>
      <div class="three fields">
        <div class="field">
          <label>Slayt Genel Arkaplanı</label>
          <small>Slayt içerisindeki her slayt elementi için genel bir arkaplan belirler.</small><br><br>
          <div class="inline-group">
              <?php if($row->globalBGImage === 'false') : ?>
                <p>Bu slayt için belirlenmiş bir arkaplan resmi yok</p>
              <?php else: ?>
                <p><img src="<?php echo $row->globalBGImage; ?>" height="60"/></p>
              <?php endif; ?>
              <br>
              <input type="file" name="globalBGImage">
          </div>
        </div>
      </div>
      <div class="wk divider"></div>
      <div class="three fields">
        <div class="field">
          <label>Otomatik Başlat</label>
          <small>Slayt, sayfa yüklendiğinde otomatik başlayıp başlamayacağını belirler.</small>
          <div class="inline-group">
            <label class="radio">
              <input name="autoStart" type="radio" value="1" <?php echo getChecked($row->autoStart, "1");?>>
              <i></i>Evet</label>
            <label class="radio">
              <input name="autoStart" type="radio" value="0" <?php echo getChecked($row->autoStart, "0");?>>
              <i></i>Hayır</label>
          </div>
        </div>
        <div class="field">
          <label>Mobil Cihazlarda Göster</label>
          <small>Slayt, Mobil Cihazlardan girildiğinde devredışı kalmasını belirler.</small>
          <div class="inline-group">
            <label class="radio">
              <input name="hideOnMobile" type="radio" value="1" <?php echo getChecked($row->hideOnMobile, "1");?>>
              <i></i>Devre dışı</label>
            <label class="radio">
              <input name="hideOnMobile" type="radio" value="0" <?php echo getChecked($row->hideOnMobile, "0");?>>
              <i></i>Etkin</label>
          </div>
        </div>
        <div class="field">
          <label>Esneklik</label>
          <small>Slaytın tüm cihazlara göre otomatik boyutlandırmasını belirler.</small>
          <div class="inline-group">
            <label class="radio">
              <input name="responsive" type="radio" value="1" <?php echo getChecked($row->responsive, "1");?>>
              <i></i>Esnek</label>
            <label class="radio">
              <input name="responsive" type="radio" value="0" <?php echo getChecked($row->responsive, "0");?>>
              <i></i>Statik</label>
          </div>
        </div>
      </div>
      <div class="three fields">
        <div class="field">
          <label>Animasyonlu İlk Gösterim</label>
          <small>Sayfa yüklendikten hemen sonra gelecek ilk slaytın animasyonlu olup olmayacağını belirler(Düşük perfomanslı cihazlar için statik seçilmesi önerilir)</small>
          <div class="inline-group">
            <label class="radio">
              <input name="animateFirstSlide" type="radio" value="1" <?php echo getChecked($row->animateFirstSlide, "1");?>>
              <i></i>Animasyonlu</label>
            <label class="radio">
              <input name="animateFirstSlide" type="radio" value="0" <?php echo getChecked($row->animateFirstSlide, "0");?>>
              <i></i>Statik</label>
          </div>
        </div>
        <div class="field">
          <label>Mouse Üzerine Gelindiğinde Durdur</label>
          <small>Mouse, Slayt'ın üzerine geldiğinde slayt'ın kaymasını durdur.</small><br/><br/>
          <div class="inline-group">
            <label class="radio">
              <input name="pauseOnHover" type="radio" value="1" <?php echo getChecked($row->pauseOnHover, "1");?>>
              <i></i>Evet</label>
            <label class="radio">
              <input name="pauseOnHover" type="radio" value="0" <?php echo getChecked($row->pauseOnHover, "0");?>>
              <i></i>Hayır</label>
          </div>
        </div>
        <div class="field">
          <label>Rastgele</label>
          <small>Slayt sırasını yoksayar ve slayt listesini rastgele göstermeye başlar.</small><br/><br/>
          <div class="inline-group">
            <label class="radio">
              <input name="randomSlideshow" type="radio" value="1" <?php echo getChecked($row->randomSlideshow, "1");?>>
              <i></i>Rastegele</label>
            <label class="radio">
              <input name="randomSlideshow" type="radio" value="0" <?php echo getChecked($row->randomSlideshow, "0");?>>
              <i></i>Sıralı</label>
          </div>
        </div>
      </div>
      <div class="wk divider"></div>
      <div class="three fields">
        <div class="field">
          <label>Slayt Kontrol Düğmeleri</label>
          <small>Slaytınızda ki düğmelerin kapalı olup olmayacağını belirler.</small>
          <div class="inline-group">
            <label class="radio">
              <input name="navButtons" type="radio" value="1" <?php echo getChecked($row->navButtons, "1");?>>
              <i></i>Evet</label>
            <label class="radio">
              <input name="navButtons" type="radio" value="0" <?php echo getChecked($row->navButtons, "0");?>>
              <i></i>Hayır</label>
          </div>
        </div>
        <div class="field">
          <label>İleri / Geri Düğmeleri</label>
          <small>'Slayt Kontrol Düğmeleri' açıksa eğer ileri ve geri tuşlarının dahil olup olmayacağını belirler.</small>
          <div class="inline-group">
            <label class="radio">
              <input name="navPrevNext" type="radio" value="1" <?php echo getChecked($row->navPrevNext, "1");?>>
              <i></i>Evet</label>
            <label class="radio">
              <input name="navPrevNext" type="radio" value="0" <?php echo getChecked($row->navPrevNext, "0");?>>
              <i></i>Hayır</label>
          </div>
        </div>
        <div class="field">
          <label>Durdur / Devam Et Düğmesi</label>
          <small>'Slayt Kontrol Düğmeleri' açıksa eğer durdur veya devam et düğmesinin dahil olup olmayacağını belirler.</small>
          <div class="inline-group">
            <label class="radio">
              <input name="navStartStop" type="radio" value="1" <?php echo getChecked($row->navStartStop, "1");?>>
              <i></i>Evet</label>
            <label class="radio">
              <input name="navStartStop" type="radio" value="0" <?php echo getChecked($row->navStartStop, "0");?>>
              <i></i>Hayır</label>
          </div>
        </div>
      </div>
      <div class="three fields">
        <div class="field">
          <label>Hover Düğmeler(Alt Düğmeler)</label>
          <small>'Slayt Kontrol Düğmeleri' açıksa eğer slaytın sayfalama düğmelerinin mouse kontrolünü yönetir.</small>
          <div class="inline-group">
            <label class="radio">
              <input name="hoverBottomNav" type="radio" value="1" <?php echo getChecked($row->hoverBottomNav, "1");?>>
              <i></i>Hover</label>
            <label class="radio">
              <input name="hoverBottomNav" type="radio" value="0" <?php echo getChecked($row->hoverBottomNav, "0");?>>
              <i></i>Statik (Sürekli Slayt Üzerinde Gösterim)</label>
          </div>
        </div>
        <div class="field">
          <label>Hover Düğmeler(İleri / Geri Düğmeleri)</label>
          <small>'Slayt Kontrol Düğmeleri' açıksa eğer slaytın ileri ve geri düğmelerinin mouse kontrolünü yönetir.</small>
          <div class="inline-group">
            <label class="radio">
              <input name="hoverPrevNext" type="radio" value="1" <?php echo getChecked($row->hoverPrevNext, "1");?>>
              <i></i>Hover</label>
            <label class="radio">
              <input name="hoverPrevNext" type="radio" value="0" <?php echo getChecked($row->hoverPrevNext, "0");?>>
              <i></i>Statik (Sürekli Slayt Üzerinde Gösterim)</label>
          </div>
        </div>
        <div class="field">
          <label>Dokunmatik Ekran Fonksyonelliği</label>
          <small>Slaytın dokunmatik ekran üzerine tutup kaydırma özelliğini etkiler.</small>
          <div class="inline-group">
            <label class="radio">
              <input name="touchNav" type="radio" value="1" <?php echo getChecked($row->touchNav, "1");?>>
              <i></i>Açık</label>
            <label class="radio">
              <input name="touchNav" type="radio" value="0" <?php echo getChecked($row->touchNav, "0");?>>
              <i></i>Kapalı</label>
          </div>
        </div>
      </div>
      <div class="wk divider"></div>
      <div class="three fields">
        <div class="field">
          <label>Slayt Geçiş Zamanlayıcısı</label>
          <small>Slaytlar arası geçiş zamanını gösteren animasyonlu göstergeyi belirler.</small>
          <div class="inline-group">
            <label class="radio">
              <input name="timeIndicator" type="radio" value="1" <?php echo getChecked($row->showBarTimer, "1");?>>
              <i></i>Çubuk Şeklinde</label>
            <label class="radio">
              <input name="timeIndicator" type="radio" value="2" <?php echo getChecked($row->showCircleTimer, "1");?>>
              <i></i>Yuvarlak Şekilde</label>
            <label class="radio">
              <input name="timeIndicator" type="radio" value="0" <?php echo getCheckedMulti($row->showBarTimer,$row->showCircleTimer, "0");?>>
              <i></i>Devre Dışı</label>
          </div>
        </div>        
        <div class="field">
          <label>Küçük Resim Navigasyonu</label>
          <small>Slayt içerisinde, slayt elementlerini sayfalandıran küçük önizleme resimlerini belirler.</small>
          <div class="inline-group">
            <label class="radio">
              <input name="thumbnailNavigation" type="radio" value="1" <?php echo getChecked($row->thumbnailNavigation, "always");?>>
              <i></i>Sürekli Göster</label>
            <label class="radio">
              <input name="thumbnailNavigation" type="radio" value="2" <?php echo getChecked($row->thumbnailNavigation, "hover");?>>
              <i></i>Hover Durumunda Göster</label>
            <label class="radio">
              <input name="thumbnailNavigation" type="radio" value="0" <?php echo getChecked($row->thumbnailNavigation, "disabled");?>>
              <i></i>Devre Dışı</label>
          </div>
        </div>
        <div class="field">
          <label>Videoları Otomatik Oynat</label>
          <small>Slayt içerisinde video eklenirse, gelen videoları otomatik oynatmaya başlamasını belirtir.</small>
          <div class="inline-group">
            <label class="radio">
              <input name="touchNav" type="radio" value="1" <?php echo getChecked($row->autoPlayVideos, "1");?>>
              <i></i>Evet</label>
            <label class="radio">
              <input name="touchNav" type="radio" value="0" <?php echo getChecked($row->autoPlayVideos, "0");?>>
              <i></i>Hayır</label>
          </div>
        </div>
      </div>
      <div class="three fields">
        <div class="field">
          <label>YouTube Videoları Önizleme Resimleri</label>
          <small>Slayt içerisine YouTube video'su embed yapıldıysa önizleme resmini seçiniz.</small>
          <div class="inline-group">
            <label class="radio">
              <input name="youtubePreview" type="radio" value="1" <?php echo getChecked($row->youtubePreview, "maxresdefault.jpg");?>>
              <i></i>En İyi Çözünürlük</label>
            <label class="radio">
              <input name="youtubePreview" type="radio" value="2" <?php echo getChecked($row->youtubePreview, "hqdefault.jpg");?>>
              <i></i>Kaliteli Çözünürlük</label>
            <label class="radio">
              <input name="youtubePreview" type="radio" value="0" <?php echo getChecked($row->youtubePreview, "mqdefault.jpg");?>>
              <i></i>Düşük Çözünürlük</label>
            <label class="radio">
              <input name="youtubePreview" type="radio" value="0" <?php echo getChecked($row->youtubePreview, "default.jpg");?>>
              <i></i>Standart</label>
          </div>
          <p>Bazı videolar standart çözünürlük dışındaki diğer çözünürlüğü desteklemiyor olabilir. Standart seçmeniz önerilir.</p>
        </div>        
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_MOD_SLC_EDIT;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=slidecms" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="editSlider" type="hidden" value="1">
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
    </form>
  </div>
  <div id="msgholder"></div>
</div>