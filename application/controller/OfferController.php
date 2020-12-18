<?php

class OfferController extends Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index() {
		$this->View->render('offer/index');
	}

	public function searchOffer() {
		header('Content-Type: application/json');
		SearchModel::searchOffer();
	}

	public function searchStudent() {
		header('Content-Type: application/json');
		SearchModel::searchStudent();
	}

	public function myOffers() {
		$this->View->render('offer/myOffers');
	}

	public function offerDetail($offer_id) {
		$data = array(
			'offer' => OfferModel::getOfferData($offer_id),
			'careers' => OfferModel::getCareers($offer_id),
			'benefits' => OfferModel::getBenefits($offer_id),
			'workareas' => OfferModel::getWorkareas($offer_id)
		);
		$data['deals'] = CompanyModel::getDeals($data['offer']->user_id);
		$this->View->render('offer/offerDetail', $data);
	}

	public function applications($offer_id) {
		$data = array('offer_id' => $offer_id);
		$this->View->render('offer/applications', $data);
	}

	public function student($user_id, $offer_id) {
		$data = array(
			'offer_id' => $offer_id,
			'user' => UserModel::getUserDataById($user_id),
			'studies' => StudentModel::getStudies($user_id),
			'skills' => StudentModel::getSkills($user_id)
		);
		$this->View->render('offer/student', $data);
	}

	public function publishOffer_action($offer_id, $user_id){
		if (Session::get('user_id') != $user_id) {
			Redirect::home();
		} else {
			OfferModel::publishOffer($offer_id);

			Redirect::to('offer/offerdetail/' . $offer_id);
		}
	}

	public function closeOffer_action($offer_id, $user_id){
		if (Session::get('user_id') != $user_id) {
			Redirect::home();
		} else {
			OfferModel::closeOffer($offer_id);

			Redirect::to('offer/offerdetail/' . $offer_id);
		}
	}

	public function deleteOffer_action($offer_id, $user_id){
		if (Session::get('user_id') != $user_id) {
			Redirect::home();
		} else {
			OfferModel::deleteOffer($offer_id);

			Redirect::to('offer/myoffers');
		}
	}

	public function addOffer() {
		if (Session::get('user_account_type') == 1 OR Session::get('user_account_type') == 4) {
			Redirect::home();
		}

		$data = Session::get('offer_data');
		Session::remove('offer_data');
		if (empty($data)) {
			$data = array(
				'offer_type' => '',
				'title' => '',
				'end_date' => '',
				'city' => 0,
				'careers' => array(),
				'workareas' => array(),
				'benefits' => array(),
				'description' => ''
			);
		}
		$this->View->render('offer/addOffer', $data);
	}

	public function addOffer_action() {
		if (!Csrf::isTokenValid()) {
			LoginModel::logout();
			Redirect::home();
		}

		$result = OfferModel::addOffer(Request::post('offer_type'), Request::post('title'), Request::post('end_date'), Request::post('city'), Request::post('careers'), Request::post('workareas'), Request::post('benefits'), Request::post('description'), Request::post('publish'));

		if ($result) {
			Redirect::to('offer/myOffers');
		} else {
			Redirect::to('offer/addOffer');
		}
	}

	public function editOffer($offer_id) {
		if (Session::get('user_account_type') == 1 OR Session::get('user_account_type') == 4) {
			Redirect::home();
		}

		$data = array(
			'offer' => OfferModel::getOfferData($offer_id),
			'careers' => OfferModel::getCareers($offer_id, PDO::FETCH_ASSOC),
			'benefits' => OfferModel::getBenefits($offer_id, PDO::FETCH_ASSOC),
			'workareas' => OfferModel::getWorkareas($offer_id, PDO::FETCH_ASSOC)
		);
		$this->View->render('offer/editOffer', $data);
	}

	public function editOffer_action() {
		if (!Csrf::isTokenValid()) {
			LoginModel::logout();
			Redirect::home();
		}

		$result = OfferModel::editOffer(Request::post('offer_id'), Request::post('offer_type'), Request::post('title'), Request::post('end_date'), Request::post('city'), Request::post('careers'), Request::post('workareas'), Request::post('benefits'), Request::post('description'));

		if ($result) {
			Redirect::to('offer/offerdetail/' . Request::post('offer_id'));
		} else {
			Redirect::to('offer/editoffer/' . Request::post('offer_id'));
		}
	}

	public function applyOffer($offer_id) {
		ApplicationModel::applyOffer($offer_id);
		Redirect::to('offer/offerdetail/' . $offer_id);
	}

	public function removeApplication($offer_id) {
		ApplicationModel::removeApplication($offer_id);
		Redirect::to('offer/offerdetail/' . $offer_id);
	}

	public function selectStudent($student_id, $offer_id) {
		ApplicationModel::selectStudent($student_id, $offer_id);
		Redirect::to('offer/applications/' . $offer_id);
	}

	public function removeStudent($student_id, $offer_id) {
		ApplicationModel::removeStudent($student_id, $offer_id);
		Redirect::to('offer/applications/' . $offer_id);
	}
}