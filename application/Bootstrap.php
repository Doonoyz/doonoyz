<?php
class Bootstrap extends Twindoo_Bootstrap {
	public function _initView() {
		$registry = $this->getResource('registry');
		$config = $this->getResource('config');
		
		$smartyPaths = array ('scriptPath' => ROOT_DIR . 'application/modules/default/views/scripts',
						'compileDir' => ROOT_DIR . 'application/modules/default/views/compile',
						'cacheDir' => ROOT_DIR . 'application/modules/default/views/cache',
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
		return $viewRenderer;
	}
}