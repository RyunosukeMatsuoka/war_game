<?php

namespace War;

require_once('WarDeck.php');
/* require_once('WarUser.php'); */

class WarPlayer
{
    public function __construct(public string $name)
    {
    }

    public int $playerNum = 1;

    public array $handCards = [];

    public array $stockCards = [];

    public function drawCard(WarDeck $deck)
    {
        return $deck->drawCard($deck);
    }
}
