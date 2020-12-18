<?php

class ValidationModel {

	public static function validateDocument($document) {
		$result = false;
		if (strlen($document) == 10) {
			$result = self::validateCedula($document);
		}
		if (strlen($document) == 13) {
			$result = self::validateRUC($document);
		}

		return $result;
	}

	private static function validateCedula($document) {

		$province = (int) substr($document, 0, 2);
		$third = (int) substr($document, 2, 1);
		$total = 0;
		$verificador = (int) substr($document, 9, 1);

		if ($province < 1 OR $province > 24) {
			return false;
		}

		if ($third < 0 OR $third > 6) {
			return false;
		}

		for ($i = 0; $i < 9; $i++) {
			$number = (int)substr($document, $i, 1);
			if ($i % 2 == 0) {
				if ($number * 2 > 9) {
					$total += ($number * 2) - 9;
				} else {
					$total += $number * 2;
				}
			} else {
				$total += $number * 1;
			}
		}

		if ($total % 10 == 0 AND $verificador == 0) {
			return true;
		} elseif ($total % 10 != 0 AND $verificador == 10 - ($total % 10)) {
			return true;
		}

		return false;
	}

	private static function validatePersonaPublica($document) {

		$province = (int) substr($document, 0, 2);
		$third = (int) substr($document, 2, 1);
		$coeficiente = array(3, 2, 7, 6, 5, 4, 3, 2);
		$total = 0;

		if ($province < 1 OR $province > 24) {
			return false;
		}

		if ($third != 6) {
			return false;
		}

		if (substr($document, -3) == '000') {
			return false;
		}

		for ($i = 0; $i < 8; $i++) {
			$total += substr($document, $i, 1) * $coeficiente[$i];
		}

		if (11 - $total % 11 == substr($document, 8, 1)) {
			return true;
		}

		return false;
	}

	private static function validatePersonaJuridica($document) {

		$province = substr($document, 0, 2);
		$third = substr($document, 2, 1);
		$coeficiente = array(4, 3, 2, 7, 6, 5, 4, 3, 2);
		$total = 0;

		if ($province == 0 OR $province > 24) {
			return false;
		}

		if ($third != 9) {
			return false;
		}

		for ($i = 0; $i < 9; $i++) {
			$total += substr($document, $i, 1) * $coeficiente[$i];
		}

		if (11 - $total % 11 == substr($document, 9, 1)) {
			return true;
		}
	}

	private static function validateRUC($document) {

		$third = substr($document, 2, 1);

		if ($third < 6) {
			if (self::validateCedula(substr($document, 0, 10)) AND substr($document, -3) != '000') {
				return true;
			} else {
				return false;
			}
		} elseif ($third == 6) {
			return self::validatePersonaPublica($document);
		} elseif ($third == 9) {
			return self::validatePersonaJuridica($document);
		} else {
			return false;
		}
	}

	public static function validateSpecialChars($str) {
		if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $str)) {
			return true;
		} else {
			return false;
		}
	}
}