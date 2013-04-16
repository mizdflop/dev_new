<?php

namespace Poker\Parser;


class Parser {

	public static function parse($source) {

		if (!is_array($source)) {
			if (file_exists($source)) {
				$source = preg_split('/\\r\\n?|\\n/', file_get_contents($source));
			} else {
				$source = preg_split('/\\r\\n?|\\n/', $source);
			}
		} else {
			$source = $source;
		}		
		
		$line = $source[0];
		
		switch ($line) {
			
			case (preg_match("/^PokerStars\s+Game/i", $line)? true : false):
				$parser = new \Poker\Parser\PokerStars($source);
				break;	

			case (preg_match("/^Full\s+Tilt\s+Poker/i", $line)? true : false):
				$parser = new \Poker\Parser\FullTilt($source);
				break;		
						
			case (preg_match("/^Redstar/", $line)? true : false):
				throw new NotImplementedException('Redstar');
				break;

			case (preg_match("/^UltimateBet/", $line)? true : false):
				throw new NotImplementedException('UltimateBet');
				break;

			case (preg_match("/^\*+\s+Hand\s+History\s+for\s+Game\s+\d+\s+\*+/i", $line)? true : false):
				$parser = new \Poker\Parser\PartyPoker($source);
				break;
			default:
				throw new NotImplementedException('History doesnt support');								
		}

		$parser->parse();
		
		return $parser;
	}
}