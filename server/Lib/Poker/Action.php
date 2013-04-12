<?php 

namespace Poker;

class Action {
	public	$cards,
			$board,
			//$total_pot,
			//$previous_pot,
			//$players_count,
			$events;

	#
	# kind: 'preflop', 'flop', 'turn', 'river', 'showdown', 'exchange'
	#

	public function __construct(Game $game, $attributes = array()) {

		//print_r($game->actions);

		switch ($attributes['kind']) {

			case 'preflop':
				//$this->players_count = 0;
				//$this->previous_pot = 0;
				$this->cards = array();
				$this->board = array();
				$this->events = array();
				break;

			case 'flop':
				$preflop = $game->actions['preflop'];
				//$this->players_count = 0;
				//$this->previous_pot = 0;
				$this->cards = explode(' ', $attributes['cards']);
				$this->board = $this->cards;
				$this->events = array();
				break;

			case 'turn':
				$flop = $game->actions['flop'];
				//$this->players_count = 0;
				//$this->previous_pot = 0;
				$this->cards = explode(' ', $attributes['cards']);
				$this->board = array_merge($flop->board,$this->cards);
				$this->events = array();
				break;

			case 'river':
				$turn = $game->actions['turn'];
				//$this->players_count = 0;
				//$this->previous_pot = 0;
				$this->cards = explode(' ', $attributes['cards']);
				$this->board = array_merge($turn->board,$this->cards);
				$this->events = array();
				break;

			case 'showdown':
				$river = $game->actions['river'];
				//$this->players_count = 0;
				//$this->previous_pot = 0;
				$this->cards = array();
				$this->board = $river->board;
				$this->events = array();
				break;
		}
	}

	public function is_visible() {
		//['preflop', 'flop', 'turn', 'river'].include?(@kind);
	}

	public function cards($cards) {
		/*
		 if value.is_a?(Array)
		@cards = value
		else
			@str_cards = value.to_s
		end*/
	}

	public function summable_events() {
		//@events.select{|e| e.summable? }
	}

	public function total_pot() {
		//return @previous_pot + summable_events.map(&:pot).compact.sum
	}

	public function players_outs() {
		//@events.select { |e| e.folds? }.size
	}

	public function players_count() {
		/*
		 unless @events.empty?
		@players_count = @events.collect { |e| e.player.name }.uniq.size
		else
			@players_count
		end*/
	}
}