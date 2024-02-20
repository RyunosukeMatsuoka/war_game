<?php

namespace War;

require_once('WarDeck.php');

class WarDealer
{
    public string $userName = "プレイヤー２";

    public int $earnedCards = 0;

    public function drawCard(WarDeck $deck)
    {
        return $deck->drawCard($deck);
    }
}
