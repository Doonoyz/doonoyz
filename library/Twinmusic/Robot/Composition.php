<?php
/**
 * Robot composition processing unit
 *
 * @package    Doonoyz
 * @subpackage library/robot
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */

class Twinmusic_Robot_Composition {
	/**
	 * List of task to do
	 *
	 * @var Array
	 */
	private $_list;

	/**
	 * Process launcher
	 *
	 */
	public function launch() {
		$this->getMyWork ();
		$this->startTask ();
	}

	/**
	 * Get tasks to do
	 *
	 */
	public function getMyWork() {
		$sql = "SELECT * FROM DN_COMPO WHERE COMPO_FETCHED = 'N' AND COMPO_DELETED != 1";
		$db = Twindoo_Db::getDb ();
		$result = $db->fetchAll ( $sql );
		/* Update the database to avoid robot fetching conflicts */
		foreach ( $result as $value ) {
			$sql = "UPDATE DN_COMPO SET COMPO_FETCHED = 'C' WHERE COMPO_ID = ?";
			$db->query ( $sql, Array ($value ['COMPO_ID'] ) );
		}
		$this->_list = $result;
	}

	/**
	 * Process the tasks to do when work is get
	 *
	 */
	public function startTask() {
		foreach ( $this->_list as $value ) {
			$compo = new Twinmusic_Compo ( $value ['COMPO_ID'] );
			$file = $compo->getFile ();
			$process = "_process" . ucfirst ( strtolower ( $compo->getType () ) );
			if ($this->{$process} ( $compo )) {
				$compo->setFetched ( 'Y' );
				$compo->commit ();
			} else {
				$compo->setFetched ( 'E' );
				$compo->commit ();
				$compo->delete ();
			}
		}
	}

	/**
	 * Process for the videos
	 *
	 * @param Twinmusic_Compo $compo Current composition object
	 *
	 * @return bool Process successfully ?
	 */
	private function _processVideo($compo) {
		$file = ROOT_DIR . "filerepository/" . $compo->getGroupId () . '/original/' . $compo->getFile ();
		$target = ROOT_DIR . "filerepository/" . $compo->getGroupId () . '/converted/' . $compo->getFile ();
		$cmd = "mencoder \"$file\" -forceidx -of lavf -ovc lavc -oac mp3lame -lavcopts vcodec=flv:vbitrate=1000:autoaspect:abitrate=192 -vf scale=320:-3 -af resample=22050 -o \"$target\" -ni";// -lavfopts i_certify_that_my_video_stream_does_not_use_b_frames"; //seems not to work anymore
		shell_exec ( $cmd );
		$cmd = "flvtool2 -UPk \"$target\"";
		shell_exec ( $cmd );
		clearstatcache ();
		return ( @filesize ( $target ) > 1 ? true : false );
	}

	/**
	 * Process for the musics
	 *
	 * @param Twinmusic_Compo $compo Current composition object
	 *
	 * @return bool Process successfully ?
	 */
	private function _processMusic($compo) {
		$file = ROOT_DIR . "filerepository/" . $compo->getGroupId () . '/original/' . $compo->getFile ();
		$target = ROOT_DIR . "filerepository/" . $compo->getGroupId () . '/converted/' . $compo->getFile ();
		$cmd = "ffmpeg -i \"$file\" -f flv -s 320x240 -y \"$target.tmp\"";
		shell_exec ( $cmd );
		$cmd = "yamdi -i \"$target.tmp\" -o \"$target\" -c \"Doonoyz\"";
		shell_exec ( $cmd );
		unlink("$target.tmp");
		clearstatcache ();
		return ( @filesize ( $target ) > 1 ? true : false );
	}

	/**
	 * Process for the images
	 *
	 * @param Twinmusic_Compo $compo Current composition object
	 *
	 * @return bool Processed successfully ?
	 */
	private function _processPicture($compo) {
		$file = ROOT_DIR . "filerepository/" . $compo->getGroupId () . '/original/' . $compo->getFile ();
		$target = ROOT_DIR . "filerepository/" . $compo->getGroupId () . '/converted/' . $compo->getFile ();
		$cmd = "convert \"$file\" -resize 320x200 \"$target\"";
		shell_exec ( $cmd );
		clearstatcache ();
		return ( @filesize ( $target ) > 1 ? true : false );
	}

	/**
	 * Process for the texts
	 *
	 * @param Twinmusic_Compo $compo Current composition object
	 *
	 * @return bool Process successfully ?
	 */
	private function _processText($compo) {
		$file = ROOT_DIR . "filerepository/" . $compo->getGroupId () . '/original/' . $compo->getFile ();
		$temp = "/tmp/" . $compo->getGroupId () . $compo->getFile ();
		$target = ROOT_DIR . "filerepository/" . $compo->getGroupId () . '/converted/' . $compo->getFile ();
		$viewer = ROOT_DIR . "www/flash/fdviewer.swf";

		$bool = false;
		if (strtolower ( $compo->getOriginalExt() ) == 'txt') {
			//treatment .txt
			$cmd = "a2ps \"$file\" -o \"$temp.ps\"";
			shell_exec ( $cmd );
			$cmd = "ps2pdf \"$temp.ps\" \"$temp.pdf\"";
			shell_exec ( $cmd );
			unlink($temp . '.ps');
		} else if (strtolower ( $compo->getOriginalExt() ) == 'pdf') {
			copy($file, $temp . '.pdf');
		} else {
			$temp2 = $temp . "." . $compo->getOriginalExt();
			copy($file, $temp2);
			$cmd = "java -jar /opt/jod/jodconverter-cli.jar \"$temp2\" \"$temp.pdf\"";
			shell_exec ( $cmd );
			unlink($temp2);
		}
		clearstatcache ();
		if ( @filesize ( $temp . '.pdf') ) {
			$cmd = "pdf2swf -s insertstop -s zoom=90 -z \"$temp.pdf\" -o \"$target.swf\"";
			shell_exec ( $cmd );
			unlink($temp . '.pdf');
			$cmd = "swfcombine $viewer '#1'=\"$target.swf\" -z -o \"$target\"";
			shell_exec ( $cmd );
			unlink($target . '.swf');
			clearstatcache ();
			$bool = @filesize ( $target ) > 1 ? true : false;
		}
		return ( $bool );
	}
}