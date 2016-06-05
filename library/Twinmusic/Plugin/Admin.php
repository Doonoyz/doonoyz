<?php
class Twinmusic_Plugin_Admin extends Zend_Controller_Plugin_Abstract {
	public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {
		if ($request->getModuleName() == "admin") {
			if (! Twinmusic_Admin::isAdmin ( Twindoo_User::getCurrentUserId () )) {
				$response = Zend_Controller_Front::getInstance()->
													getResponse()->
													setRedirect('/');
				$response->sendResponse();
				exit;
			}
		}
	}
}