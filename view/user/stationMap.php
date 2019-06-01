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

	function initMap() {
		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 12,
			center: {lat:41.3275 , lng:19.8187}
		});
		var geocoder = new google.maps.Geocoder();
		geocodeAddress(geocoder, map)
	}

	function geocodeAddress(geocoder, resultsMap) {
		const urlParams = new URLSearchParams(window.location.search);
		const address = urlParams.get('address');
		const userLat = parseFloat(urlParams.get('lat'));
		const userLng = parseFloat(urlParams.get('lng'));

	geocoder.geocode({'address': address}, function(results, status) {
		if (status === 'OK') {
			$.ajax({
				url: "index.php?controller=user&action=findStation",
				method: "POST",
				data: {userLat: userLat,
					userLng:userLng,
					destLat: results[0].geometry.location.lat(),
					destLng: results[0].geometry.location.lng()},
					success: function (response) {
							response = JSON.parse(response);
							// console.log(response["bus"]);
						if(response["bus"].length == 0){
							document.getElementById("loader").style.display = "none";
							document.getElementById("requiredBus").innerHTML = "ERROR";
						}else{

							document.getElementById("loader").style.display = "none";
							console.log(parseFloat(response["userLat"]));
							document.getElementById("stationOne").innerHTML = response["stations"]["sUser"];
							document.getElementById("stationTwo").innerHTML = response["stations"]["sDest"];

							document.getElementById("requiredBus").innerHTML = "Per te shkuar ne destinacionin e kerkuar duhet te merrni urbanin e linjes : " + response["bus"]["busname"] + " ne stacionin tuaj me te afert : " + response["stations"]["sUser"]+". Mberritja do te behet ne stacionin " +  response["stations"]["sDest"] + "." + " </br> Udhetimi do te zgjas " + response["time"]*2.5 + ".";

							var latu = parseFloat(response["userLat"]);
							var lngu = parseFloat(response["userLng"]);
							var marker = new google.maps.Marker({
								position: {lat: latu,lng: lngu},
								map: resultsMap,
								title: response["stations"]["sUser"]
							});
							var latd = parseFloat(response["destLat"]);
							var lngd = parseFloat(response["destLng"]);
							var marker = new google.maps.Marker({
								position: {lat: latd,lng: lngd},
								map: resultsMap,
								title: response["stations"]["sDest"]
							});
						}
						
					}
			});

		resultsMap.setCenter(results[0].geometry.location);
	} else {
		alert('Geocode was not successful for the following reason: ' + status);
	}
});
	}

	function calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB) {
		directionsService.route({
			origin: pointA,
			destination: pointB,
			travelMode: google.maps.TravelMode.DRIVING
		}, function(response, status) {
			if (status == google.maps.DirectionsStatus.OK) {
				directionsDisplay.setDirections(response);
			} else {
				window.alert('Directions request failed due to ' + status);
			}
		});
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
	.loader {
		border: 16px solid #f3f3f3;
		border-radius: 50%;
		border-top: 16px solid #3498db;
		width: 120px;
		height: 120px;
		-webkit-animation: spin 2s linear infinite; /* Safari */
		animation: spin 2s linear infinite;
		margin-left: 30%;
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
						Nga: <span class="txt_3" id="stationOne"></span>
					</div>
					<div class="col-sm-12 col-md-4 col-lg-4 text-right txt_2">
						Ne: <span class="txt_3" id="stationTwo"></span>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12 col-md-4 col-lg-4 ">
					<!-- <button class="btn btn-outline-success btn-light" id = "requiredBus"> Unaza</button> -->
					<div class="loader" id ="loader"></div>
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
						<img src="view/user/images/Group31.png" width="300px">
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





