<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title></title>
     <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcB-7SD7ftL0VP4HcA0m_5voSjlGs_iuk&callback=initMap"
async defer></script>
    <style>
      #map {
        height:400%;
        width: 100%;
      }
      
      html, body {
        height: 50%;
        margin: 0;
        padding: 0;
      }
     
    </style>
  </head>
  <body>
    <div id="map"></div>
  
    <script>
     
      function initMap() {

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: {lat: 41.339668, lng: 19.829238}
        });

        setMarkers(map);
      }
      var stations = [
        ['Station1','STACIONI TRENIT', 'TIRANA, BULEVARDI ZOGU I',41.334436,19.816902],
        ['Station2', 'ARKIVI','TIRANA, RRUGA ASIM VOKSHI',41.335281,19.811513],
        ['Station3', 'ISH POLITEKNIKIUMI','TIRANA, RRUGA ASIM VOKSHI',41.334665,19.807447],
        ['Station4', 'ZOGU ZI','TIRANA, RRUGA DRITAN HOXHA', 41.334017,19.801967],
        ['Station5','PALLATI SPORTIT', 'TIRANA, RRUGA DRITAN HOXHA',41.334798,19.800272],
        ['Station6', 'LAPRAKE','TIRANA, RRUGA DRITAN HOXHA',41.3374,19.792182],
        ['Station7', 'DOGANA','TIRANA, RRUGA DRITAN HOXHA',41.339623,19.786013],
        ['Station8', 'JETOIL','TIRANA, RRUGA TEODOR KEKO',41.338064,19.785149],
        ['Station9', 'URES MBI LANE','TIRANA, RRUGA TEODOR KEKO',41.331503,19.783851],
        ['Station10','FABRIKA E MIELLIT','TIRANA, RRUGA TEODOR KEKO',41.32203,19.789156],
        ['Station11', 'PALLATI ME SHIGJETA','TIRANA, BULEVARDI BAJRAM CURRI',41.320976,19.793184],
        ['Station12', 'ISH PARKU AUTOBUSAVE','TIRANA, BULEVARDI BAJRAM CURRI',41.32036,19.799772],
        ['Station13', 'URA VASIL SHANTO','TIRANA, BULEVARDI BAJRAM CURRI',41.320787,19.805501],
        ['Station14', 'STADIUMI DINAMO','TIRANA, RRUGA SULEJMAN DELVINA',41.317737,19.811129],
        ['Station15', 'SHESHI WILLSON','TIRANA, RRUGA ABDYL FRASHERI',41.318685,19.815017],
        ['Station16', 'LIBRI UNIVERSITARE','TIRANA, RRUGA ABDYL FRASHERI',41.319114,19.818167],
        ['Station17','SHESHI NENE TEREZA', 'TIRANA, BULEVARDI DESHMORET E KOMBIT',41.317942,19.821799],
        ['Station18', 'PIRAMIDA','TIRANA, BULEVARDI DESHMORET E KOMBIT',41.322775,19.819994],
        ['Station19', '15 KATESHI','TIRANA, BULEVARDI ZOGU I',41.329832,19.818088],
      ];

      function setMarkers(map) {
        var image = {
          url: 'https://chart.apis.google.com/chart?chst=d_map_pin_icon&chld=bus|FF0000',
         
          size: new google.maps.Size(20, 32),
          
          origin: new google.maps.Point(0, 0),
        
          anchor: new google.maps.Point(0, 32)
        };
        
        var shape = {
          coords: [1, 1, 1, 20, 18, 20, 18, 1],
          type: 'poly'
        };
        for (var i = 0; i < stations.length; i++) {
          var station = stations[i];
          var marker = new google.maps.Marker({
            position: {lat: station[3], lng: station[4]},
            map: map,
            icon: image,
            shape: shape,
            title: station[1]
          });
        }
      }
    
    </script>

  </body>
</html>