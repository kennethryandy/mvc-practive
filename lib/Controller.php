<?php


abstract class Controller
{
	protected $action;
	protected $request;

	
	public function __construct( $action, $request )
	{
		$this->action   =  $action;
		$this->request  =  $request;
	}


	public function executeAction()
	{
		return $this->{$this->action}();
	}


	public function returnView($viewModel, $fullView)
	{
		$view  = get_class( $this ) . '/' . $this->action . '.view.php';

		if( $fullView ){
			require( 'views/main.view.php' );
		}else {
			require( $view );
		}
	}


}