<?php 
	
	class BusController{

		public function getBusName(){

			if(isset($_POST["bus"])){
				$bus = $_POST["bus"];
			}

			$busses = Bus::getBusses($bus);
			echo json_encode($busses);
		}

		public function getStationNameForSelect(){
			if(isset($_POST["station"])){
				$station = $_POST["station"];
			}

			if(isset($_POST["bus"])){
				$bus = $_POST["bus"];
			}

			$results = Bus::getStationName($station, $bus);
			echo json_encode($results);
		}
	}


?>