<?php 

namespace Poker\Parser;

interface IParser {

	public function parse_line($line);
	public function ignorable($line);
	public function determine_game($source);
}

class Base {

	const CASH = '[0-9$,.]+';

	public	$source,
			$game;

	private $parsed = false;

	public function __construct($source) {

		if (!is_array($source)) {
			if (file_exists($source)) {
				$this->source = preg_split('/\\r\\n?|\\n/', file_get_contents($source));
			} else {
				$this->source = preg_split('/\\r\\n?|\\n/', $source);
			}
		} else {
			$this->source = $source;
		}

		$this->parsed = false;
		$this->game = new \Poker\Game("Noname", $this->determine_game($this->source[0]));
	}

	public function parsed() {
		return $this->parsed;
	}

	public function parse() {

		foreach ($this->source as $line) {
			if (!empty($line)) {
				$this->parse_line($line);
			}
		}

		$this->game->generate_positions();
		$this->parsed = true;

		return $this;
	}

	public function room_name() {
		return 'Base';
	}

	protected function cash_to_d($string) {
		if (!empty($string)) {
			return number_format(preg_replace("/[$,\s]+/i", "", $string),2);
		} else {
			return 0.00;
		}
	}

	protected function parse_limit_type($value) {
		$value = strtolower(trim($value));
		switch ($value) {
			case 'pot':
				return 'PL';
			case 'no':
				return 'NL';
			default:
				return 'FL';
		}
	}

	protected function parse_date($value) {
		if (!empty($value)) {
			preg_match("/^([\d]+):([\d]+):([\d]+)\s+([A-Z]+)\s+\-\s+([\d]+)\/([\d]+)\/([\d]+)$/i", $value, $matches);
			return mktime($matches[1],$matches[2],$matches[3],$matches[6],$matches[7],$matches[5]);
		} else {
			return null;
		}
	}

}