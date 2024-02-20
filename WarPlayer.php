<?php

namespace War;

require_once('WarDeck.php');

class WarPlayer
{
    public string $userName = "プレイヤー１";

    public int $earnedCards = 0;

    public function drawCard(WarDeck $deck)
    {
        return $deck->drawCard($deck);
    }
}
