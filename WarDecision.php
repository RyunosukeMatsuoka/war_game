<?php

namespace War;

require_once('WarDeck.php');

class WarDecision
{
    private array $cardRanks;

    public function __construct()
    {
        define('CARD_RANK', (function () {
            $cardRanks = [];
            $rank = 1;
            foreach (WarDeck::CARD_NUM as $cardNum) {
                $cardRanks[$cardNum] = $rank;
                $rank++;
            }
            $this->cardRanks = $cardRanks;
        })());
    }

    public function decideWinner(array $allInfo)
    {
        $cardRanks = [];
        $name = [];
        foreach ($allInfo as $info) {
            $numInfo = [$this->cardRanks[$info[2]]];
            $cardRanks = array_merge($cardRanks, $numInfo);
            $name[] = $info[0];
        }

        if ($cardRanks[0] < $cardRanks[1]) {
            return $name[0];
        } elseif ($cardRanks[0] > $cardRanks[1]) {
            return $name[1];
        } else {
            return 1;
        }
    }
}
