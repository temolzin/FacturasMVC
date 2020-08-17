<?php
	/**
	 * 
	 */
	class ErrorController extends Controller
	{
		function __construct()
		{
			//echo 'Error al cargar el recurso';
			parent::__construct();
			$this->view->mensaje = "Error al cargar el recurso, <br> no se puede acceder a la página solicitada";
			$this->view->render('errorcontroller/index');
		}
	}
?>