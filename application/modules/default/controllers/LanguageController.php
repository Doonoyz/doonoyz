<?php
/**
 * Language Controller
 *
 * @package    Doonoyz
 * @subpackage Controller
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class LanguageController extends Zend_Controller_Action {
	/**
	 * Change the locale to selected
	 *
	 */
	public function indexAction() {
        $this->getHelper ( 'viewRenderer' )->setNoRender ();
		$lang = $this->_getParam ( 'language' );
		Twindoo_User::setLocale ( $lang );
		$previous = isset ( $_SERVER ["HTTP_REFERER"] ) ? $_SERVER ["HTTP_REFERER"] : '/';
		$this->_redirect ( $previous );
	}
}
