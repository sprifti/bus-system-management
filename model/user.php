<?php
	require "/ProgramData/ComposerSetup/bin/vendor/autoload.php";
	use GuzzleHttp\Pool;
	use GuzzleHttp\Client;
	use GuzzleHttp\Psr7\Request;

	class User{
		public function __construct(){}

		public function saveCoordinates($user_lat,$user_lng){
			
			$db = Db::getInstance();

				// $result = $db->prepare("INSERT INTO user_location(user_lat,user_lng) VALUES(:user_lat,:user_lng)");
				// print_r($result);
				// $result->execute(array('user_lat' => $user_lat, 'user_lng' => $user_lng));
		}
		
		public function findClosestStation(){

			$db = Db::getInstance();
			$result = $db->prepare("SELECT station_name, station_lat, station_lng FROM `stations` LIMIT 19");
				
			$result->execute();

			$return = $result->fetchAll();
			
			return $return;		

	
		}

		// public function findStation($latUser,$lngUser,$latDest,$lngDest){
		// 	$db = Db::getInstance();
		// 	$result = $db->prepare("SELECT station_name FROM `stations` where station_lat = :statLat and station_lng = :statLng");
				
		// 	$result->execute(array(':statLat' => $latUser, ':statLng' => $lngUser));
		// 	$return1 = $result->fetch();

		// 	$result2 = $db->prepare("SELECT station_name FROM `stations` where station_lat = :statLat and station_lng = :statLng");
				
		// 	$result2->execute(array(':statLat' => $latDest, ':statLng' => $lngDest));
		// 	$return2 = $result2->fetch();

		// 	$return = ["sUser"=> $return1["station_name"],
		// 			 "sDest"=>  $return2["station_name"]];

		// 	return $return;
		// }
		
		public function findBus($station1, $station2){
			$db = Db::getInstance();
			$result = $db->prepare("SELECT bus_name FROM `Busses` inner join bus_station on Busses.busid = bus_station.busid inner join stations on stations.stationsid = bus_station.stationid where stations.station_name = :station");
				
			$result->execute(array(':station' => $station1));
			$stationOne = $result->fetchAll();

			$result = $db->prepare("SELECT bus_name FROM `Busses` inner join bus_station on Busses.busid = bus_station.busid inner join stations on stations.stationsid = bus_station.stationid where stations.station_name = :station");
				
			$result->execute(array(':station' => $station2));
			$stationTwo = $result->fetchAll();
			$busses = array();
			// echo count($stationOne); die;
			if(count($stationOne) <= count($stationTwo)){
				foreach ($stationOne as $key => $value) {
						$busses["busname"] = "Error";
					if($stationTwo[$key]["bus_name"] ==  $value[$key])
						$busses["busname"] = $value[$key];
					break;
					}
			}

			// if($busses["busname"] = "Error"){
			// 	 print_r($station1);
			// 	  print_r($station2); die;
			// }
			return $busses;
		}

		// public function findThreePoints($origin, $destination,$bus){

		// 	$db = Db::getInstance();

		// 	$result1 = $db->prepare("SELECT * from stations WHERE station_name = :stationName");
		// 	$result1->execute(array(':stationName' => $origin));
		// 	$result = $result1->fetch();
		// 	$station1 = $result["stationsid"];

		// 	$result2 = $db->prepare("SELECT * from stations WHERE station_name = :stationName");
		// 	$result2->execute(array(':stationName' => $destination));
		// 	$result = $result2->fetch();
		// 	$station2 = $result["stationsid"];

		// 	if($station1 > $station2){

		// 		$result3 = $db->prepare("SELECT COUNT(*) AS nr FROM `busses` inner join bus_station on busses.busid = bus_station.busid inner join stations on stations.stationsid = bus_station.stationid where stations.stationsid >= :station1 AND stationsid <= :station2");

		// 		$result3->execute(array(':station1' => $station1,':station2' => $station2));
		// 		$result = $result3->fetch();
		// 		$nr = $result["nr"]; die;
		// 	}else{

		// 		//gjej id-in e pare per stacionet e kesaj linje
		// 		$result1 = $db->prepare("SELECT * FROM `busses` inner join bus_station on busses.busid = bus_station.busid inner join stations on stations.stationsid = bus_station.stationid where busses.bus_name = :bus  ORDER BY `bus_station`.`id` ASC LIMIT 1");
		// 		$result1->execute(array(':bus' => $bus["busname"]));
		// 		$result = $result1->fetch();
		// 		$stationBegin = $result["stationsid"];

		// 		$result1 = $db->prepare("SELECT * FROM `busses` inner join bus_station on busses.busid = bus_station.busid inner join stations on stations.stationsid = bus_station.stationid where busses.bus_name = :bus  ORDER BY `bus_station`.`id` DESC LIMIT 1");
		// 		$result1->execute(array(':bus' => $bus["busname"]));
		// 		$result = $result1->fetch();
		// 		$stationEnd = $result["stationsid"];

		// 		$result = $db->prepare("SELECT COUNT(*) AS nr FROM `busses` inner join bus_station on busses.busid = bus_station.busid inner join stations on stations.stationsid = bus_station.stationid where stations.stationsid >= :stationBegin AND stationsid <= :station1");
		// 		$result->execute(array(':stationBegin' => $stationBegin,':station1' => $station1));
		// 		$result = $result->fetch();
		// 		$nr1 = $result["nr"];

		// 		$result = $db->prepare("SELECT COUNT(*) AS nr FROM `busses` inner join bus_station on busses.busid = bus_station.busid inner join stations on stations.stationsid = bus_station.stationid where stations.stationsid > :station2 AND stationsid < :stationEnd");
		// 			$result->execute(array(':station2' => $station2,':stationEnd' => $stationEnd));
		// 		$result = $result->fetch();
		// 		$nr2 = $result["nr"];
		// 		$nr3 =$nr1 + $nr2;

		// 		if($nr3 > $nr){
					
		// 		}
		// 	// print_r($stationBegin);
		// 	// print_r($station2." ".$nr1." ");
		// 	// print_r($station1." ".$nr2." ");
		// 	// print_r($stationEnd);die;

		// 	}
		// } 
	

	}

?>