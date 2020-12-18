<?php

class AccountController extends Controller {

	public function __construct() {
		parent::__construct();
		Auth::checkAuthentication();
	}

	public function index() {
		$data = array(
			'user' => UserModel::getUserDataById(Session::get('user_id'))
		);
		if (Session::get('user_account_type') == 1) {
			$data['studies'] = StudentModel::getStudies(Session::get('user_id'));
			$data['skills'] = StudentModel::getSkills(Session::get('user_id'));
		} elseif (Session::get('user_account_type') == 2) {
		} elseif (Session::get('user_account_type') == 3) {
			$data['deals'] = UniversityModel::getDeals(Session::get('user_id'));
		} elseif (Session::get('user_account_type') == 4){

		}
		$this->View->render('account/index', $data);
	}

	public function editProfile() {
		$data = array('user' => UserModel::getUserDataById(Session::get('user_id')));
		$this->View->render('account/editProfile', $data);
	}

	public function editProfile_action() {
		if (!Csrf::isTokenValid()) {
			LoginModel::logout();
			Redirect::home();
		}

		$result = UserModel::updateUserData();

		if ($result) {
			Redirect::to('account');
		} else {
			Redirect::to('account/editProfile');
		}
	}

	public function changePassword() {
		$this->View->render('account/changePassword');
	}

	public function changePassword_action() {
		if (!Csrf::isTokenValid()) {
			LoginModel::logout();
			Redirect::home();
		}

		$result = PasswordResetModel::changePassword(Request::post('old_password'), Request::post('password'), Request::post('confirm_password'));

		if ($result) {
			Redirect::to('account');
		} else {
			Redirect::to('account/changePassword');
		}
	}

	public function editBio() {
		$data = UserModel::getUserDataById(Session::get('user_id'));
		$this->View->render('account/editBio', $data);
	}

	public function editBio_action() {
		if (!Csrf::isTokenValid()) {
			LoginModel::logout();
			Redirect::home();
		}

		$result = UserModel::editBio(Request::post('bio'));

		if ($result) {
			Redirect::to('account');
		} else {
			Redirect::to('account/editBio');
		}
	}

	public function editStudy($study_id) {
		$data = StudentModel::getStudyData($study_id);
		$this->View->render('account/editStudy', $data);
	}

	public function editStudy_action() {
		if (!Csrf::isTokenValid()) {
			LoginModel::logout();
			Redirect::home();
		}

		$result = StudentModel::editStudy(Request::post('study_id'), Request::post('start_date'), Request::post('end_date'), Request::post('school_name'), Request::post('career'), Request::post('credits'), Request::post('description'));

		if ($result) {
			Redirect::to('account');
		} else {
			Redirect::to('account/editStudy/' . Request::post('study_id'));
		}
	}

	public function addStudy() {
		$data = Session::get('study_data');
		Session::remove('study_data');
		if (empty($data)) {
			$data = array(
				'start_date' => '',
				'end_date' => '',
				'school_name' => '',
				'career' => '',
				'credits' => '',
				'description' => ''
			);
		}
		$this->View->render('account/addStudy', $data);
	}

	public function addStudy_action() {
		if (!Csrf::isTokenValid()) {
			LoginModel::logout();
			Redirect::home();
		}

		$result = StudentModel::addStudy(Request::post('start_date'), Request::post('end_date'), Request::post('school_name'), Request::post('career'), Request::post('credits'), Request::post('description'));

		if ($result) {
			Redirect::to('account');
		} else {
			Redirect::to('account/addStudy');
		}
	}

	public function deleteStudy($study_id) {

		$result = StudentModel::deleteStudy($study_id);

		if ($result) {
			Redirect::to('account');
		} else {
			Redirect::to('account/editStudy/' . $study_id);
		}
	}

	public function addSkill() {
		$data = Session::get('skill_data');
		Session::remove('skill_data');
		if (empty($data)) {
			$data = array(
				'name' => '',
				'rating' => ''
			);
		}
		$this->View->render('account/addSkill', $data);
	}

	public function addSkill_action() {
		if (!Csrf::isTokenValid()) {
			LoginModel::logout();
			Redirect::home();
		}

		$result = StudentModel::addSkill(Request::post('name'), Request::post('rating'));

		if ($result) {
			Redirect::to('account');
		} else {
			Redirect::to('account/addSkill');
		}
	}

