<?php
/**
 * Web Service Controller
 *
 * Inherits from Twindoo_Controller_WsController to keep functions
 *
 * @package    Doonoyz
 * @subpackage Controller
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class WsController extends Twindoo_Controller_WsController {

	/**
	 * Init layout and service
	 *
	 */
	public function init() {
		$this->view->setLayout ( 'default' );
		$this->service = "doonoyz";
		parent::init();
	}
}
