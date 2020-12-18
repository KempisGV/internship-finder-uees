<?php

class AdminController extends Controller {

	public function __construct() {
		parent::__construct();

		if (Session::get('user_account_type') != 4) {
			Redirect::home();
		}
	}

	public function index() {
		$data = array(
			'students' => AdminModel::countUsers(1),
			'companies' => AdminModel::countUsers(2),
			'universities' => AdminModel::countUsers(3),
			'internships' => AdminModel::countOffers(1),
			'projects' => AdminModel::countOffers(2),
			'requests' => AdminModel::countRequest()
		);
		$this->View->render('admin/index', $data);
	}

	public function users() {
		$data = array(
			'users' => AdminModel::getUserList(Session::get('user_id')),
			'total' => AdminModel::getUserListTotal(Session::get('user_id'))
		);
		$this->View->render('admin/users', $data);
	}

	public function requests() {
		$data = array(
			'requests' => AdminModel::getRequestList(),
			'total' => AdminModel::getRequestListTotal()
		);
		$this->View->render('admin/requests', $data);
	}
	
	public function updateRequest($request_id) {
		$data = AdminModel::getRequestDatabyId($request_id);
		$this->View->render('admin/updateRequest', $data);
	}
	
	public function updateRequest_action() {
		$result = AdminModel::updateRequest();
		if ($result) {
			Redirect::to('admin/requests');
		}
		Redirect::to('admin/updaterequest/' . Request::post('request_id'));
	}

	public function approveUser($request_id) {
		$result = AdminModel::approveUser($request_id);

		if ($result) {
			Redirect::to('admin/users');
		} else {
			Redirect::to('admin/requests');
		}
	}

	public function activateUser($user_id) {
		AdminModel::activateUser($user_id);
		Redirect::to('admin/users');
	}

	public function inactivateUser($user_id) {
		AdminModel::inactivateUser($user_id);
		Redirect::to('admin/users');
	}

	public function deleteUser($user_id) {
		AdminModel::deleteUser($user_id);
		Redirect::to('admin/users');
	}

	public function undeleteUser($user_id) {
		AdminModel::undeleteUser($user_id);
		Redirect::to('admin/users');
	}
}