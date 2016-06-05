<?php
/**
 * Groups manager Controller
 *
 * @package    Doonoyz
 * @subpackage Controller
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class GroupsController extends Zend_Controller_Action {
	/**
	 * Prevent acces for disconnect users
	 *
	 */
	public function init() {
		$this->view->setLayout ( 'default' );
		$this->view->setCacheLife ( 0 );
		if (! Twindoo_User::getCurrentUserId ())
			$this->_redirect ( '/' );
	}

	/**
	 * Display the interface
	 *
	 */
	public function indexAction() {
		$this->view->addLayoutVar ( 'title', t_( "Manage Groups" ) );

		$this->view->infos = Twinmusic_Invitation::getAllMyGroups ();
		$this->view->userId = Twindoo_User::getCurrentUserId ();
		$this->view->translate = new Twinmusic_Localized ( Twindoo_User::getLocale() );

		$this->view->groupName = t_( "Group Name" );
		$this->view->competencies = t_( "Skills" );
		$this->view->status = t_( "Status" );
		$this->view->bidDeliberating = t_( "(Bid) Deliberating" );
		$this->view->cancel = t_( "Cancel" );
		$this->view->validated = t_( "Validated" );
		$this->view->quitGroup = t_( "Quit this group" );
		$this->view->deleteGroup = t_( "(This will delete the group)" );
		$this->view->accept = t_( "Accept" );
		$this->view->decline = t_( "Decline" );
		$this->view->blocked = t_( "Blocked" );
	}
}
