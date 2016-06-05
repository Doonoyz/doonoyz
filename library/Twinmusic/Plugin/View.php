<?php
class Twinmusic_Plugin_View extends Zend_Controller_Plugin_Abstract {
	public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {
		$moduleName = $request->getModuleName() ? $request->getModuleName() : 'default';
		$registry = Zend_Registry::getInstance();
		$config = $registry->config;
		$smartyPaths = array ('scriptPath' => ROOT_DIR . 'application/modules/' . $moduleName . '/views/scripts',
						'compileDir' => ROOT_DIR . 'application/modules/' . $moduleName . '/views/compile',
						'cacheDir' => ROOT_DIR . 'application/modules/' . $moduleName . '/views/cache',
						'cache' => $config->template->cache,
						'cacheLife' => $config->template->cacheLife,
						'compileCheck' => $config->template->compileCheck,
						'configDir' => ROOT_DIR . 'application' );

		$view = new Twinmusic_View_Smarty ( $smartyPaths );
		//$view->setScriptPath(ROOT_DIR.'templates');


		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer ( );
		$viewRenderer->setView ( $view );
		// make viewRenderer use Twinmusic_View_Smarty
		
		// make it search for .tpl files
		$viewRenderer->setViewSuffix ( 'tpl' );
		$registry->template = $view->getEngine ();
		
		Zend_Controller_Action_HelperBroker::addHelper ( $viewRenderer );
	}
}