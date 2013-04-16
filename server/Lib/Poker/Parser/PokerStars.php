<?php 

namespace Poker\Parser;


class PokerStarts extends \Poker\Parser\Base implements \Poker\Parser\IParser {

	public function room_name(){
		return 'PokerStars';
	}

	public function parse_line($line) {

		switch ($line) {
			
			case (preg_match("/PokerStars Game #([0-9]+): Tournament #([0-9]+), (".self::CASH.")\+(".self::CASH.") Hold'em (Pot |No |)Limit - Level ([IVXL]+) \((".self::CASH.")\/(".self::CASH.")\) - (.*)$/", $line, $matches) ? true :false):
				$this->game->update(array(
					'id' => $matches[1],
					'title' => 'PokerStars',
					'date' => $this->parse_date($matches[9]),
					'description' => "#{$matches[2]}, {$matches[3]}/#{$matches[4]} Hold'em #{$matches[5]} Limit",
					'tournament' => $matches[2],
					'stakes_type' => $this->cash_to_d($matches[3]),
					'limit' => $this->parse_limit_type($matches[5]),
					'blinds_amounts' => array('sb' => $this->cash_to_d($matches[7]),'bb' => $this->cash_to_d($matches[8]),'ante' => 0.0)
				));				
				break;

			case (preg_match("/PokerStars Game #([0-9]+): Tournament #([0-9]+), (Freeroll|(".self::CASH.")\+(".self::CASH.") *(USD)?) +Hold'em (Pot |No |)Limit -.*Level ([IVXL]+) \((".self::CASH.")\/(".self::CASH.")\) - (.*)$/", $line, $matches) ? true :false):
				$this->game->update(array(
					'id' => $matches[1],
					'title' => 'PokerStars',
					'date' => $this->parse_date($matches[11]),
					'description' => "#{$matches[2]}, {$matches[3]} Hold'em #{$matches[7]} Limit",
					'tournament' => $matches[2],
					'stakes_type' => $this->cash_to_d($matches[4]),
					'limit' => $this->parse_limit_type($matches[7]),
					'blinds_amounts' => array('sb' => $this->cash_to_d($matches[9]),'bb' => $this->cash_to_d($matches[10]),'ante' => 0.0)
				));				
				break;	
				
			case (preg_match("/PokerStars Game #([0-9]+): Tournament #([0-9]+), (Freeroll|(".self::CASH.").*(FPP)) *(USD)? +Hold'em (Pot |No |)Limit -.*Level ([IVXL]+) \((".self::CASH.")\/(".self::CASH.")\) - (.*)$/", $line, $matches) ? true :false):
				$this->game->update(array(
					'id' => $matches[1],
					'title' => 'PokerStars',
					'date' => $this->parse_date($matches[11]),
					'description' => "#{$matches[2]}, {$matches[3]} Hold'em #{$matches[7]} Limit",
					'tournament' => $matches[2],
					'limit' => $this->parse_limit_type($matches[7]),
					'blinds_amounts' => array('sb' => $this->cash_to_d($matches[9]),'bb' => $this->cash_to_d($matches[10]),'ante' => 0.0)
				));				
				break;
				
			case (preg_match("/PokerStars Game #([0-9]+): +([^(]*)Hold'em (No |Pot |)Limit \((".self::CASH.")\/(".self::CASH.")\) - (.*)$/", $line, $matches) ? true :false):
				$this->game->update(array(
					'id' => $matches[1],
					'title' => 'PokerStars',
					'date' => $this->parse_date($matches[6]),
					'description' => "#{$matches[2]}Hold'em #{$matches[3]}Limit (#{$matches[4]}/#{$matches[5]})",
					'tournament' => $matches[2],
					'stakes_type' => $this->cash_to_d($matches[5]),
					'limit' => $this->parse_limit_type($matches[3]),
					'blinds_amounts' => array('sb' => $this->cash_to_d($matches[4]),'bb' => $this->cash_to_d($matches[5]),'ante' => 0.0)
				));
				break;
							
			case (preg_match("/PokerStars Game #([0-9]+): +([^(]*)Hold'em (No |Pot |)Limit \((".self::CASH.")\/(".self::CASH.") USD\) - (.*)$/", $line, $matches) ? true :false):
				$this->game->update(array(
					'id' => $matches[1],
					'title' => 'PokerStars',
					'date' => $this->parse_date($matches[6]),
					'description' => "#{$matches[2]}Hold'em #{$matches[3]}Limit (#{$matches[4]}/#{$matches[5]})",
					'tournament' => $matches[2],
					'stakes_type' => $this->cash_to_d($matches[5]),
					'limit' => $this->parse_limit_type($matches[3]),
					'blinds_amounts' => array('sb' => $this->cash_to_d($matches[4]),'bb' => $this->cash_to_d($matches[5]),'ante' => 0.0)
				));				
				break;
				
			case (preg_match("/PokerStars\s+Game\s+\#(\d+)\:\s+Omaha\s+(No |Pot |)Limit\s+\(([0-9,.$]+)\/([0-9,.$]+)\s+USD\)\s+-\s+(.*)$/", $line, $matches) ? true :false):
				$this->game->update(array(
					'id' => $matches[1],
					'title' => 'PokerStars',
					'date' => $this->parse_date($matches[5]),
					'description' => "Omaha #{$matches[2]}Limit (#{$matches[3]}/#{$matches[4]})",
					'stakes_type' => $this->cash_to_d($matches[4]),
					'limit' => $this->parse_limit_type($matches[2]),
					'blinds_amounts' => array('sb' => $this->cash_to_d($matches[3]),'bb' => $this->cash_to_d($matches[4]),'ante' => 0.0)
				));				
				break;
				
			case (preg_match("/PokerStars Game #([0-9]+):/", $line, $matches) ? true :false):
				throw new \Exception("invalid hand record: #{$line}");
				break;

			case (preg_match("/\*\*\* HOLE CARDS \*\*\*/", $line, $matches) ? true :false):
				$this->game->add_action(array('kind' => 'preflop'));
				break;

			case (preg_match("/\*\*\* FLOP \*\*\* \[(.*)\]/", $line, $matches) ? true :false):
				$this->game->add_action(array('kind' => 'flop','cards' => $matches[1]));
				break;

			case (preg_match("/\*\*\* TURN \*\*\* \[([^\]]*)\] \[([^\]]*)\]/", $line, $matches) ? true :false):
				$this->game->add_action(array('kind' => 'turn','cards' => $matches[1]));
				break;

			case (preg_match("/\*\*\* RIVER \*\*\* \[([^\]]*)\] \[([^\]]*)\]/", $line, $matches) ? true :false):
				$this->game->add_action(array('kind' => 'river','cards' => $matches[2]));
				break;

			case (preg_match("/\*\*\* SHOW DOWN \*\*\*/", $line, $matches) ? true :false):
				$this->game->add_action(array('kind' => 'showdown','cards' => $matches[3]));
				break;

			case (preg_match("/\*\*\* SUMMARY \*\*\*/", $line, $matches) ? true :false):
				break;

			case (preg_match("/Dealt to ([^)]+) \[([^\]]+)\]/", $line, $matches) ? true :false):
				$this->game->dealt($matches[1],$matches[2]);
				break;
				
			case (preg_match("/(.*): shows \[(.*)\]/", $line, $matches) ? true :false):
				$this->game->add_event(array('kind' => 'shows','player' => $matches[1],'cards' => $matches[2]));
				break;
					
			case (preg_match("/Board \[(.*)\]/", $line, $matches) ? true :false):
				$this->game->update(array('board' => $matches[1]));
				break;
				
			case (preg_match("/Total pot (".self::CASH.") (((Main)|(Side)) pot(-[0-9]+)? (".self::CASH."). )*\| Rake (".self::CASH.")/", $line, $matches) ? true :false):
				$this->game->update(array('total_pot' => $this->cash_to_d($matches[1]),'rake' => $this->cash_to_d($matches[8])));
				break;
							
			case (preg_match("/Total pot (".self::CASH.") Main pot (".self::CASH.").( Side pot-[0-9]+ (".self::CASH.").)* | Rake (".self::CASH.")/", $line, $matches) ? true :false):
				throw new \Exception("popo!");
				break;
								
			case (preg_match("/Seat ([0-9]+): (.+) \((".self::CASH.") in chips\)( is sitting out)?/", $line, $matches) ? true :false):
				$this->game->add_player(array('name' => $matches[2],'seat' => $matches[1],'chips' => $this->cash_to_d($matches[3])));
				break;
										
			case (preg_match("/(.*): posts (small|big|small\s\&\sbig) blind(s)? (".self::CASH.")/", $line, $matches) ? true :false):
				$this->game->add_event(array('kind' => $matches[2],'amount' => $this->cash_to_d($matches[4]),'player' => $matches[1]));
				break;
										
			case (preg_match("/(.*): posts the ante (".self::CASH.")/", $line, $matches) ? true :false):
				$this->game->add_event(array('kind' => 'ante','amount' => $this->cash_to_d($matches[2]),'player' => $matches[1]));
				break;
													
			case (preg_match("/Table '(.*)' ([0-9]+)-max Seat #([0-9]+) is the button/", $line, $matches) ? true :false):
				$this->game->update(array('table_name' => $matches[1],'max_players' => $matches[2],'button_seat' => $matches[3]));
				break;
												
			case (preg_match("/Uncalled bet \((.*)\) returned to (.*)/", $line, $matches) ? true :false):
				break;
														
			case (preg_match("/(.+): (folds|checks)/", $line, $matches) ? true :false):
				$this->game->add_event(array('kind' => $matches[2],'player' => $matches[1]));
				break;
														
			case (preg_match("/(.+): (calls|bets) ((".self::CASH.")( and is all-in)?)?$/", $line, $matches) ? true :false):
				$this->game->add_event(array('kind' => $matches[2],'player' => $matches[1],'amount' => $this->cash_to_d($matches[4])));
				break;
																	
			case (preg_match("/(.+): raises (".self::CASH.") to (".self::CASH.")( and is all-in)?$/", $line, $matches) ? true :false):
				$this->game->add_event(array('kind' => 'raises','player' => $matches[1],'amount' => $this->cash_to_d($matches[3])));
				break;
																
			case (preg_match("/(.*) collected (.*) from ((side )|(main ))?pot/", $line, $matches) ? true :false):
				$this->game->add_event(array('kind' => 'wins','player' => $matches[1],'amount' => $this->cash_to_d($matches[2])));
				break;
				
			case (preg_match("/(.*): doesn't show hand/", $line, $matches) ? true :false):
				$this->game->add_event(array('kind' => 'not_show','player' => $matches[1]));
				break;
						
			case (preg_match("/(.*): mucks hand/", $line, $matches) ? true :false):
				$this->game->add_event(array('kind' => 'mucks','player' => $matches[1]));
				break;
				
			case (preg_match("/Seat [0-9]+: (.*) (\((small blind)|(big blind)|(button)\) )?showed \[([^\]]+)\] and ((won) \(".self::CASH."\)|(lost)) with (.*)/", $line, $matches) ? true :false):
				break;
					
			case (preg_match("/Seat [0-9]+: (.*) mucked \[([^\]]+)\]/", $line, $matches) ? true :false):
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
				"/(.*) has timed out/",
				"/(.*) has returned/",
				"/(.*) leaves the table/",
				"/(.*) joins the table at seat #[0-9]+/",
				"/(.*) sits out/",
				"/(.*) is sitting out/",
				"/(.*) is (dis)?connected/",
				"/(.*) said,/",
				"/(.*) will be allowed to play after the button/",
				"/(.*) was removed from the table for failing to post/",
				"/(.*) re-buys and receives (.*) chips for (.*)/",
				"/Seat [0-9]+: (.*) \(((small)|(big)) blind\) folded on the Flop/",
				"/Seat [0-9]+: (.*) folded on the ((Flop)|(Turn)|(River))/",
				"/Seat [0-9]+: (.*) folded before Flop \(didn't bet\)/",
				"/Seat [0-9]+: (.*) (\((small blind)|(big blind)|(button)\) )?folded before Flop( \(didn't bet\))?/",
            	"/Seat [0-9]+: (.*) (\((small blind)|(big blind)|(button)\) )?collected (.*)/",
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
				throw new \Exception('Cannot determine a game');
		}
	}
}