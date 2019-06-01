<!DOCTYPE html>
<html>
<head>
      <title>Track Me</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

      <!-- <link rel="stylesheet" type="text/css" href="index.css"> -->
</head>
<script type="text/javascript">
      const markersArray = [];
      var map;
      var latStation;
      var lngStation;
      var stationName;
      var marker;


      function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                  zoom: 12,
                  center: {lat:41.3275 , lng:19.8187}
            });

            const urlParams = new URLSearchParams(window.location.search);
            const bus = urlParams.get('bus');
           
            $.ajax({
                  url: "index.php?controller=bus&action=getBusName",
                  method: "POST",
                  data: {bus: bus},
                  success: function (response) {
                        response = JSON.parse(response);

                        for (var i = 0; i < response.length; i++) {
                               // console.log(response[i]["station_name"]);

                              var latStation = parseFloat(response[i]["station_lat"]);
                              var lngStation = parseFloat(response[i]["station_lng"]);

                              marker = new google.maps.Marker({
                                    position: {lat: latStation ,lng: lngStation },
                                    map: map,
                                    title: response[i]["station_name"]
                              });
                              markersArray.push(marker);

                              var select = document.getElementById("sel1");
                              
                              select.options[select.options.length] = new Option(response[i]["station_name"], response[i]["stationsid"]);
                        }
                  }    
            });

      }
   

      function getLiveBusses(){
            var e = document.getElementById("sel1");
            var station = e.options[e.selectedIndex].value;
            var directionsService = new google.maps.DirectionsService;
            var directionsDisplay = new google.maps.DirectionsRenderer;
            directionsDisplay.setMap(map);
            const urlParams = new URLSearchParams(window.location.search);
            const bus = urlParams.get('bus');
            deleteMarkers(markersArray);

            $.ajax({
                  url: "index.php?controller=bus&action=getStationNameForSelect",
                  method: "POST",
                  data: {station: station,
                         bus: bus},
                  success: function (response) {

                        response = JSON.parse(response);
                        console.log(response);
                        var latStation = parseFloat(response["stationName"]["station_lat"]);
                        var lngStation = parseFloat(response["stationName"]["station_lng"]);

                        var marker = new google.maps.Marker({
                                    position: {lat: latStation ,lng: lngStation },
                                    map: map,
                                    title: response["stationName"]["station_name"],
                                    icon: "https://img.icons8.com/ios/40/000000/street-view-filled.png"
                        });
                        markersArray.push(marker);
                        var latLocation;
                        var lngLocation;
                        for (var i = 0; i < response["liveBusses"].length; i++) {
                              // console.log(response["liveBusses"][i]["currentLatBus"]);
                              latLocation = parseFloat(response["liveBusses"][i]["currentLatBus"]);
                              lngLocation = parseFloat(response["liveBusses"][i]["currentLngBus"]);
                              stationName = response["stationName"]["station_name"];
                              console.log(latLocation);
                              console.log(lngStation);
                              
                              var lat_lng = [];
                              for (var j = 0; j < response["station"][i].length; j++) {
                                  lat_lng[j] = new google.maps.LatLng(parseFloat(response["station"][i][j]["station_lat"]),parseFloat(response["station"][i][j]["station_lng"]));
                              }
                              
                              var origin = parseFloat(response["liveBusses"][i]["currentLatBus"]) + "," + parseFloat(response["liveBusses"][i]["currentLngBus"]);
                              var destination = latStation + "," + lngStation;
                             
                              var waypoints = lat_lng;

                              calculateAndDisplayRoute(directionsService, directionsDisplay, waypoints, origin, destination, function (time,origin){
                                    
                                    var latlng = origin.split(",");
                                    
                                    marker = new google.maps.Marker({
                                          position: {lat: parseFloat(latlng[0]), lng: parseFloat(latlng[1])},
                                          map: map,
                                          title: "Autobusi do te mberrije ne stacionin e zgjedhur per " + time*2.5 + "min",
                                          icon: "https://img.icons8.com/android/24/000000/bus.png"
                                    });
                                   
                                    markersArray.push(marker);

                              });
                        
                        }
                 }
                     
            });

      }


      function calculateAndDisplayRoute(directionsService, directionsDisplay, waypoints, origin1, destination1, getTime) {
            var waypts = [];
            // debugger;
            for (var i = 0; i < waypoints.length; i++) {
                  waypts.push({
                    location: waypoints[i],
                    stopover: true
                  });
            }
            
           directionsService.route({
                  origin: origin1,
                  destination: destination1,
                  waypoints: waypts,
                  optimizeWaypoints: true,
                  travelMode: 'DRIVING'
            }, function(response, status) {
                  if (status === 'OK') {
                        directionsDisplay.setDirections(response);
                        directionsDisplay.setOptions( { suppressMarkers: true,
                        polylineOptions: {
                              strokeWeight: 0,
                              strokeOpacity: 0,
                              strokeColor:  'white' 
                          } } );
                        var route = response.routes[0];
                        // For each route, display summary information.
                        time = 0;
                        for (var i = 0; i < route.legs.length; i++) {
                              // var routeSegment = i + 1;
                              time += parseFloat(route.legs[i].duration.text.replace( /^\D+/g, ''));      
                        }
                        // console.log(time);
                        getTime(time, origin1);
                  } else {
                        window.alert('Directions request failed due to ' + status);
                  }
                   
                  
            }); 
            
      }

      

      function deleteMarkers($markers){
            for (var i = 0; i < markersArray.length; i++ ) {
                markersArray[i].setMap(null);
            }
            markersArray.length = 0;
      }






