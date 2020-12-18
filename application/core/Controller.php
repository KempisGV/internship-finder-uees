<?php

class Controller {

	public $View;

	function __construct() {
		Session::init();
		UserModel::checkActivation();
		$this->View = new View();
	}
}