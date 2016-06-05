<?php
/**
 * Admin Delete task
 *
 * @package    Doonoyz
 * @subpackage Admin
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */

class Admin_DeletetaskController extends Zend_Controller_Action {

	/**
	 * Controller Initialization
	 */
	public function init() {
		$this->view->setLayout ( 'default' );
		$this->view->addLayoutVar ( 'title', t_( "Admin" ) );
		$this->view->setCacheLife(0);
	}
	
	/**
	 * Delete the requested task
	 */
	public function indexAction() {
		$this->getHelper('viewRenderer')->setNoRender();
		
		$id = (int) $_POST['taskId'];
		$task = new Twinmusic_Admintask($id);
		$task->delete();
		$this->getResponse()->clearBody();
		$this->getResponse()->setBody(Zend_Json::encode(Array('default' => 'ok')));
	}
}