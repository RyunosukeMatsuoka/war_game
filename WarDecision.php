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
            $cardRanks['ジョーカー'] = 0;
            $this->cardRanks = $cardRanks;
        })());
    }

    public function decideWinner(array $eachInfo)
    {
        $cardRanks = [];
        foreach ($eachInfo as $info) {
            $cardRank = [$this->cardRanks[$info[2]]];
            $nameAndRank[$this->cardRanks[$info[2]]] = $info[0];
            $cardRanks = array_merge($cardRanks, $cardRank);
        }

        sort($cardRanks);

        if ($cardRanks[0] !== $cardRanks[1]) {
            return $nameAndRank[$cardRanks[0]];
        } elseif ($cardRanks[0] === 1 && $cardRanks[1] === 1) {
            //全探索をかけてスペードがあるかどうかたしかめる
            for ($i = 0; $i < count($eachInfo); $i++) {
                if ($eachInfo[$i][1] === 'スペード') {
                    return $eachInfo[$i][0];
                }
            }
        } else {
            return 1;
        }
    }

    public function showFinalResult(array $players): void
    {
        foreach ($players as $player) {
            if (count($player->handCards) + count($player->stockCards) === 0) {
                echo $player->name . 'の手札がなくなりました。' . PHP_EOL;
            }
        }

        for ($i = 0; $i < count($players); $i++) {
            $finalCardNum[$i] = count($players[$i]->handCards) + count($players[$i]->stockCards);
            $nameAndFinalCardNum[$players[$i]->name] = $finalCardNum[$i];
            $stockFinalCardNum[] = $finalCardNum[$i];
            echo $players[$i]->name . 'の手札の枚数は' . $finalCardNum[$i] . '枚です。';
        }
        echo PHP_EOL;

        arsort($nameAndFinalCardNum);

        //並べ替えた順番ごとに順位を表示する
        $j = 0;
        foreach ($nameAndFinalCardNum as $name => $CardNum) {
            $j++;
            if ($j !== count($players)) {
                echo $name . 'が' . $j . '位、';
            } else {
                echo $name . 'が' . $j . '位です。' . PHP_EOL;
            }
        }

        echo '戦争を終了します。' . PHP_EOL;
    }
}
