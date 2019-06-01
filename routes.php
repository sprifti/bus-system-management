<?php

    function call($controller, $action){
	    
	    require_once('controller/' . $controller . 'controller.php');

	    switch($controller){
	      	case 'user':
	      	require_once('model/user.php');
	      	$controller = new UserController;
	      	break;
	      	case 'bus':
	      	require_once('model/bus.php');
	      	$controller = new BusController;
	      	break;
	    }

	    $controller->{ $action }();
	}



			 $controllers = array('user' => ['home', 'saveUserLocation', 'outputMap','showMap','busMap','findStation','tiranaERe'],
			 	'bus'=>['getBusName', 'getStationNameForSelect']);


			 if (array_key_exists($controller, $controllers)) 
			 	
			 {

		    if (in_array($action, $controllers[$controller])) {

			      call($controller, $action);
			    } else {
			      call('pages', 'error');
			    }
			  } else {
			    call('pages', 'error');
			  }


?>