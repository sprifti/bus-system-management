<?php
use GuzzleHttp\Pool;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
class UserController{

	public function home(){
		
		require_once('view/user/home.php');
	}

	public function saveUserLocation(){
		if(isset($_POST['lat'])){
			$lat = $_POST['lat'];
		}

		if(isset($_POST['lng'])){
			$lng = $_POST['lng'];
		}

		if(isset($_POST['add'])){
			$add = $_POST['add'];
		}
		echo $lat.$lng.$add;
			// header('location: index.php?controller=user&action=showMap');

			// $result = User::findStation($lat,$lng); 
			// echo $result;
	}

	public function tiranaERe(){
		
		require_once('view/user/tirana_re.php');
	}

	public function showMap(){

			// header('location: view/user/stationMap.php');
		require_once('view/user/stationMap.php');
	}

	public function busMap(){

			// header('location: view/user/stationMap.php');
		require_once('view/user/busMap.php');
	}

	public function findStation(){

		if(isset($_POST['userLat'])){
			$userLat = (float)$_POST['userLat'];
		}

		if(isset($_POST['userLng'])){
			$userLng = (float)$_POST['userLng'];
		}

		if(isset($_POST['destLat'])){
			$destLat = (float)$_POST['destLat'];
		}

		if(isset($_POST['destLng'])){
			$destLng = (float)$_POST['destLng'];
		}


		$result = User::findClosestStation();
		
		//searches for the nearest bus station using user's location 
		$client = new Client();
		$requests = function ($total, $userLat, $userLng) {
			foreach($total as $item){
				yield new Request('GET', "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$userLat.",".$userLng."&destinations=".$item["station_lat"].",".$item["station_lng"]."&mode=driving&language=al-AL&key=AIzaSyBcB-7SD7ftL0VP4HcA0m_5voSjlGs_iuk");
			}
			
		};
		$distances = [];
		$responses = Pool::batch($client, $requests($result, $userLat,$userLng), ['concurrency' => 5]); 
		// $responses = json_decode($responses, true);
		foreach ($responses as $i => $response) {
			$content = json_decode($response->getBody()->getContents(),true);
			$distanceResult = explode(" ",$content["rows"][0]["elements"][0]["distance"]["text"]);
			if($distanceResult[1] == "km"){
				$distance = $distanceResult[0]*1000;
			}else{
				$distance = $distanceResult[0];
			}
			// $distance = (float)filter_var($content["rows"][0]["elements"][0]["distance"]["text"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
			$distances[] = $distance;
		}
		
		$originStation = $result[array_search(min($distances), $distances)]["station_name"];
		$userStationLat =  $result[array_search(min($distances), $distances)]["station_lat"];
		$userStationLng =  $result[array_search(min($distances), $distances)]["station_lng"];

		// print_r($originStation);
		// print_r($userStationLat);
		// print_r($userStationLng);

		//searches for the nearest bus station using destination that the user is looking for
		$client = new Client();
		$requests = function ($total, $destLat, $destLng) {
			foreach($total as $item){
				yield new Request('GET', "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$destLat.",".$destLng."&destinations=".$item["station_lat"].",".$item["station_lng"]."&mode=driving&language=al-AL&key=AIzaSyBcB-7SD7ftL0VP4HcA0m_5voSjlGs_iuk");
			}
			
		};
		$distances = [];
		$responses = Pool::batch($client, $requests($result, $destLat,$destLng), ['concurrency' => 5]); 
		// $responses = json_decode($responses, true);
		foreach ($responses as $i => $response) {
			$content = json_decode($response->getBody()->getContents(),true);
			// print_r($content);
			$distanceResult = explode(" ",$content["rows"][0]["elements"][0]["distance"]["text"]);
			if($distanceResult[1] == "km"){
				$distance = $distanceResult[0]*1000;
			}else{
				$distance = $distanceResult[0];
			}

			$distances[] = $distance;
		}
		$destinationStation = $result[array_search(min($distances), $distances)]["station_name"];
		$destStationLat =  $result[array_search(min($distances), $distances)]["station_lat"];
		$destStationLng =  $result[array_search(min($distances), $distances)]["station_lng"];

		// print_r($destinationStation);
		// print_r($destStationLat);
		// print_r($destStationLng);

		$bus = User::findBus($originStation,$destinationStation);
		if($bus == "Error"){
			$busName["busname"] = "Error";
		}else{
			$busName = $bus;
		}
		// print_r($bus);

		$client = new GuzzleHttp\Client();

		$res = $client->request('GET', "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$userStationLat.",".$userStationLng."&destinations=".$destStationLat.",".$destStationLng."&mode=driving&language=al-AL&key=AIzaSyBcB-7SD7ftL0VP4HcA0m_5voSjlGs_iuk");

		$content = json_decode($res->getBody()->getContents(),true);
	
		$stations = ["sUser"=> $originStation,
	     			 "sDest"=> $destinationStation];

	    // $points = User::findThreePoints($originStation,$destinationStation,$busName);



		$value = [  "stations" => $stations,
					"bus" => $busName,
					"time" => $content["rows"][0]["elements"][0]["duration"]["text"],
					"distance" => $content["rows"][0]["elements"][0]["distance"]["text"],
					"userLat" => $userStationLat,
					"userLng" => $userStationLng,
					"destLat" => $destStationLat,
					"destLng" => $destStationLng	
				];

		
		echo json_encode($value);	


	}

}

?>