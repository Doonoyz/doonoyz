<?php
/**
 * Robot sitemap that check if sitemaps are in a good format
 *
 * @package    Doonoyz
 * @subpackage library/robot
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */

class Twinmusic_Robot_Sitemap {
	/**
	 * List of task to do
	 *
	 * @var Array
	 */
	private $_list;
	
	/**
	 * Sitemap filesize error
	 *
	 */
	const SIZE_ERROR = 1;
	
	/**
	 * Sitemap URL number error
	 *
	 */
	const URL_ERROR = 2;

	/**
	 * Process launcher
	 *
	 */
	public function launch() {
		$error = 0;
		$error |= $this->_checkSize();
		$error |= $this->_checkNumber();
		
		if ($error) {
			$message = "";
			if ($error & self::SIZE_ERROR) {
				$message .= "Sitemap exceed 10Mo, please consider refactoring sitemap system\n";
			}
			if ($error & self::URL_ERROR) {
				$message .= "Sitemap exceed 50 000 URLs, please consider refactoring sitemap system\n";
			}
			/** consider that sitemaps indexes can not contain more than 1000 urls */
			$this->_sendMail ( $message );
		}
	}

	/**
	 * Check if sitemap size is ok
	 *
	 */
	private function _checkSize() {
		$file = shell_exec('wget --output-document=/tmp/sitemap "http://www.doonoyz.com/sitemap"');
		if (filesize('/tmp/sitemap') >= 10485760) {
			/* sitemaps can't exceed 10 Mo */
			return (self::SIZE_ERROR);
		} else {
			return (0);
		}
	}

	/**
	 * Check the number of url in sitemap
	 *
	 */
	private function _checkNumber() {
		$engine = new Twinmusic_Search_Engine ( );
		$number = count ( $engine->initEngine () );
		if ($number >= 50000) {
			return (self::URL_ERROR);
		} else {
			return (0);
		}
	}
	
	/**
	 * Send Mail
	 *
	 */
	private function _sendMail($message) {
		$email = new Zend_Mail ( );
		$email->setBodyText ( $message );
		$email->setFrom ( 'noreply@doonoyz.com', 'NoReply Doonoyz' );
		$email->addTo ( "jeremy.moulin@doonoyz.com", "jeremy.moulin@doonoyz.com" );
		$email->setSubject ( '[DOONOYZ] Sitemap Error' );
		$email->send ();
	}
}