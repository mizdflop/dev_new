<?php 

namespace Poker\Parser;

class FullTilt extends \Poker\Parser\Base implements \Poker\Parser\IParser {

	public function room_name(){
		return 'FullTilt';
	}

	public function parse_line($line) {

		switch ($line) {

			case (preg_match("/^Full\s+Tilt\s+Poker\s+Game\s+\#([0-9]+):(.*)\s+\(partial\)$/", $line)? true : false):
				throw new Exception("It's only partial, need full: {$line}");
				break;

			case (preg_match("/^Full\s+Tilt\s+Poker\s+Game\s+\#([0-9]+):\s+Table\s+(.*)\s+\((\d+)\s+max\)\s+\-\s+(".self::CASH.")\/(".self::CASH.")\s+\-\s+(Pot |No |)Limit\s+Hold'em\s+\-\s+(.*)$/i", $line, $matches)? true : false):
				$this->game->update(array(
				'id' => $matches[1],
				'title' => 'Full Tilt Poker',
				'table_name' => $matches[2],
				'max_players' => intval($matches[3]),
				'date' => $this->parse_date($matches[7]),
				'description' => "#{$matches[4]}/#{$matches[5]} Hold'em #{$matches[6]} Limit",
				'limit' => $this->parse_limit_type($matches[6]),
				'blinds_amounts' => array('sb' => $this->cash_to_d($matches[4]),'bb' => $this->cash_to_d($matches[5]),'ante' => 0.0)
				));
				break;

			case (preg_match("/^Full\s+Tilt\s+Poker\s+Game\s+\#([0-9]+):\s+(".self::CASH.")\s+\+\s+(".self::CASH.")\s+(.*),\s+Table\s+(.*)\-\s+(Pot |No |)Limit\s+Hold'em\s+\-\s+(.*)$/i", $line, $matches)? true : false):
				$this->game->update(array(
				'id' => $matches[1],
				'title' => 'Full Tilt Poker',
				'table_name' => $matches[5],
				'date' => $this->parse_date($matches[7]),
				'description' => "#{$matches[2]}+#{$matches[3]} Hold'em #{$matches[6]} Limit",
				'limit' => $this->parse_limit_type($matches[6]),
				'blinds_amounts' => array('sb' => $this->cash_to_d($matches[3]),'bb' => $this->cash_to_d($matches[2]),'ante' => 0.0)
				));
				break;

			case (preg_match("/^Full\s+Tilt\s+Poker\s+Game\s+\#([0-9]+):(\s+.*,)?\s+Table\s+(.*)\s+\-\s+(".self::CASH.")\/(".self::CASH.")\s+(Ante\s+(".self::CASH.")\s+)?\-\s+([0-9,$.]+\s+Cap\s+)?(Pot |No |)Limit\s+Hold'em\s+\-\s+(.*)$/i", $line, $matches)? true : false):
				$this->game->update(array(
				'id' => $matches[1],
				'title' => 'Full Tilt Poker',
				'table_name' => $matches[3],
				'date' => $this->parse_date($matches[10]),
				'description' => "#{$matches[4]}/#{$matches[5]} Hold'em #{$matches[9]} Limit",
				'limit' => $this->parse_limit_type($matches[9]),
				'blinds_amounts' => array('sb' => $this->cash_to_d($matches[4]),'bb' => $this->cash_to_d($matches[5]),'ante' => $this->cash_to_d($matches[7]))
				));
				break;

			case (preg_match("/^Seat\s+(\d+):\s*(.+)\s+\(\s*(".self::CASH.")\s*\)$/i", $line, $matches)? true : false):
				$this->game->add_player(array('name' => $matches[2],'seat' => intval($matches[1]),'chips' => $this->cash_to_d($matches[3])));
				break;

			case (preg_match("/^Seat\s+(\d+):\s*(.+)\s+\(\s*(".self::CASH.")\s*\),?\s+is\s+sitting\s+out$/i", $line, $matches)? true : false):
				$this->game->add_player(array('name' => $matches[2],'seat' => intval($matches[1]),'chips' => $this->cash_to_d($matches[3])));
				break;

			case (preg_match("/^(.*)\s+antes\s+(".self::CASH.")/i", $line, $matches)? true : false):
				$this->game->add_event(array('kind' => 'ante','amount' => $this->cash_to_d($matches[2]),'player' => $matches[1]));
				break;

			case (preg_match("/(.*)\s+posts\s+(a dead|the)\s+(small|big)\s+blind\s+of\s+(".self::CASH.")/i", $line, $matches)? true : false):
				$this->game->add_event(array('kind' => $matches[3],'amount' => $this->cash_to_d($matches[4]),'player' => $matches[1]));
				break;

			case (preg_match("/^(.*)\s+posts\s+(".self::CASH.")$/i", $line, $matches)? true : false):
				$this->game->add_event(array('kind' => 'ante','amount' => $this->cash_to_d($matches[2]),'player' => $matches[1]));
				break;

			case (preg_match("/^The\s+button\s+is\s+in\s+seat\s+\#(\d+)/i", $line, $matches)? true : false):
				$this->game->set_button_seat($matches[1]);
				break;

			case (preg_match("/\*+\s+HOLE\s+CARDS\s+\*+/i", $line, $matches)? true : false):
				$this->game->add_action(array('kind' => 'preflop'));
				break;

			case (preg_match("/^Dealt\s+to\s+(\w+)\s+\[([^\]]+)\]/i", $line, $matches)? true : false):
				$this->game->dealt($matches[1],$matches[2]);
				break;

			case (preg_match("/(.+)\s+(calls|bets)\s+(".self::CASH.")/i", $line, $matches)? true : false):
				$this->game->add_event(array('kind' => $matches[2],'player' => $matches[1],'amount' => $this->cash_to_d($matches[3])));
				break;

			case (preg_match("/(.+)\s+(folds|checks)/", $line, $matches)? true : false):
				$this->game->add_event(array('kind' => $matches[2], 'player' => $matches[1]));
				break;

			case (preg_match("/(.+)\s+raises\s+to\s+(".self::CASH.")/i", $line, $matches)? true : false):
				$this->game->add_event(array('kind' => 'raises', 'player' => $matches[1],'amount' => $this->cash_to_d($matches[2])));
				break;

			case (preg_match("/\*+\s+Flop\s+\*+\s+\[(.*)\]/i", $line, $matches)? true : false):
				$this->game->add_action(array('kind' => 'flop', 'cards' => $matches[1]));
				break;

			case (preg_match("/Uncalled\s+bet\s+of\s+(".self::CASH.")\s+returned\s+to\s+(.*)/i", $line, $matches)? true : false):
				// @todo
				break;

			case (preg_match("/Board:\s+\[(.*)\]/", $line, $matches)? true : false):
				if (!is_array($matches[1])) {
					$cards = explode(' ', $matches[1]);
				} else {
					$cards = $matches[1];
				}
				$this->game->update(array('board' => $cards));
				break;

			case (preg_match("/^(.*)\s+mucks/", $line, $matches)? true : false):
				$this->game->add_event(array('kind' => 'mucks', 'player' => $matches[1]));
				break;

			case (preg_match("/^(.*)\s+wins\s+the\s+(side\s+|main\s+)?pot\s+\((".self::CASH.")\)/", $line, $matches)? true : false):
				$this->game->add_event(array('kind' => 'wins', 'player' => $matches[1], 'amount' => $this->cash_to_d($matches[3])));
				break;

			case (preg_match("/\*+\s+SUMMARY\s+\*+/i", $line, $matches)? true : false):
				break;
			case (preg_match("/\*+\s+TURN\s+\*+\s+\[(.*)\]\s+\[(.*)\]/i", $line, $matches)? true : false):
				$this->game->add_action(array('kind' => 'turn', 'cards' => $matches[2]));
				break;

			case (preg_match("/\*+\s+RIVER\s+\*+\s+\[(.*)\]\s+\[(.*)\]/i", $line, $matches)? true : false):
				$this->game->add_action(array('kind' => 'river', 'cards' => $matches[2]));
				break;

			case (preg_match("/\*+\s+SHOW\s+DOWN\s+\*+/i", $line, $matches)? true : false):
				$this->game->add_action(array('kind' => 'showdown'));
				break;

			case (preg_match("/^(.*)\s+shows\s+\[([^\]]*)\]/i", $line, $matches)? true : false):
			case (preg_match("/^(.*)\s+shows\s+(.*)$/i", $line, $matches)? true : false):
				$this->game->add_event(array('kind' => 'shows','player' => $matches[1], 'cards' => $matches[2]));
				break;

			case (preg_match("/Total\s+pot\s+(".self::CASH.")\s+(((Main)|(Side))\s+pot(-[0-9]+)?\s+(".self::CASH.").)*\|\s+Rake\s+(".self::CASH.")/i", $line, $matches)? true : false):
				$this->game->update(array('total_pot' => $this->cash_to_d($matches[1]),'rake' => $this->cash_to_d($matches[8])));
				break;

			case (preg_match("/Total\s+pot\s+(".self::CASH.")(\s+(Main|Side)\s+pot(\s+".self::CASH.")?\s+(".self::CASH.")\.)*\s+\|\s+Rake\s+(".self::CASH.")/i", $line, $matches)? true : false):
				$this->game->update(array('total_pot' => $this->cash_to_d($matches[1]),'rake' => $this->cash_to_d($matches[6])));
				break;

			case (preg_match("/(.*)\s+wins\s+the\s+pot\s+\((".self::CASH.")\)/i", $line, $matches)? true : false):
			case (preg_match("/^(.*)\s+ties\s+for\s+the\s+((main|side)\s+)?pot\s+\((".self::CASH.")\)/i", $line, $matches)? true : false):
				$this->game->add_event(array('kind' => 'wins','player' => $matches[1],'amount' => $this->cash_to_d($matches[2])));
				break;

			case (preg_match("/(.*)\s+wins\s+(the|side)\s+pot\s+(#\d+\s+)?\((".self::CASH.")\)/", $line, $matches)? true : false):
				$this->game->add_event(array('kind' => 'wins','player' => $matches[1],'amount' => $this->cash_to_d($matches[4])));
				break;

			case (preg_match("/^(.*)\s+adds\s+(".self::CASH.")/i", $line, $matches)? true : false):
			case (preg_match("/Seat\s+[0-9]+:\s+(.*)\s+(\((small blind)|(big blind)|(button)\) )?(.*)$/i", $line, $matches)? true : false):
			case (preg_match("/^(.*):\s+easy\s+call$/", $line, $matches)? true : false):
				//@todo
				break;

			case (preg_match("/^Ante\s+of\s+(".self::CASH.")\s+returned\s+to\s+(.*)$/", $line, $matches)? true : false):
				//@todo
				break;

			case (preg_match("/^(.*):\s+(.*)$/i", $line, $matches)? true : false):
				//print_r($matches);
				/*
				 if (!$this->game->has_player($matches[1]) || !$this->ignorable($line)) {
					throw new Exception("{$this->room_name()} invalid line for parse: {$line}");
					}*/
				break;
			default:
				if (!$this->ignorable($line)) {
					throw new Exception("{$this->room_name()} invalid line for parse: {$line}");
				}

		}
	}

