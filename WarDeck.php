<?php

namespace War;

require_once('WarCard.php');

class WarDeck
{
    private array $cards;

    public const CARD_NUM = ['A', 'K', 'Q', 'J', '10', '9', '8', '7', '6', '5', '4', '3', '2'];

    public function __construct()
    {
        foreach (['クラブ', 'ハート', 'スペード', 'ダイヤ'] as $suit) {
            foreach (self::CARD_NUM as $num) {
                $cards[] = new WarCard($suit, $num);
            }
        }

        //デッキをシャッフルする
        shuffle($cards);
        $this->cards = $cards;
    }

    //カードを引く
    public function drawCard(): object
    {
        return array_shift($this->cards);
    }
}
