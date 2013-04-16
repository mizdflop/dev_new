<?php 

namespace Poker;

class Event {

	public	$player,
			$amount,
			$action,
			$cards;

	#
	# kind: 'ante', 'bets', 'checks', 'folds', :shows, :mucks, :wins, :small, :big, :calls, :small_and_big, :reset, :noreset
	#

	public function __construct(Game $game, $attributes = array()) {

		$attributes = array_merge(array(
				'player' => null,
				'amount' => 0.00,
				'action' => null,
				'cards' => array(),
		),$attributes);

		$attributes['action'] = $attributes['kind'];
		unset($attributes['kind']);

		if (!empty($attributes['cards'])) {
			$attributes['cards'] = explode(' ', $attributes['cards']);
		}

		$this->update($attributes);

		if (!$this->player || !$this->action) {
			throw new Exception("Event player cannot be nil, kind cannot be blank");
		}

		switch ($this->action) {

			case 'small':
				$game->players[$attributes['player']]->set_kind('small');
				$game->players[$attributes['player']]->make_stake($attributes['amount']);
				break;
			case 'big':
				$game->players[$attributes['player']]->set_kind('big');
				$game->players[$attributes['player']]->make_stake($attributes['amount']);
				break;
			case 'folds':
				$game->total_players--;
				break;
			case 'bets':
			case 'calls':
				$game->players[$attributes['player']]->make_stake($attributes['amount']);
				break;
			case 'raises':
				$game->players[$attributes['player']]->make_raise($attributes['amount'],$game->blinds_amounts);
				break;
			case 'shows':
				$game->players[$attributes['player']]->set_cards($attributes['cards']);
				break;
			case 'wins':
				$game->players[$attributes['player']]->win($attributes['amount']);
				$game->winner($attributes);
				break;
			case 'checks':
				break;
					
		}
	}

	public function summary($kind) {
		//['wins', 'shows', 'mucks', 'not_show'].include?(kind.to_s.downcase)
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
}