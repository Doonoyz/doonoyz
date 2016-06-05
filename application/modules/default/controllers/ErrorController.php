<?php
/**
 * Error Controller
 *
 * @package    Doonoyz
 * @subpackage Controller
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class ErrorController extends Zend_Controller_Action {

	/**
	 * Common acting for all
	 */
	public function init() {
		$this->view->setLayout ( 'default' );
		$this->view->addLayoutVar ( 'title', t_( "Error" ) );
	}
	
	/**
	 * Protect controller against direct access
	 *
	 */
	public function indexAction() {
		$this->_redirect ( '/' );
	}

	/**
	 * In case of javascript disabled browser detection
	 *
	 */
	public function nojavascriptAction() {
		$this->view->setView ( 'common' );
		$this->view->addLayoutVar ( 'nojavascript', 1 );
		$this->view->errorMessage = t_( "Error: Javascript isn't active on your browser but is required on this site. Please active it!" );
	}
	
	/**
	 * In case of CSRF error
	 *
	 */
	public function csrfAction() {
		$this->view->setView ( 'common' );
		$this->view->errorMessage = t_( "Something went wrong, please try again later..." );
	}

	/**
	 * Catch all the errors and do the right action
	 *
	 */
	public function errorAction() {
		$content = '';
		$errors = $this->_getParam ( 'error_handler' );

		switch ($errors->type) {
			/**
			 * If controller doesn't exists, check if its a userblog, it will throw an error if its not
			 */
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER :
				$this->getResponse ()->setRawHeader ( 'HTTP/1.1 200 OK' );
				$this->_forward ( 'blog', 'user', 'default', array ('username' => $this->_getParam ( 'controller' ) ) );
				return;
				break;
			/**
			 * Action doesn't exists
			 */
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION :
				// 404 error -- controller or action not found
				$this->view->setLayout ( 'default' );
				$this->view->addLayoutVar ( 'title', t_( "Error" ) );

				$this->getResponse ()->setRawHeader ( 'HTTP/1.1 404 Not Found' );

				$content = t_( "The page you requested was not found." );
				break;
			/**
			 * Any other error
			 */
			default :
				// application error
				$this->getResponse ()->setRawHeader ( 'HTTP/1.1 500 Internal Server Error' );
				$content = t_( "An unexpected error occurred with your request. Please try again later." );
				$writer = new Zend_Log_Writer_Stream(ROOT_DIR.'/../Core/Log/error.log');
				$log = new Zend_Log($writer);
				$log->error('Doonoyz : ' . $backtrace);
				ob_start();
				debug_print_backtrace ();
				$backtrace = ob_get_contents();
				ob_end_clean();
				if (ENVIRONMENT == 'dev') {
					print "<pre>";
					if ($errors['exception'] instanceof Exception) {
					   print $errors['exception']->getMessage() . '<br/>';
					}
					print $backtrace;
					print "</pre>";
				}
				break;
		}

		// Clear previous content
		$this->getResponse ()->clearBody ();

		$this->view->message = $content;
	}
}
