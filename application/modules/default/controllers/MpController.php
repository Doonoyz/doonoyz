<?php
/**
 * Private Message Controller
 *
 * @package    Doonoyz
 * @subpackage Controller
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class MpController extends Zend_Controller_Action {

	/**
	 * Prevent acces for disconnected users
	 *
	 */
	public function init() {
		$this->view->setCacheLife ( 0 );
		$this->view->setLayout ( 'default' );
		if (Twindoo_User::getCurrentUserId () == 0)
			$this->_redirect ( '/ws/login' );
	}

	/**
	 * Display Interface
	 *
	 */
	public function indexAction() {
		$this->view->addLayoutVar ( 'title', t_( "Private Mail" ) );
		$mp = new Twinmusic_Mp ( );
		$this->view->messages = $mp->getMyMp ();
		$this->view->translate = new Twinmusic_Localized();
		$this->view->users = Twindoo_Utile::dbResultHtmlSecurise ( $mp->getConcernedUser () );
		$this->view->newMessage = t_( "New Message" );
		$this->view->deleteAll = t_( "Delete All" );
		$this->view->dateHour = t_( "DATE / TIME" );
		$this->view->pseudo = t_( "PSEUDO" );
		$this->view->title = t_( "TITLE" );
		$this->view->setCacheLife ( 0 );
	}

	/**
	 * Display new message Interface
	 * Save new message informations
	 *
	 */
	public function newmessageAction() {
		$this->view->addLayoutVar ( 'title', t_( "Private Mail :: New Message" ) );
		$username = $this->_getParam ( 'username' );
		$success = 'none';
		$error = 'none';

		if ($this->getRequest()->isPost()) {
			$user = new Twindoo_User ( $username );
			$userId = $user->getId ();
			$title = (trim ( $_POST ['title'] ) == "") ? t_( "(empty)" ) : $_POST ['title'];
			$body = (trim ( $_POST ['body'] ) == "") ? t_( "(empty)" ) : $_POST ['body'];

			$this->view->titleText = $title;
			$this->view->bodyText = $body;
			if ($userId) {
				$mp = new Twinmusic_Mp ( );
				$mp->setTitle ( $title );
				$mp->setBody ( $body );
				$mp->setReceiver ( $userId );
				$mp->sendMp ();
				$success = t_( "Your message has been sent!" );
			} else {
				$error = t_( "This user doesn't exist" );
			}
		}

		$this->view->username = ($username == NULL) ? "" : $username;
		$this->view->title = t_( 'Title' );
		$this->view->pseudo = t_( 'Pseudo' );
		$this->view->send = t_( 'Send' );
		$this->view->body = t_( 'Body' );
		$this->view->success = $success;
		$this->view->error = $error;
		$this->view->setCacheLife ( 0 );
	}
}
