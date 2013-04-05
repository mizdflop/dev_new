<?php 

namespace Poker;

class Game {

	public	$id,
	$title,
	$date,
	$table_name,
	$total_pot,
	$rake,
	$max_players,
	$board,
	$blinds_amounts,
	$description,
	$button_seat,
	$kind,
	$limit,
	$winner,
	$total_players;

	public $players, $actions,  $events, $summary_events;


	public function __construct($title, $kind, $date = null) {
		$this->id = null;
		$this->title = $title;
		$this->kind = $kind;
		$this->date = $date;
		$this->table_name = null;
		$this->total_pot = 0.0;
		$this->rake = 0.0;
		$this->blinds_amounts = array('bb' => 0, 'sb' => 0, 'ante' => 0 );
		$this->max_players = 0;
		$this->button_seat = -1;
		$this->actions = array();
		$this->players = array();
		$this->events = array();
		$this->summary_events = array();
		$this->hero = false;
		$this->limit = 'NL';
		$this->total_players = 0;
	}

	public function add_player($attributes) {
		 
		$player = new \Poker\Player($this, $attributes);
		 
		$this->players[$attributes['name']] = $player;
		$this->total_players++;
	}

	public function add_action($attributes) {
		 
		$action = new \Poker\Action($this, $attributes);
		 
		$this->actions[$attributes['kind']] = $action;
	}

	public function add_event($attributes) {
		 
		$action = $this->current_action();
		 
		$event = new \Poker\Event($this, $attributes);
		 
		$action->events[] = $event;
	}

	public function current_action() {
		if (count($this->actions)) {
			return $this->actions[end(array_keys($this->actions))];
		} else {
			return $this;
		}
	}

	public function update_blinds_ante($value) {
		$this->blinds_amounts['ante'] = intval($value);
	}

	public function dealt($player_name, $cards) {

		if (!empty($this->players[$player_name])) {
			$this->players[$player_name]->set_cards($cards);
			$this->players[$player_name]->hero = true;
		}
	}

	public function has_player($name) {
		return isset($this->players[$name]);
	}

	public function players_count() {
		return count($this->players);
	}

	public function initial_pot_size() {
		return ($this->players_count() * $this->blinds_amounts['ante']) + $this->blinds_amounts['bb'] + $this->blinds_amounts['sb'];
	}

	public function total_pot() {
		return $this->calc_total_pot();
	}

	public function update($properties) {
		if (is_array($properties) && !empty($properties)) {
			$vars = get_object_vars($this);
			foreach ($properties as $key => $val) {
				if (array_key_exists($key, $vars)) {
					$this->{$key} = $val;
				}
			}
		}
	}

	public function valid() {
		//![hero.nil?, winner.nil?, button.nil?, players_count.zero?, actions.empty?].any?
	}

	public function winner($attributes) {
		$this->winner = array(
				'player' => $attributes['player'],
				'amount' => $attributes['amount']
		);
	}

	public function set_button_seat($seat) {

		$this->button_seat = $seat;
		 
		foreach ($this->players as $player) {
			if ($player->seat == $seat) {
				$player->set_button_seat();
			}
		}
	}

	# generate positions names for players
	public function generate_positions() {
	/*
	position_names = Utils::Rules.position_names(players_count)
		sorted_players = players.sort_by(&:seat)

		# Find the button and name the seats after the button
		sorted_players.each do |player|
		player.position_name = 'BTN' if player.seat == @button_seat

		if player.seat > @button_seat
		player.position_name = position_names.pop
		end
		end

		# The seats before the button are named in order until we run out of seat
		sorted_players.each do |player|
		if player.seat < @button_seat
		player.position_name = position_names.pop
		end
		end
		*/
		}

		protected function calc_total_pot() {
		//ante_pot_size = actions.map(&:summable_events).flatten.map(&:amount).sum
		//initial_pot_size + ante_pot_size
	}
}