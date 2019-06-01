<?php
require "/ProgramData/ComposerSetup/bin/vendor/autoload.php";
	use GuzzleHttp\Pool;
	use GuzzleHttp\Client;
	use GuzzleHttp\Psr7\Request;
	class Bus{

		public function __construct(){}

		public function getBusses($bus){
			$db = Db::getInstance();
			$result = $db->prepare("SELECT * FROM `busses` WHERE bus_name = :bus ");
				
			$result->execute(array('bus' => $bus));

			$busses = $result->fetch();

			$result = $db->prepare("SELECT stationsid,station_name, station_lat, station_lng FROM `bus_station` inner join stations on stationsid = stationid WHERE busid = :bus");
				
			$result->execute(array('bus' => $busses["busid"]));

			$stations = $result->fetchAll();
			
			return $stations;
		}


		public function getStationName($station,$bus){
			$busInfo = [];
			$db = Db::getInstance();

			$result = $db->prepare("SELECT * FROM `stations` where stationsid = :stationsid");
			$result->execute(array('stationsid' => $station));
			$stationName = $result->fetch();

			
			$result = $db->prepare("SELECT stationsid,station_name, station_lat, station_lng FROM `bus_station` inner join stations on stationsid = stationid INNER JOIN busses on bus_station.busid = busses.busid WHERE bus_name = :bus");
				
			$result->execute(array('bus' => $bus));

			$stations = $result->fetchAll();


			$result = $db->prepare("SELECT * FROM `bus_location` INNER JOIN busses on busses.busid = bus_location.busid where bus_name = :bus");
			$result->execute(array('bus' => $bus));
			$liveBusses = $result->fetchAll();
			// print_r($liveBusses); die;
			$client = new Client();
			foreach ($liveBusses as $key => $busses) {
				
				$requests = function ($total, $userLat, $userLng) {
					foreach($total as $item){
						yield new Request('GET', "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$userLat.",".$userLng."&destinations=".$item["station_lat"].",".$item["station_lng"]."&mode=driving&language=al-AL&key=AIzaSyBcB-7SD7ftL0VP4HcA0m_5voSjlGs_iuk");
					}
					
				};
				$distances = [];
				$responses = Pool::batch($client, $requests($stations, $busses["currentLatBus"],$busses["currentLngBus"]), ['concurrency' => 5]); 

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
				
				$stationid = $stations[array_search(min($distances), $distances)]["stationsid"];
				$originStation = $stations[array_search(min($distances), $distances)]["station_name"];
				$userStationLat =  $stations[array_search(min($distances), $distances)]["station_lat"];
				$userStationLng =  $stations[array_search(min($distances), $distances)]["station_lng"];

				// print_r($originStation);
				// print_r($userStationLat);
				// print_r($userStationLng); 

				if($station < $stationid){

					$result = $db->prepare("SELECT stationsid,station_name, station_lat, station_lng FROM `bus_station` inner join stations on stationsid = stationid INNER JOIN busses on bus_station.busid = busses.busid WHERE stationsid BETWEEN :origin AND :dest ");

					$result->execute(array('origin' => $stationid, 'dest' => $stations[count($stations)-1]["stationsid"]));

					$stations1 = $result->fetchAll();

					$result = $db->prepare("SELECT stationsid,station_name, station_lat, station_lng FROM `bus_station` inner join stations on stationsid = stationid INNER JOIN busses on bus_station.busid = busses.busid WHERE stationsid BETWEEN :origin AND :dest ");

					$result->execute(array('origin' => $stations[0]["stationsid"], 'dest' => $stationName["stationsid"]));

					$stations2 = $result->fetchAll();
					$stations = [];
					$stations = array_merge($stations2, $stations1);
					

				}else{
					$result = $db->prepare("SELECT stationsid,station_name, station_lat, station_lng FROM `bus_station` inner join stations on stationsid = stationid INNER JOIN busses on bus_station.busid = busses.busid WHERE stationsid BETWEEN :origin AND :dest ");
					$result->execute(array('origin' => $stationid, 'dest' => $station));

					$stations = $result->fetchAll();
				}


				$busInfo[] = $stations;
			}
			
			$result = ['stationName'=>$stationName,
					   'liveBusses' => $liveBusses,
						'station' => $busInfo];
			// print_r($result); die;
			return $result;
		}

		public function getUpdates($station,$bus){

			$db = Db::getInstance();
			
			$result = $db->prepare("SELECT * FROM `stations` where stationsid = :stationsid");
			$result->execute(array('stationsid' => $station));
			$stationName = $result->fetch();
		}
	}



?>