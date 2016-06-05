<?php
/**
 * Comment Ajax Controller
 *
 * @package    Doonoyz
 * @subpackage Ajax
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Ajax_CommentController extends Zend_Controller_Action {
	protected function _setAnswer($message) {
		$response = $this->getResponse();
		$response->clearBody();
		$response->setHeader('Content-Type', 'text/html; charset=UTF-8', true);
		$response->setBody(Zend_Json::encode(array('default' => $message)));
	}
	
	/**
	 * Called by AjaxController
	 *
	 * match the right Id to the right action
	 *
	 */
	public function indexAction() {
		$this->getHelper('viewRenderer')->setNoRender(true);
		$this->view->setLayout ( 'default' );
		$this->view->setCacheLife(0);
		
		$session = new Zend_Session_Namespace(__CLASS__);
		$this->view->setCacheLife(0);
		switch ($_GET ['action']) {
			case 'show' :
				$this->_show ();
				break;
			case 'getPage' :
				$this->_printOut ( $session->searchResult );
				break;
			case 'create' :
				$this->_create ();
				break;
			case 'delete' :
				$this->_delete ();
				break;
			default :
				$this->_setAnswer ( 'error' );
				break;
		}
	}

	/**
	 * Show the comments for a type and Id
	 *
	 */
	private function _show() {
		$type = $_GET ['type'];
		$id = (int) $_GET ['id'];
		$comments = new Twinmusic_Comment ( );
		$list = $comments->getAllForType ( $id, $type );
		$session = new Zend_Session_Namespace(__CLASS__);
		$session->type = $type;
		$session->id = $id;
		$session->searchResult = $list;
		$session->concernedUsers = $comments->getConcernedUsers ();
		$this->_printOut ( $list );
	}

	/**
	 * Display comments
	 *
	 * @param array $result Results to display
	 */
	private function _printOut($result) {
		$pagine = Zend_Paginator::factory( (array) $result );
		$pagine->setItemCountPerPage(5);
		$pagine->setCurrentPageNumber($_GET ['page']);

		$session = new Zend_Session_Namespace(__CLASS__);
		$this->getHelper('viewRenderer')->setNoRender(false);
		$this->view->comments = $pagine->getCurrentItems ();
		$this->view->page = $pagine->getCurrentPageNumber ();
		$this->view->totalPage = $pagine->count ();
		$this->view->userList = $session->concernedUsers;
		$this->view->commentType = $session->type;
		$this->view->commentId = $session->id;
		$this->view->connected = Twindoo_User::getCurrentUserId ();
		$this->view->translate = new Twinmusic_Localized();

		$this->view->delete = t_( "Delete this comment" );
		$this->view->newComment = t_( "New Comment" );
		$this->view->submit = t_( "Submit" );
		$this->view->noComment = t_( "No comment at the moment, be the first to react!" );
		$this->view->connectedOrRegister = t_( "You must be connected to leave a comment!" );
	}

	/**
	 * Create a comment for a type and an ID
	 *
	 */
	private function _create() {
		$type = $_GET ['type'];
		$id = $_GET ['id'];
		$comment = new Twinmusic_Comment ( );
		$comment->setUserId ( Twindoo_User::getCurrentUserId () );
		$comment->setBody ( $_GET ['body'] );
		$comment->setType ( $type );
		$comment->setTypeId ( $id );
		$comment->commit ();
		$this->_setAnswer ( 'ok' );
	}
}
