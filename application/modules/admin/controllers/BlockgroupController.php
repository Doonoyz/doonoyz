<?php
/**
 * Admin Block group
 *
 * @package    Doonoyz
 * @subpackage Admin
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */

class Admin_BlockgroupController extends Zend_Controller_Action {
	/**
	 * Initialization of the controller
	 */
	public function init() {
		$this->view->setLayout ( 'default' );
		$this->view->addLayoutVar ( 'title', t_( "Admin" ) );
		$this->view->setCacheLife(0);
	}
	
	/**
	 * Default action to block groups
	 */
	public function indexAction() {
		$this->_getHelper('viewRenderer')->setNoRender();
		
		$id = (int) $_POST['groupId'];
		$user = new Twinmusic_Group($id);
		$user->setActive(isset($_POST['value']) ? $_POST['value'] : 0);
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