</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcB-7SD7ftL0VP4HcA0m_5voSjlGs_iuk&callback=initMap"
async defer></script>

<style type="text/css">


      html{
            margin: 0;
      }
      body{
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            overflow-x: hidden;
      }

      .font-weight-light {
            font-size: 30px;
            margin-top: 50px;

      }

      .c1{
            /*  padding-right: 30px; */
            padding-left: 0;
            padding-right:0;
            height: 100vh;
      }
      .c2{
            background-color: #66bb6a;
            padding-right: 30px;
            padding-left: 30px;

      }
      .col0{
            margin-top: 50px;
      }
      .r1{
            margin-top: 50px;
            justify-content: center;
      }
      .btn{
            margin: 5px 0px 5px 0px;
            width: 100%;
      }
      .r2{
            justify-content: center;
            align-items: center;
      }

      .btn_last{
            margin-top: 200px;
            margin-bottom: 160px;
            width: 100%;
            align-items: center;
            font-size: 22px; 
      }
      .btn_last.btn-outline-light:hover {
            color: #66bb6a;
            background-color: #ffffff;
            border-color: #66bb6a;
      }

      @media (min-width: 768px){
            .col-md-6 {
                  -ms-flex: 0 0 50%;
                  flex: 0 0 50%;
                  max-width: 100%;
            }
      }
      .r3{ 
            justify-content: center;
            align-items: center;

      }

      .r4{
            display: flex;
            justify-content: space-between;
            position: relative;
            padding-left: 0;
            padding-right:0;

      }


      .txt_1{
            color: #1565c0;
      }

      .col1{
            margin-top: 20%;
            align-items: center;
      }

      .btn_blu{
            background-color: #2196f3;
            height: 50px;
            font-size: 22px;
            width: 100%;
      }

      .btn_blu.btn-outline-light:hover {
            color: #2196f3;
            background-color: #ffffff;
            border-color: #2196f3;
      }


      .form-control,
      .form-control:focus {
            color:#868686 ;
      }


      .modal-title.text-center{
            color:#2196f3;
      }

      .txt_11{
            font-size: 22px;
            color: #1565c0;

      } 



      /* second-file */
      .jumbotron{
            background-color: #2196f3;
            color: white;
      }

      .con_1{
            padding-right: 0;
            padding-left: 0;
      }

      .txt_2{
            font-size: 20px;
      }

      .txt_3{
            font-weight: 600;
            font-size: 22px;

      }




      @media (max-width: 768px){
            .hidden-sm-down {
                  display: none;
            }
      }
      .map_container{
            margin: 0;
            padding: 0;
      }
      .map_btn_cont{
            position: absolute;
            margin-left: 75%;
            margin-top: 10px;

      }

      .map_button{
            width: auto;
            padding: 0 22px;
      }

      .btn_back{
            position: absolute;
            margin-left: 20px;
            margin-top: 10px;
      }

      @media (max-width: 600px){
            .map_btn_cont {
                  margin-left: 150px;
            }
      }


      /* Safari */
      @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
      }

      @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
      }
</style>
<body>

      <div class="container-fluid con_1">
            <div class="jumbotron">
                  <div class="container">
                        <div class="row">
                              <div class="col-sm-12 col-md-4 col-lg-4 text-left">
                                    <a href="index.php?controller=user&action=home">
                                          <img src="view/user/images/left-arrow.png" width="50px">
                                    </a>
                              </div>
                              <div class="col-sm-12 col-md-4 col-lg-4 text-right txt_2">
                                    <span class="txt_3" id="stationOne"></span>
                              </div>
                              <div class="col-sm-12 col-md-4 col-lg-4 text-right txt_2">
                               <span class="txt_3" id="stationTwo"></span>
                         </div>
                   </div>
             </div>
       </div>
       <div class="container-fluid">
            <div class="row">
                  <div class="col-sm-12 col-md-4 col-lg-4 ">

                        <div class="loader" id ="loader">

                             <div class="modal-body">
                                 <div class="form-group">
                                     <label for="sel1" class="txt_11">Zgjidh stacionin:</label>
                                     <select class="form-control" id="sel1">
                                   </select>
                             </div>
                       </div>
                       <div class="modal-footer">
                           <button type="button" class="btn btn-outline-success btn-light " data-dismiss="modal" onclick="getLiveBusses()">Kerko</button>
                     </div>
               </div>
               <div id = "requiredBus" ></div>
               <br>
               <div class="float-left hidden-sm-down">
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>

                  <!-- <img src="view/user/images/Group31.png" width="300px"> -->
            </div>
      </div>
      <div class="col-sm-12 col-md-8 col-lg-8" id="map">
            <!-- <button class="btn btn-outline-light btn-success btn_hart" > Shiko ne Harte.</button> -->
            <!-- <div id="map"></div> -->
      </div>
</div>
</div>
</div>
</body>
</html>