	public function ignorable($line) {

		$regular_expressions_for_ignorable_phrases = array(
				"/(.*) has timed out/",
				"/(.*) has returned/",
				"/(.*) leaves the table/",
				"/(.*) joins the table at seat #[0-9]+/",
				"/(.*) sits out/",
				"/(.*) is sitting out/",
				"/(.*) is (dis)?connected/",
				"/(.*)\s+has\s+been\s+(dis)?connected/i",
				"/(.*)\s+has\s+\d+\s+second(s)?\s+to\s+(re)?connect/i",
				"/(.*)\s+has\s+(re)?connected/i",
				"/(.*)\s+stands\s+up/i",
				"/(.*) said,/",
				"/(.*): doesn't show hand/",
				"/(.*) will be allowed to play after the button/",
				"/(.*) was removed from the table for failing to post/",
				"/(.*) re-buys and receives (.*) chips for (.*)/",
				"/(.*)\s+has\s+\d+\s+seconds\s+left\s+to\s+act/i",
				"/(.*):\s+chasing\s+fool/i",
				"/^(.*)\s+has\s+(requested|registered)/i",
				"/(.*)\s+sits\s+down/i",
				"/^Hand\s+\#\d+\s+has\s+been\s+canceled/",
				"/^(.*)\s+is\s+feeling\s+(happy|confused|angry|normal)/",
				"/^Time\s+has\s+expired/",
				"/Seat\s+\d+:\s+(.*)\s+didn't\s+(bet|raise)/",
				"/Seat [0-9]+: (.*) \(((small)|(big)) blind\) folded on the Flop/",
				"/Seat\s+\d+\:\s+(.*)\s+\(((small)|(big)) blind\)$/",
				"/Seat [0-9]+: (.*) folded on the ((Flop)|(Turn)|(River))/",
				"/Seat [0-9]+: (.*) folded before Flop \(didn't bet\)/",
				"/Seat\s+[0-9]+:\s+(.*)\s+(\((small blind)|(big blind)|(button)\)\s+)?folded\s+before\s+(the\s+)?Flop( \(didn't bet\))?/",
				"/Seat [0-9]+: (.*) (\((small blind)|(big blind)|(button)\) )?collected (.*)/",
				"/Seat\s+\d+:\s+(.*)\s+(button\s+)?mucked\s+/",
				"/Seat\s+\d+:\s+(.*)\s+is\s+sitting\s+out/",
				"/^Seat\s+\d+\:\s+(.*)\s+\(button\)/",
				"/^\d+\s+second(s)?\s+left\s+to\s+act/",
				"/^(.*)\s+\(Observer\)\:\s+(.*)$/i",
				"/^\s*$/"
		);

		return (count(array_filter(array_map(function($pattern,$line){if(preg_match($pattern, $line) != false){return true;}},$regular_expressions_for_ignorable_phrases,array($line)),'strlen'))  > 0);
	}

	public function determine_game($source) {

		switch ($source) {

			case (preg_match("/Hold\'em/i", $source)? true : false):
				return 'HE';
				break;
			case (preg_match("/Omaha\s+Hi\/Lo/i", $source)? true : false):
				return 'OH';
				break;
			case (preg_match("/7\sCard\sStud\sHi\/Lo/i", $source)? true : false):
				return '7S';
				break;
			default:
				throw new Exception('Cannot determine a game');
		}
	}
}