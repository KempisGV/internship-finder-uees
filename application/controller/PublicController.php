<?php

class PublicController extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$data = array('offers' => SearchModel::recentOffers());
		$this->View->render('public/home', $data);
	}

	public function terms() {
		$this->View->render('public/terms');
	}

	public function companies() {
		$this->View->render('public/companies');
	}

	public function companyProfile($company_id) {
		$data = array(
			'company' => CompanyModel::getCompanyData($company_id),
			'offers' => CompanyModel::getOffers($company_id),
			'deals' => CompanyModel::getDeals($company_id)
		);
		$this->View->render('public/companyProfile', $data);
	}

	public function universities() {
		$this->View->render('public/universities');
	}

	public function universityProfile($university_id) {
		$data = array(
			'university' => UniversityModel::getUniversityData($university_id),
			'offers' => UniversityModel::getOffers($university_id),
			'deals' => UniversityModel::getDeals($university_id)
		);
		$this->View->render('public/universityProfile', $data);
	}

	public function searchApplications() {
		header('Content-Type: application/json');
		SearchModel::searchApplications();
	}
}