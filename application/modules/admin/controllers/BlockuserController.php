<?php
/**
 * Admin Block user
 *
 * @package    Doonoyz
 * @subpackage Admin
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */

class Admin_BlockuserController extends Zend_Controller_Action {
	/**
	 * Controller initialization
	 */
	public function init() {
		$this->view->setLayout ( 'default' );
		$this->view->addLayoutVar ( 'title', t_( "Admin" ) );
		$this->view->setCacheLife(0);
	}
	/**
	 * Block user
	 */
	public function indexAction() {
		$this->getHelper('viewRenderer')->setNoRender();
		
		$id = (int) $_POST['userId'];
		$user = new Twindoo_User($id);
		$user->setActive(false);
		$user->commit();
		$this->view->setConfig(
			array ('scriptPath' => ROOT_DIR . 'application/modules/default/views/scripts',
				'compileDir' => ROOT_DIR . 'application/modules/default/views/compile',
				'cacheDir' => ROOT_DIR . 'application/modules/default/views/cache'
		));
		$this->view->clearAllCache();
		$this->getResponse()->clearBody();
		$this->getResponse()->setBody(Zend_Json::encode(Array('default' => 'ok')));
	}
}