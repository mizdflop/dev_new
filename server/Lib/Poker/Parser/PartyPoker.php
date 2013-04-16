<?php 

namespace Poker\Parser;


class PartyPoker extends \Poker\Parser\Base implements \Poker\Parser\IParser {

	public function room_name(){
		return 'PartyPoker';
	}

	public function parse_line($line) {

		switch ($line) {
			
			case (preg_match("/\*+\s+Hand\s+History\s+for\s+Game\s+(\d+)\s+\*+/i", $line, $matches)? true : false):
				$this->game->update(array('id' => $mathes[1],'title' => 'PartyPoker'));
				break;			
				
			case (preg_match("/(#{CASH})\s+NL\s+Texas\s+Hold'em\s+\-\s+(.*)$/i", $line, $matches)? true : false):
				$this->game->update(array('date' => $this->parse_date($matches[2]),'stakes_type' => $this->cash_to_d($matches[1]),'limit' => 'NL'));
				break;
				
			case (preg_match("/(#{CASH})\s+(USD\s+)?(NL|PL)\s+(.+)\s+\-\s+(.*)$/i", $line, $matches)? true : false):
				$this->game->update(array('date' => $this->parse_date($matches[5]),'stakes_type' => $this->cash_to_d($matches[1]),'limit' => $matches[3],'description' => $matches[4]));
				break;
			
			case (preg_match("/^Tourney\s+(Hand\s+)?(NL|PL)\s+(.+)\s+\-\s+(.*)$/i", $line, $matches)? true : false):
				$this->game->update(array('date' => $this->parse_date($matches[4]),'limit' => $matches[2]));
				break;
			
			case (preg_match("/^Table (.*)$/", $line, $matches)? true : false):
				$this->game->update(array('table_name' => $matches[1]));
				break;
			
			case (preg_match("/^Seat (\d+) is the button/", $line, $matches)? true : false):
				$this->game->update(array('button_seat' => $matches[1]));
				break;
			
			case (preg_match("/^Total number of players\s*:\s*(\d+)/", $line, $matches)? true : false):
				$this->game->update(array('max_players' => $matches[1]));
				break;
			
			case (preg_match("/^Seat\s+(\d+)\:\s+(.+)\s+\(\s*(#{CASH})\s*(USD\s+)?\)/", $line, $matches)? true : false):
				$this->game->add_player(array('name' => $matches[2],'seat' => $matches[1],'chips' => $this->cash_to_d($matches[3])));				
				break;
			
			case (preg_match("/(.*)\s+posts\s+(small|big)\s+blind\s+\[(#{CASH})(\s+USD)?\]/", $line, $matches)? true : false):
				$this->game->add_event(array('kind' => $matches[2],'amount' => $this->cash_to_d($matches[3]),'player' => $amtches[1]));
				break;

			case (preg_match("/\*+\s+Dealing down cards\s+\*+/", $line, $matches)? true : false):
				$this->game->add_action(array('kind' => 'preflop'));
				break;
				
			case (preg_match("/^Dealt to\s+(\w+)\s+\[([^\]]+)\]/", $line, $matches)? true : false):
				$this->game->dealt($matches[1], $matches[2]);
				break;
				
			case (preg_match("/(.+)\s+posts\s+ante\s+(of\s+)?\[(#{CASH})(\s+USD)?\]/", $line, $matches)? true : false):
				$this->game->add_event(array('kind' => 'ante','amount' => $this->cash_to_d($matches[3]),'player' => $matches[1]));
				break;
			
			case (preg_match("/(.+)\s+(folds|checks)/", $line, $matches)? true : false):
				$this->game->add_event(array('kind' => $matches[2],'player' => $matches[1]));
				break;
						
			case (preg_match("/(.+)\s+(calls|bets)\s+\[([0-9$,.]+)(\s+USD)?\]/", $line, $matches)? true : false):
				$this->game->add_event(array('kind' => $matches[2],'player' => $matches[1],'amount' => $this->cash_to_d($matches[3])));
				break;
						
			case (preg_match("/(.+)\s+raises\s+\[([0-9$,.]+)(\s+USD)?\]/", $line, $matches)? true : false):
				$this->game->add_event(array('kind' => 'raises', 'player' => $matches[1], 'amount' => $this->cash_to_d($matches[2])));
				break;
						
			case (preg_match("/\*+\s+Dealing Flop\s+\*+\s+\[(.*)\]/", $line, $matches)? true : false):
				$this->game->add_action(array('kind' => 'flop','cards' => $matches[1]));
				break;
						
			case (preg_match("/(.+)\s+is\s+all-in/i", $line, $matches)? true : false):
				$this->game->add_event(array('kind' => 'all-in','player' => $matches[1]));
				break;
						
			case (preg_match("/\*+\s+Dealing Turn\s+\*+\s+\[(.*)\]/", $line, $matches)? true : false):
				$this->game->add_action(array('kind' => 'turn','cards' => $matches[1]));
				break;
						
			case (preg_match("/\*+\s+Dealing River\s+\*+\s+\[(.*)\]/", $line, $matches)? true : false):
				$this->game->add_action(array('kind' => 'river','cards' => $matches[1]));
				break;
				
			case (preg_match("/(.*)\s+shows \[(.*)\]/", $line, $matches)? true : false):
				$this->game->add_event(array('kind' => 'shows','player' => $matches[1],'cards' => $matches[2]));
				break;

			case (preg_match("/(.*)\s+wins\s+(#{CASH})\s+from\s+the\s+(side|main)?\s+pot/, /(.*)\s+wins\s+([0-9,.$]+)(\s+USD)?/", $line, $matches)? true : false):
				$this->game->add_event(array('kind' => 'wins', 'player' => $matches[1], 'amount' => $this->cash_to_d($matches[2])));
				break;
				
			case (preg_match("/(.*)\s+doesn't\s+show(\s+\[(.*)\])?/", $line, $matches)? true : false):
				$this->game->add_event(array('kind' => 'not_show','player' => $matches[1],'cards' => $matches[3]));
				break;
				
			case (preg_match("/^(.*):\s+(.*)$/i", $line, $matches)? true : false):
				break;
			default:
				if (!$this->ignorable($line)) {
					throw new \Exception("{$this->room_name()} invalid line for parse: {$line}");
				}

		}
	}

	public function ignorable($line) {

		$regular_expressions_for_ignorable_phrases = array(
			"/^>/"
		);

		return (count(array_filter(array_map(function($pattern,$line){if(preg_match($pattern, $line) != false){return true;}},$regular_expressions_for_ignorable_phrases,array($line)),'strlen'))  > 0);
	}

	public function determine_game($source) {

		switch ($source) {

			case (preg_match("/Hold'em\s+\-\s+/", $source)? true : false):
			case (preg_match("/Hold'em[^\n]*Trny:\d+/", $source)? true : false):
				return 'HE';
				break;
			case (preg_match("/Omaha\s+\-\s+/i", $source)? true : false):
			case (preg_match("/Omaha Hi\/Lo/i", $source)? true : false):				
				return 'OH';
				break;
			case (preg_match("/7\s+Stud\s+Hi\/Lo/i", $source)? true : false):				
			case (preg_match("/7\s+Card\s+Stud\s+\-\s+/i", $source)? true : false):
				return '7S';
				break;
			default:
				throw new \Exception('Cannot determine a game');
		}
	}
}