<?php 

namespace Poker;

class Player {

	public 	$name,
			$seat,
			$chips,
			$kind,
			$cards,
			$hero,
			$winner,
			$pot,
			$stake;

	public $game;

	/**
	 * kind: 'small_blind', 'big_blind', 'dealer' ('button'), 'default'
	 */
	public function __construct(Game $game, $attributes = array()) {

		$attributes = array_merge(array(
				'name' => null,
				'seat' => -1,
				'chips' => 0
		),$attributes);

		$this->name = $attributes['name'];
		$this->seat = intval($attributes['seat']);
		$this->kind = 'default';
		$this->chips = $attributes['chips'];
		$this->stake = 0;
		$this->cards = array();
		$this->hero = false;
		$this->winner = false;
		$this->pot = 0;

		if (empty($this->name) || empty($this->seat)) {
			throw new Exception("Player name cannot be blank, seat cannot be zero");
		}

	}

	public function is_hero() {
		return $this->hero;
	}

	public function	is_winner() {
		return $this->winner;
	}

	public function is_bblinder() {
		return in_array($this->kind,array('big_blind'));
	}

	public function is_sblinder() {
		return in_array($this->kind,array('small_blind'));
	}

	public function make_stake($amount) {
		$this->stake += $amount;
	}

	public function set_button_seat() {
		$this->set_kind('button');
	}

	public function set_kind($value) {
		$this->kind = $this->parse_kind($value);
	}

	public function set_cards($cards) {
		if (!is_array($cards)) {
			$cards = explode(' ', $cards);
		}
		$this->cards = $cards;
	}

	public function all_in() {
		$this->make_stake($this->chips - $this->stake);
	}

	public function make_raise($amount) {
		if ($this->is_bblinder()) {
			$value = $amount - $this->game->blinds_amounts['bb'];
		} elseif ($this->is_sblinder()) {
			$value = $amount - $this->game->blinds_amounts['sb'];
		} else {
			$value = $amount;
		}
		$this->make_stake($value);
	}

	public function win($amount) {
		$this->winner = true;
		$this->pot = $amount;
	}

	protected function parse_kind($value) {
		$value = strtolower(trim($value));
		switch ($value) {
			case 'small':
				return 'small_blind';
			case 'big':
				return 'big_blind';
			case 'button':
			case 'dealer':
				return 'dealer';
			default:
				return 'default';

		}
	}
}