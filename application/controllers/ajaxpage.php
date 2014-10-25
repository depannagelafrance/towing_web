<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/page.php');

class AjaxPage extends Page {

	/**
	 *	Constructor
	 *
	 *  Default page settings, used to set site-wide variables
	 */
	public function __construct() {
		parent::__construct();
	}

	protected function _sendJson($list) {
		$this->output
				->set_content_type('application/json')
				->set_output(json_encode($list));
	}
}
