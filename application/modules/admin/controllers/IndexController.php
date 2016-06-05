<?php
/**
 * Admin index
 *
 * @package    Doonoyz
 * @subpackage Admin
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */

class Admin_IndexController extends Zend_Controller_Action {
	/**
	 * Controller initialization
	 */
	public function init() {
		$this->view->setLayout ( 'default' );
		$this->view->addLayoutVar ( 'title', t_( "Admin" ) );
		$this->view->setCacheLife(0);
	}
	
	/**
	 * Displays interface
	 */
	public function indexAction() {
		$tasks = new Twinmusic_Admintask ( );
		$this->view->tasks = $tasks->getTasks ();
		
		$this->view->message = t_("Message");
		$this->view->reporter = t_("Reported by");
		$this->view->action = t_("Action");
		$this->view->writeMessageTo = t_("Write a message to");
		$this->view->blockUser = t_("Block user");
		$this->view->checkCompo = t_("Check composition");
		$this->view->deleteCompo = t_("Delete composition");
		$this->view->checkNews = t_("Check news");
		$this->view->deleteNews = t_("Delete news");
		$this->view->consultGroup = t_("Consult group's blog");
		$this->view->blockGroup = t_("Block group's blog");
		$this->view->censorGroup = t_("Censor group's blog");
		$this->view->deleteTask = t_("Delete this task");
		$this->view->editComponent = t_("Edit the component");
	}
}