	public function editSkill($skill_id) {
		$data = StudentModel::getSkillData($skill_id);
		$this->View->render('account/editSkill', $data);
	}

	public function editSkill_action() {
		if (!Csrf::isTokenValid()) {
			LoginModel::logout();
			Redirect::home();
		}

		$result = StudentModel::editSkill(Request::post('skill_id'), Request::post('name'), Request::post('rating'));

		if ($result) {
			Redirect::to('account');
		} else {
			Redirect::to('account/editSkill/' . Request::post('skill_id'));
		}
	}

	public function deleteSkill($skill_id) {

		$result = StudentModel::deleteSkill($skill_id);

		if ($result) {
			Redirect::to('account');
		} else {
			Redirect::to('account/editSkill/' . $skill_id);
		}
	}

	public function addDeal() {
		$data = Session::get('deal_data');
		Session::remove('deal_data');
		if (empty($data)) {
			$data = array(
				'company_id' => '',
				'deal_type' => '',
				'start_date' => '',
				'duration' => '',
				'contact_person' => '',
				'contact_mail' => '',
				'university_person' => '',
				'university_mail' => '',
				'deal_extent' => '',
				'deal_autorenewable' => 1
			);
		}
		$data['companies'] = CompanyModel::getCompanies();
		$this->View->render('account/addDeal', $data);
	}

	public function addDeal_action() {
		if (!Csrf::isTokenValid()) {
			LoginModel::logout();
			Redirect::home();
		}

		$result = UniversityModel::addDeal(Request::post('company_id'), Request::post('deal_type'), Request::post('start_date'), Request::post('duration'), Request::post('contact_person'), Request::post('contact_mail'), Request::post('university_person'), Request::post('university_mail'), Request::post('deal_extent'), Request::post('deal_autorenewable'), Request::files('document'));

		if ($result) {
			Redirect::to('account');
		} else {
			Redirect::to('account/addDeal');
		}
	}

	public function editDeal($deal_id) {
		$data = array(
			'deal' => UniversityModel::getDealData($deal_id),
			'companies' => CompanyModel::getCompanies()
		);
		$this->View->render('account/editDeal', $data);
	}

	public function editDeal_action() {
		if (!Csrf::isTokenValid()) {
			LoginModel::logout();
			Redirect::home();
		}

		$result = UniversityModel::editDeal(Request::post('deal_id'), Request::post('company_id'), Request::post('deal_type'), Request::post('start_date'), Request::post('duration'), Request::post('contact_person'), Request::post('contact_mail'), Request::post('university_person'), Request::post('university_mail'), Request::post('deal_extent'), Request::post('deal_autorenewable'), Request::files('document'));

		if ($result) {
			Redirect::to('account');
		} else {
			Redirect::to('account/editDeal/' . Request::post('deal_id'));
		}
	}

	public function deleteDeal($deal_id) {

		$result = UniversityModel::deleteDeal($deal_id);

		if ($result) {
			Redirect::to('account');
		} else {
			Redirect::to('account/editDeal/' . $deal_id);
		}
	}

	public function updateStudents() {
		$data = array('students' => UniversityModel::getStudents());
		$this->View->render('account/updateStudents', $data);
	}

	public function updateStudents_action() {
		if (!Csrf::isTokenValid()) {
			LoginModel::logout();
			Redirect::home();
		}

		$result = UniversityModel::updateStudents(Request::files('document'));

		Redirect::to('account/updateStudents');
	}

	public function studentProfile($user_id) {
		$data = array(
			'user' => UserModel::getUserDataById($user_id),
			'studies' => StudentModel::getStudies($user_id),
			'skills' => StudentModel::getSkills($user_id)
		);
		$this->View->render('account/student', $data);
	}

	public function myApplications() {
		$this->View->render('account/myApplications');
	}

	public function myDeals() {
		$data = array('deals' => CompanyModel::getDeals());
		$this->View->render('account/myDeals', $data);
	}

	public function dealDetail($deal_id) {
		$data = CompanyModel::getDealDataById($deal_id);
		$this->View->render('account/dealDetail', $data);
	}

	public function selectedApplicants() {
		if (Session::get('user_account_type') ==  2) {
			$data = array('students' => CompanyModel::getSelectedStudents());
		} elseif (Session::get('user_account_type') ==  3) {
			$data = array('students' => UniversityModel::getSelectedStudents());
		} else {
			Redirect::home();
		}
		$this->View->render('account/myStudents', $data);
	}
}