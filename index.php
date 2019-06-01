<?php

	
    require_once('model/connect.php');

    if (isset($_GET['controller']) && isset($_GET['action'])) {
        $controller = $_GET['controller'];
        $action     = $_GET['action'];
    } else {
        $controller = 'user';
        $action     = 'home';
    }
 
require_once('routes.php');

?>