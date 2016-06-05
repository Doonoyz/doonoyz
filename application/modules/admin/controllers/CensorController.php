<?php
/**
 * Admin edit a component
 *
 * @package    Doonoyz
 * @subpackage Admin
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */

class Admin_CensorController extends Zend_Controller_Action {
	/**
	 * Controller Initialization
	 */
	public function init() {
		$this->view->setLayout ( 'default' );
		$this->view->addLayoutVar ( 'title', t_( "Admin" ) );
		$this->view->setCacheLife(0);
	}
	
	/**
	 * Censor controller dispatcher
	 */
	public function indexAction() {
		if (isset($_POST['id'])) {
			$this->getHelper('viewRenderer')->setNoRender(true);
			$response = $this->getResponse();
			$response->clearBody();
			$answer = array();
			$answer['default'] = $this->_treatCensor();
			$response->setBody(Zend_Json::encode($answer));
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
	 * Treat the censoring of a group
	 *
	 * @return bool
	 */
	private function _treatCensor() {
		$group = new Twinmusic_Group((int) $_POST['id']);
		$group->setCensure((int) $_POST['censorValue']);
		$group->commit();
		$answer = ($group->getCensure() == (int) $_POST['censorValue']) ? t_('Censored successfully') : t_('Error while censoring');
		return ($answer);
	}
	
	/**
	 * Displays the page
	 */
	private function _treatGet() {
		$id = (int) $this->getRequest()->getParam('id');
		$group = new Twinmusic_Group($id);
		$this->view->none = t_("none");
		$this->view->group = $group;
		$this->view->text = Array(
			'submit' => t_("Submit"),
			'present' => sprintf(t_("You're about to censor '%s'"), $group->getNom()),
		);
		$this->view->setLayout('empty');
	}
}