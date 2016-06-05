<?php
/**
 * Admin Home management
 *
 * @package    Doonoyz
 * @subpackage Admin
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
 
class Admin_HomeController extends Zend_Controller_Action {
	/**
	 * Controller initialization
	 */
	public function init() {
		$this->view->setLayout ( 'default' );
		$this->view->addLayoutVar ( 'title', t_( "Admin" ) );
		$this->view->setCacheLife(0);
	}
	
	/**
	 * Home management dispatcher
	 */
	public function indexAction() {
		if (isset($_POST['action'])) {
			$this->getHelper('viewRenderer')->setNoRender(true);
			$answer = '';
			switch ($_POST['action']) {
				case 'save':
					$mostAp = (isset($_POST['mostAp']) && is_array($_POST['mostAp'])) ? $_POST['mostAp'] : array();
					Twinmusic_Group::setMostAppreciated($mostAp);
					$answer = t_("Saved successfully");
					break;
			}
			$this->getResponse->appendBody(Zend_Json::encode(Array('default' => $answer)));
			$this->view->setConfig(
				array ('scriptPath' => ROOT_DIR . 'application/modules/default/views/scripts',
					'compileDir' => ROOT_DIR . 'application/modules/default/views/compile',
					'cacheDir' => ROOT_DIR . 'application/modules/default/views/cache'
			));
			$this->view->clearAllCache();
		} else {
			$this->_treatGet();
		}
	}
	
	/**
	 * Displays interface
	 */
	private function _treatGet() {
		$this->view->available = Twinmusic_Search_Engine::initEngine();
		$this->view->selected = Twinmusic_Group::getMostAppreciated();
		$this->view->translate = new Twinmusic_Localized ( Twindoo_User::getLocale() );
		$this->view->manageMostAppreciated = t_("Manage Most Appreciated");
		$this->view->addSelected = t_("Add the selected group");
		$this->view->saveModif = t_("Save modifications");
	}
}