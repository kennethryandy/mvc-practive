<?php

// Include Config
require ( 'config.php' );

// Base
require ( 'lib/Bootstrap.php' );
require ( 'lib/Controller.php' );
require ( 'lib/Model.php' );

// Controllers
require ( 'controllers/home.controller.php' );
require ( 'controllers/shares.controller.php' );
require ( 'controllers/users.controller.php' );

// Models
require ( 'models/home.model.php' );
require ( 'models/shares.model.php' );
require ( 'models/users.model.php' );


$bootstrap = new Bootstrap( $_GET );
$controller = $bootstrap->createController();

if( !empty( $controller ) ) {
	$controller->executeAction();
}