<script type="text/javascript">
function isMyScriptLoaded(url) {
    scripts = document.getElementsByTagName('script');
    for (var i = scripts.length; i--;) {
        if (scripts[i].src == url) return true;
    }
    return false;
}

function loadScript() {
    if (!isMyScriptLoaded('http://maps.google.com/maps/api/js?sensor=false')) {
        document.write('<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"><\/script>');
    }
}

function whenAvailable(name, name2, name3, callback) {
    var interval = 100; // ms
    window.setTimeout(function () {
        if (window[name]) {
            if (window[name][name2])
                if (window[name][name2][name3])
                    callback(window[name]);
                else
                    window.setTimeout(arguments.callee, interval);
                else
                    window.setTimeout(arguments.callee, interval);
        } else {
            window.setTimeout(arguments.callee, interval);
        }
    }, interval);
}
</script>
<?php
  $id = intval('###GMAPSID###');
  $grow = $db->first('SELECT * FROM mod_gmaps WHERE id = ' . $id);
?>
<div id="gmap_<?php echo $id?>" style="width:100%;height:300px"></div>
<script type="text/javascript">
//<![CDATA[
	loadScript();
	whenAvailable("google", "maps", "MapTypeId", function () {
	    init_gmap_<?php echo $id;?> ();
	});

	function init_gmap_<?php echo $id;?> () {
	    var mapOptions = {
	        zoom: <?php echo $grow->zoom;?> ,
	        mapTypeId: google.maps.MapTypeId.ROADMAP,
	        center: new google.maps.LatLng( <?php echo $grow->lat;?> , <?php echo $grow->lng;?> ),

	    };
	    map = new google.maps.Map(document.getElementById('gmap_<?php echo $id;?>'), mapOptions);
		var image = new google.maps.MarkerImage(SITEURL + '/assets/pin.png');
	    var marker = new google.maps.Marker({
	        position: new google.maps.LatLng( <?php echo $grow->lat;?> , <?php echo $grow->lng;?> ),
	        map: map,
			icon: image,
	        title: '<?php echo $grow->name?>'
	    });
	};
//]]>
</script>