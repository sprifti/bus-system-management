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
		require_once('view/user/tirana_re.php');
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
			//var_dump($result); die;
			//$dist = $this->GetDrivingDistance($userLat, $destLat, $userLng, $destLng);
		$minDistUser = 9999; $latUser = 0; $lngUser = 0;  $minDistDest = 9999; $latDest = 0; $lngDest = 0;  
		
		$client = new Client();


		$requests = function ($total, $userLat, $userLng) {
		    foreach($total as $item){
		    	// echo "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$userLat.",".$item["station_lat"]."&destinations=".$userLng.",".$item["station_lng"]."&mode=driving&language=al-AL&key=AIzaSyBcB-7SD7ftL0VP4HcA0m_5voSjlGs_iuk";
				yield new Request('GET', "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$userLat.",".$item["station_lat"]."&destinations=".$userLng.",".$item["station_lng"]."&mode=driving&language=al-AL&key=AIzaSyBcB-7SD7ftL0VP4HcA0m_5voSjlGs_iuk");
			}
		   
		};

		$responses = Pool::batch($client, $requests($result, $userLat,$userLng), ['concurrency' => 5]); 
		// $responses = json_decode($responses, true);
		foreach ($responses as $i => $response) {
			// $response = json_decode($response, true);
			print_r($response->getBody()->getContents());
		}

		
		// return Pool::batch($client, $requests($result, $userLat,$userLng), ['concurrency' => 5]);
			// $pool = new Pool($client, $requests($result, $userLat,$userLng), [
			// 	'concurrency' => 5,
			// 	'fulfilled' => function ($response, $index) {
			// 		// $contents = (string) $response->getBody();
			// 	 //    return $contents;
			// },
			// 'rejected' => function ($reason, $index) {
			//     // this is delivered each failed request
			// },
			// ]);

			// Initiate the transfers and create a promise
			// $promise = $pool->promise();


			// // Force the pool of requests to complete.
			// $results = $promise->wait();
			// print_r($pool); die("ok");

			// $client = new Client();

			// $requests = function ($total, $userLat, $userLng) use ($client) {
			   
			//     foreach($total as $item){
			//     	$uri = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$userLat.",".$item["station_lat"]."&destinations=".$userLng.",".$item["station_lng"]."&mode=driving&language=al-AL&key=AIzaSyBcB-7SD7ftL0VP4HcA0m_5voSjlGs_iuk";
			//     	yield function() use ($client, $uri) {
			//             return $client->getAsync($uri);
			//         };
			// 	}
			// };

			// $pool = new Pool($client, $requests($result, $userLat, $userLng));
			// print_r($pool); die;

		// foreach($result as $item){
		// 	yield new Request('GET', "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&language=al-AL&key=AIzaSyBcB-7SD7ftL0VP4HcA0m_5voSjlGs_iuk");

		// 	$dist = $this->GetDrivingDistance($userLat, $item["station_lat"], $userLng, $item["station_lng"]); 
		// 		//echo ($dist[distance]." ". $item["station_lat"]." ".$item["station_lng"]);	
		// 	$strUser = (float)filter_var($dist['distance'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );	
		// 	if($minDistUser > $strUser){
		// 		$latUser = $item["station_lat"];
		// 		$lngUser = $item["station_lng"];
		// 		$minDistUser = $strUser;
		// 	}

		// 	$distLoc = $this->GetDrivingDistance($destLat, $item["station_lat"], $destLng, $item["station_lng"]); 
		// 		//echo ($dist[distance]." ". $item["station_lat"]." ".$item["station_lng"]);	
		// 	$strDest = (float)filter_var($distLoc['distance'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );	
		// 	if($minDistDest > $strDest){
		// 		$latDest = $item["station_lat"];
		// 		$lngDest = $item["station_lng"];
		// 		$minDistDest = $strDest;
		// 	}
		// }

	// 	$result = User::findStation($latUser,$lngUser,$latDest,$lngDest);
	// 	$bus = User::findBus($result["sUser"],$result["sDest"]);
	// 	$stationCalculate = $this->GetDrivingDistance($latDest, $latUser, $lngDest, $lngUser);

	// 	$value = [ "stations" => $result,
	// 	"bus" => $bus,
	// 	"time" => $stationCalculate["time"],
	// 	"distance" => $stationCalculate["distance"],
	// 	"userLat" => $latUser,
	// 	"userLng" => $lngUser,
	// 	"destLat" => $latDest,
	// 	"destLng" => $lngDest	
	// ];

	
	// 	echo json_encode($value);	

    			//echo 'Distance: <b>'.$dist['distance'].'</b><br>Travel time duration: <b>'.$dist['time'].'</b>';


}

function GetDrivingDistance($lat1, $lat2, $long1, $long2){
	$url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&language=al-AL&key=AIzaSyBcB-7SD7ftL0VP4HcA0m_5voSjlGs_iuk";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$response = curl_exec($ch);
	curl_close($ch);
	$response_a = json_decode($response, true);

	$dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
	$time = $response_a['rows'][0]['elements'][0]['duration']['text'];
	
	return array('distance' => $dist, 'time' => $time);
}
}

?>