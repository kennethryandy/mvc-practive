<?php

class Bootstrap
{
	/**
	 * The name of the URL path class.
	 *
	 * @var string
	 */
	private $controller;


	/**
	 * Undocumented variable
	 *
	 * @var string
	 */
	private $action;


	/**
	 * Undocumented variable
	 *
	 * @var array
	 */
	private $request;

	public function __construct($request)
	{
		$this->request  =  $request;
		if( $this->request['controller'] === "" ) {
			$this->controller  =  'home';
		}else {
			$this->controller  =  $this->request['controller'];
		}

		if( $this->request['action'] === "" ) {
			$this->action  =  'index';
		}else {
			$this->action  =  $this->request['action'];
		}
		// echo '<pre>';
		// echo '<h1>controller</h1>';
		// print_r($this->controller);
		// echo '<br/><h1>request</h1>';
		// print_r($this->request);
		// echo '<br/><h1>action</h1>';
		// print_r($this->action);
		// echo '</pre>';
	}


	/**
	 * Create a controller and instantiate base on the URL path.
	 *
	 * @return object|void Returns the instantiate controller class or nothing if there is no controller.
	 */
	public function createController()
	{
		// Check class
		if( class_exists( $this->controller ) ){
			$parents  =  class_parents( $this->controller );

			// Check extends
			if( in_array( 'Controller', $parents ) ){
				if( method_exists( $this->controller, $this->action ) ) {
					return new $this->controller( $this->action, $this->request );
				}else {
					// Method does not exists.
					echo '<h1>Method does not exist.</h1>';
					return;
				}
			} else {
				// Base controller not found.
				echo '<h1>Base controller does not exist.</h1>';
				return;
			}
		} else {
			// Controller class does not exist.
			echo '<h1>Controller Class does not exist.</h1>';
			return;
		}
	}
	

}