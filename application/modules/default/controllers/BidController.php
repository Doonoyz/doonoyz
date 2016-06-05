<?php
/**
 * Bid Controller
 *
 * @package    Doonoyz
 * @subpackage Controller
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class BidController extends Zend_Controller_Action {

	/**
	 * Protect interface from accessing disconnected
	 *
	 */
	public function init() {
		$this->view->setLayout ( 'default' );
		$this->view->addLayoutVar ( 'title', t_( "Bid" ) );
		$this->view->setCacheLife ( 0 );
		if (Twindoo_User::getCurrentUserId () == 0)
			$this->_redirect ( '/ws/login' );
	}

	/**
	 * Interface to display all bids to all groups the current user is member/admin
	 *
	 */
	public function indexAction() {
		$bidList = Twinmusic_Bid::getAllMyBid ();

		$userList = Array ();
		foreach ( $bidList as $temp )
			foreach ( $temp as $line )
				$userList [$line ['USER_ID']] = $line ['USER_ID'];

		$userGrouped = Array ();
		foreach ( $bidList as $temp )
			foreach ( $temp as $line )
				$userGrouped [] = Array ($line ['USER_ID'], $line ['GROUP_ID'] );

		$this->view->setCacheLife ( 0 );
		
		$this->view->bidList = $bidList;
		$this->view->userNames = Twindoo_User::getInfos ( $userList );
		$this->view->userInfos = Twinmusic_Bid::getInfosForUserInGroup ( $userGrouped );
		$this->view->translate = new Twinmusic_Localized ( Twindoo_User::getLocale() );
		
		$this->view->competencies = t_('Skills');
		$this->view->accept = t_('Accept');
		$this->view->refuse = t_('Refuse');
		$this->view->nothing = t_('Nothing to bid.');
		$this->view->userWantJoin = t_('This user wants to join your group');
	}
}
