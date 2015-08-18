<?php
  /**
   * Gogole Maps
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  if(!$user->getAcl("gmaps")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
  
  Registry::set('GMaps', new GMaps());
?>
<?php switch(Filter::$maction): case "edit": ?>
<?php $row = Core::getRowById(GMaps::mTable, Filter::$id);?>
<div class="wk icon heading message blue"> <a class="helper wk top right info corner label" data-help="gmaps"><i class="icon help"></i></a> <a class="helper wk top right info corner label" data-help="gmaps"><i class="icon help"></i></a> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_GA_TITLE4;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=gmaps" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_GM_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_GM_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_MOD_GM_SUBTITLE1 . $row->name;?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_GM_NAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->name;?>" name="name">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_GM_ZOOM_LEVEL;?></label>
          <label class="input">
            <input type="text" id="zoomlevel" value="<?php echo $row->zoom;?>" name="zoom">
          </label>
        </div>
      </div>
      <div class="field">
        <div style="position:absolute;z-index:5000;right:.5em;top:.5em">
          <div class="wk action input">
            <input placeholder="<?php echo Lang::$word->_SEARCH;?>" type="text" name="address" id="address">
            <a id="lookup" class="wk icon button"><i class="search icon"></i></a> </div>
        </div>
        <div id="map" style="width:100%;height:350px;z-index:4000"></div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_MOD_GM_EDIT;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=gmaps" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="lat" id="lat" type="hidden" value="<?php echo $row->lat;?>">
      <input name="lng" id="lng" type="hidden" value="<?php echo $row->lng;?>">
      <input name="processGMap" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3&amp;sensor=false"></script> 
<script type="text/javascript"> 
// <![CDATA[
 var map = null;
  $(document).ready(function () {
	  var geocoder;
	  geocoder = new google.maps.Geocoder();
	  var latitude = parseFloat("<?php echo $row->lat?>");
	  var longitude = parseFloat("<?php echo $row->lng?>");
	  loadMap(latitude, longitude);
	  setupMarker(latitude, longitude);

	  $('#lookup').click(function () {
		  var address = document.getElementById('address').value;
		  geocoder.geocode({
			  'address': address
		  }, function (results, status) {
			  if (status == google.maps.GeocoderStatus.OK) {
				  map.setCenter(results[0].geometry.location);
				  var image = new google.maps.MarkerImage('<?php echo SITEURL;?>/assets/pin.png');
				  var marker = new google.maps.Marker({
					  map: map,
					  draggable: true,
					  raiseOnDrag: false,
					  icon: image,
					  position: results[0].geometry.location
				  });
				  $("#lat").val(results[0].geometry.location.lat());
				  $("#lng").val(results[0].geometry.location.lng());
			  
				  google.maps.event.addListener(marker, 'dragend', function (event) {
					  $("#lat").val(this.getPosition().lat());
					  $("#lng").val(this.getPosition().lng());
				  });			  
			  } else {
                  $.sticky('Geocode was not successful for the following reason: ' + status,{type: 'error'});
			  }

		  });
	  });

	  google.maps.event.addListener(map, 'zoom_changed', function () {
		  document.getElementById('zoomlevel').value = map.getZoom();
	  });
  });
   // Loads the maps
  loadMap = function (latitude, longitude) {
	  var latlng = new google.maps.LatLng(latitude, longitude);
	  var myOptions = {
		  zoom: <?php echo $row->zoom;?> ,
		  center: latlng,
		  mapTypeControl: false,
		  mapTypeId: google.maps.MapTypeId.ROADMAP
	  };
	  map = new google.maps.Map(document.getElementById("map"), myOptions);
  }
  setupMarker = function (latitude, longitude) {
	  var pos = new google.maps.LatLng(latitude, longitude);
	  var image = new google.maps.MarkerImage('<?php echo SITEURL;?>/assets/pin.png');
	  var marker = new google.maps.Marker({
		  position: pos,
		  map: map,
          draggable: true,
          raiseOnDrag: false,
		  icon: image,
		  title: name
	  });
	  google.maps.event.addListener(marker, 'dragend', function (event) {
		  $("#lat").val(this.getPosition().lat());
		  $("#lng").val(this.getPosition().lng());
	  });
  }
</script>
<?php break;?>
<?php case"add": ?>
<div class="wk icon heading message blue"> <a class="helper wk top right info corner label" data-help="gmaps"><i class="icon help"></i></a> <a class="helper wk top right info corner label" data-help="gmaps"><i class="icon help"></i></a> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_GA_TITLE4;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=gmaps" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_GM_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_GM_INFO2. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="wk form segment">
    <div class="wk header"><?php echo Lang::$word->_MOD_GM_SUBTITLE2;?></div>
    <div class="wk double fitted divider"></div>
    <form id="wk_form" name="wk_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_GM_NAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_GM_NAME;?>" name="name">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_GM_ZOOM_LEVEL;?></label>
          <label class="input">
            <input type="text" id="zoomlevel" placeholder="<?php echo Lang::$word->_MOD_GM_ZOOM_LEVEL;?>" name="zoom">
          </label>
        </div>
      </div>
      <div class="field">
        <div style="position:absolute;z-index:5000;right:.5em;top:.5em">
          <div class="wk action input">
            <input placeholder="<?php echo Lang::$word->_SEARCH;?>" type="text" name="address" id="address">
            <a id="lookup" class="wk icon button"><i class="search icon"></i></a> </div>
        </div>
        <div id="map" style="width:100%;height:350px;z-index:4000"></div>
      </div>
      <div class="wk double fitted divider"></div>
      <button type="button" name="dosubmit" class="wk positive button"><?php echo Lang::$word->_MOD_GM_ADD;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=gmaps" class="wk basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="lat" id="lat" type="hidden">
      <input name="lng" id="lng" type="hidden">
      <input name="processGMap" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3&amp;sensor=false"></script> 
<script type="text/javascript"> 
// <![CDATA[
 var map = null;
  $(document).ready(function () {
	  var geocoder;
	  geocoder = new google.maps.Geocoder();
	  var latitude = 43.652527;
	  var longitude = -79.381961;
	  loadMap(latitude, longitude);

	  $('#lookup').click(function () {
		  var address = document.getElementById('address').value;
		  geocoder.geocode({
			  'address': address
		  }, function (results, status) {
			  if (status == google.maps.GeocoderStatus.OK) {
				  map.setCenter(results[0].geometry.location);
				  var image = new google.maps.MarkerImage('<?php echo SITEURL;?>/assets/pin.png');
				  var marker = new google.maps.Marker({
					  map: map,
					  draggable: true,
					  raiseOnDrag: false,
					  icon: image,
					  position: results[0].geometry.location
				  });
				  $("#lat").val(results[0].geometry.location.lat());
				  $("#lng").val(results[0].geometry.location.lng());
			  
				  google.maps.event.addListener(marker, 'dragend', function (event) {
					  $("#lat").val(this.getPosition().lat());
					  $("#lng").val(this.getPosition().lng());
				  });			  
			  } else {
				  alert('Geocode was not successful for the following reason: ' + status);
			  }

		  });
	  });

	  google.maps.event.addListener(map, 'zoom_changed', function () {
		  document.getElementById('zoomlevel').value = map.getZoom();
	  });
  });
   // Loads the maps
  loadMap = function (latitude, longitude) {
	  var latlng = new google.maps.LatLng(latitude, longitude);
	  var myOptions = {
		  zoom: 13,
		  center: latlng,
		  mapTypeControl: false,
		  mapTypeId: google.maps.MapTypeId.ROADMAP
	  };
	  map = new google.maps.Map(document.getElementById("map"), myOptions);
  }
// ]]>
</script>
<?php break;?>
<?php default: ?>
<?php $gmrow = Registry::get("GMaps")->getGMaps();?>
<div class="wk icon heading message blue"> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_GM_TITLE4;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo $content->getModuleName(Filter::$modname);?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_GM_INFO4;?></div>
  <div class="wk segment"> <a class="wk icon warning button push-right" href="<?php echo Core::url("modules", "add");?>"><i class="icon add"></i> <?php echo Lang::$word->_MOD_GM_ADD;?></a>
    <div class="wk header"><?php echo Lang::$word->_MOD_GM_SUBTITLE3;?></div>
    <div class="wk fitted divider"></div>
    <table class="wk sortable table">
      <thead>
        <tr>
          <th data-sort="int">#</th>
          <th data-sort="string"><?php echo Lang::$word->_MOD_GM_NAME;?></th>
          <th data-sort="int"><?php echo Lang::$word->_MOD_GM_LAT;?></th>
          <th data-sort="int"><?php echo Lang::$word->_MOD_GM_LNG;?></th>
          <th data-sort="int"><?php echo Lang::$word->_MOD_GM_ZOOM_LEVEL;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$gmrow):?>
        <tr>
          <td colspan="6"><?php Filter::msgSingleInfo(Lang::$word->_MOD_GM_NOGMAPS);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($gmrow as $row):?>
        <tr>
          <td><?php echo $row->id;?>.</td>
          <td><?php echo $row->name;?></td>
          <td><?php echo $row->lat;?></td>
          <td><?php echo $row->lng;?></td>
          <td><?php echo $row->zoom;?></td>
          <td><a href="<?php echo Core::url("modules", "edit", $row->id);?>"><i class="rounded inverted success icon pencil link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_MOD_GM_GMAP;?>" data-option="deleteGMap" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->name;?>"><i class="rounded danger inverted remove icon link"></i></a></td>
        </tr>
        <?php endforeach;?>
        <?php unset($row);?>
        <?php endif;?>
      </tbody>
    </table>
  </div>
</div>
<?php break;?>
<?php endswitch;?>