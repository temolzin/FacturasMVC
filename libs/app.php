<?php
	require_once 'controller/errorcontroller.php';
	require_once 'libs/interfacecrud.php';
	class App {

		function __construct() {
			$url = isset($_GET['url']) ? $_GET['url']: null;
			$url = rtrim($url, '/');
			$url = explode('/', $url);
			
			if(empty($url[0])) {
				$archivoController = 'controller/main.php';
				require_once $archivoController;
				$controller = new Main();
                $controller->loadModel($url[0]);
				return false;
			} 
			$archivoController = 'controller/' . $url[0] . '.php';

			if(file_exists($archivoController)) {
				require_once $archivoController;
				$controller = new $url[0];
				$controller->loadModel($url[0]);

				if(isset($url[1])) {
					$controller->{$url[1]}();
				}

			} else {
				$controller = new ErrorController();
			}


		}
	}

?>