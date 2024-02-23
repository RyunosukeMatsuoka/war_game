<?php

namespace War;

require_once('WarDeck.php');

class WarPlayer
{
    public string $playerName = 'プレイヤー';

    public int $playerNum = 1;

    public array $handCards = [];

    public array $stockCards = [];

    public function drawCard(WarDeck $deck)
    {
        return $deck->drawCard($deck);
    }
}
