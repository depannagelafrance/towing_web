<?php
require("page.php");

class Index extends Page {
	/**
	 *	Default constructor.
	 */
	function __construct() {
		parent::__construct();
	}

	function index() {
		// RENDER
		$this->_render_page();
	}

}