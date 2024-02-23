<?php

namespace War;

require_once('WarDeck.php');

class WarPlayer
{
    public string $playerName = 'プレイヤー';

    public int $playerNum = 1;

    public array $earnedCards = [];

    public function drawCard(WarDeck $deck)
    {
        return $deck->drawCard($deck);
    }
}
