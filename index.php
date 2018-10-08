<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>
       
      function initMap() {

      	var options = {
      		center: {lat:41.1533 , lng:20.1683 },
          	zoom: 8,
          	minzoom: 9,
          	maxzoom: 10
      	}

      	var map = new google.maps.Map(document.getElementById('map'), options);

		addMarker({lat: 40.7275, lng:19.5628});
		addMarker({lat: 40.9420, lng:19.6996});

      	function addMarker(coords){
      		var marker = new google.maps.Marker({
       		position: coords, 
       		map:map,
			icon: 'https://mapicons.mapsmarker.com/wp-content/uploads/mapicons/shape-default/color-128e4d/shapecolor-color/shadow-1/border-dark/symbolstyle-white/symbolshadowstyle-dark/gradient-no/animal-shelter-export.png'
       		
      	 });
      		
      		google.maps.event.addListener(marker,'click',function(e){ 
      			alert('click');
      			console.log(e);
        	})

      	}
        
        
       


    }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARvLgntb7ww8Fo5B82QZDa55wnqhtGAro&callback=initMap"
    async defer></script>
  </body>
</html>