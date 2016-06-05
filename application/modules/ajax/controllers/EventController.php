<?php
/**
 * Event ajax controller
 *
 * @package    Doonoyz
 * @subpackage Ajax
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Ajax_EventController extends Zend_Controller_Action {

	protected function _setAnswer($message) {
		$response = $this->getResponse();
		$response->clearBody();
		$response->setHeader('Content-Type', 'text/html; charset=UTF-8', true);
		$response->setBody(Zend_Json::encode(array('default' => $message)));
	}
	/**
	 * Called by AjaxController
	 *
	 */
	public function indexAction() {
		$this->getHelper('viewRenderer')->setNoRender(true);
		$this->view->setLayout ( 'default' );
		$this->view->setCacheLife(0);
		
		switch ($_GET ['action']) {
			case 'add' :
				$this->addEvent ();
				break;
			case 'delete' :
				$this->deleteEvent ();
				break;
			case 'update' :
				$this->updateEvent ();
				break;
		}
		$this->_setAnswer ( 'ok' );
	}

	/**
	 * Delete an event
	 *
	 */
	private function deleteEvent() {
		$event = new Twinmusic_Event ( $_GET ['id'] );
		$group = new Twinmusic_Group ( $event->getGroupId () );

		if ($group->getAdmin () == Twindoo_User::getCurrentUserId () || Twinmusic_Admin::isAdmin ( Twindoo_User::getCurrentUserId () )) {
			$event->delete ();
		}
	}

	/**
	 * Add an event
	 *
	 */
	private function addEvent() {
		$group = new Twinmusic_Group ( $_GET ['groupId'] );

		if ($group->getAdmin () == Twindoo_User::getCurrentUserId () || Twinmusic_Admin::isAdmin ( Twindoo_User::getCurrentUserId () )) {
			$event = new Twinmusic_Event ( );
			$event->setGroupId ( $group->getId () );
			$event->setTitle ( $_GET ['title'] );
			$event->setDescription ( $_GET ['description'] );
			$event->setDate ( $_GET ['date'] ); //@todo change this post date
			$event->commit ();
		}
	}

	/**
	 * Update an event
	 *
	 */
	private function updateEvent() {
		$event = new Twinmusic_Event ( $_GET ['id'] );
		$group = new Twinmusic_Group ( $event->getGroupId () );

		if ($group->getAdmin () == Twindoo_User::getCurrentUserId () || Twinmusic_Admin::isAdmin ( Twindoo_User::getCurrentUserId () )) {
			$event->setTitle ( $_GET ['title'] );
			$event->setDescription ( $_GET ['description'] );
			$event->setDate ( $_GET ['date'] ); //@todo change this post date
			$event->commit ();
		}
	}
}
