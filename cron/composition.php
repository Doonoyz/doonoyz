<?php
define ( 'ROOT_DIR', realpath ( dirname ( __FILE__ ) ) . '/../' );
define ( 'ENVIRONMENT', 'prod' );

set_include_path ( PATH_SEPARATOR . ROOT_DIR . '../Core' 
				. PATH_SEPARATOR . get_include_path () );
require_once('Zend/Loader/Autoloader.php');
$loader = Zend_Loader_Autoloader::getInstance();
$loader->registerNamespace('Twindoo_');
$loader->registerNamespace('Twinmusic_');

// Create application, bootstrap, and run
$application = new Zend_Application(
    ENVIRONMENT, 
    ROOT_DIR . '/application/application.ini'
);

$application->bootstrap(array('config', 'registry'))
            ->run();
            
$robot = new Twinmusic_Robot_Composition ( );
$robot->launch ();
