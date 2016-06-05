<?php
/**
 * Admin User
 *
 * @package    Doonoyz
 * @subpackage Admin
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */

class Admin_UserController extends Zend_Controller_Action {
	/**
	 * Controller initialization
	 */
	public function init() {
		$this->view->setLayout ( 'default' );
		$this->view->addLayoutVar ( 'title', t_( "Admin" ) );
		$this->view->setCacheLife(0);
	}
	
	/**
	 * User management dispatcher
	 */
	public function indexAction() {
		if (isset($_POST['action'])) {
			switch ($_POST['action']) {
				case 'save':
					$this->_treatSave();
					break;
			}
		}
		$this->_treatGet();
	}
	
	/**
	 * Save modifications
	 */
	private function _treatSave() {
		$user = new Twindoo_User((int) $_POST['id']);
		if ($user->getId()) {
			$user->setActive(!$user->getActive());
			$user->commit();
		}
	}
	
	/**
	 * Displays interface
	 */
	private function _treatGet() {
		$userCollection = Twindoo_User::getInfos(array(), true);
		$userId = $this->getRequest()->getParam('userid');
		if ($userId) {
			$user = new Twindoo_User((int) $userId);
			$this->view->user = $user;
			$this->view->userId = $userId;
		}
		$this->view->userCollection = $userCollection;
		$this->view->text = array(	'editUser' => t_('Edit this user'),
									'userManage' => t_('Manage User'),
									'blockUser' => t_('Block User'),
									'allowUser' => t_('Allow User'));
	}
}