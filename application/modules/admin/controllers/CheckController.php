<?php
/**
 * Admin Checker interface that gives the right informations
 *
 * @package    Doonoyz
 * @subpackage Admin
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */

class Admin_CheckController extends Zend_Controller_Action {
	/**
	 * Controller initialization
	 */
	public function init() {
		$this->view->setLayout ( 'default' );
		$this->view->addLayoutVar ( 'title', t_( "Admin" ) );
		$this->view->setCacheLife(0);
	}
	
	/**
	 * Check controller (to update)
	 */
	 public function indexAction() {
		$component = $this->getRequest()->getParam('component');
		$id = $this->getRequest()->getParam('id');
		$this->getHelper('viewRenderer')->setNoRender(true);
		
		switch ($component) {
			case 'group' : 
				$group = new Twinmusic_Group($id);
				$response = $this->getResponse();
				$response->setRedirect('/'.$group->getUrl());           
				$response->sendHeaders();
				exit;
				break;
		}
	}
}