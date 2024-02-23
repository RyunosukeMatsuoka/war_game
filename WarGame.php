<?php

namespace War;

require_once('WarPlayer.php');
require_once('WarDeck.php');
require_once('WarDecision.php');
//
class WarGame
{
    public function __construct(public WarDeck $deck, public WarDecision $decision)
    {
    }

    private const DECK_NUM = 52;

    public function start()
    {
        echo '戦争を開始します。' . PHP_EOL;

        $playerNum = 2;

        $players = [];
        //プレイヤー作成
        for ($i = 1; $i <= $playerNum; $i++) {
            $player = new WarPlayer();
            $player->playerNum = $i;
            $player->playerName = $player->playerName . $player->playerNum;
            $players[] = $player;
        }
        //プレイヤーごとに手札を作成
        foreach ($players as $player) {
            for ($i = 0; $i < self::DECK_NUM / count($players); $i++) {
                $card = $player->drawCard($this->deck);
                $cardInfo = $card->getCardInfo();
                $player->earnedCards[] = $cardInfo;
                $cardInfo = [];
            }
        }
        echo 'カードが配られました。' . PHP_EOL;
        //もし手札のないプレイヤーがいたら、ファイナルジャッジ！
        //→ディシジョンクラス
        while (true) {
            if ($this->hadCard($players[0]->earnedCards) && $this->hadCard($players[1]->earnedCards)) {
                $cardsInfo = [];
                $allInfo = [];
                while (true) {
                    foreach ($players as $player) {
                        $card = $this->drawCard($player->earnedCards);
                        $cardsInfo[] = $card;
                        $eachInfo[] = array_merge([$player->playerName], $card);
                    }

                    $allInfo[] = $eachInfo;

                    $this->showCard($eachInfo);

                    $winner = $this->decision->decideWinner($eachInfo);

                    if (is_string($winner)) {
                        $this->showResult($winner, $cardsInfo);

                        $this->winCards($winner, $cardsInfo, $players);

                        shuffle($player->earnedCards);
                        foreach ($players as $player) {
                            array_shift($player->earnedCards);
                        }

                        $eachInfo = [];
                        $allInfo = [];
                        $cardsInfo = [];
                        break;
                    } else {
                        foreach ($players as $player) {
                            array_shift($player->earnedCards);
                        }
                        
                        //もしプレイヤーの手札がなかったら補充する
                        $eachInfo = [];
                        echo '引き分けです。' . PHP_EOL;
                        if (count($players[0]->earnedCards) === 0) {
                            break;
                        } elseif (count($players[1]->earnedCards) === 0) {
                            break;
                        }
                    }
                }
            } else {
                $this->showFinalResult($players);
                break;
            }
        }
    }

    public function drawCard($cards)
    {
        return array_shift($cards);
    }

    private function showCard(array $eachInfo): void
    {
        echo '戦争！' . PHP_EOL;
        foreach ($eachInfo as $info) {
            echo "{$info[0]}の引いたカードは{$info[1]}の{$info[2]}です。" . PHP_EOL;
        }
    }

    private function showResult(string $winner, array $cardsInfo): void
    {
        echo "{$winner}が勝ちました。";
        $earnedNum = count($cardsInfo);
        echo "{$winner}はカードを{$earnedNum}枚もらいました" . PHP_EOL;
    }

    private function winCards(string $winner, array $cardsInfo, array $players)
    {
        foreach ($players as $player) {
            if ($winner === $player->playerName) {
                foreach ($cardsInfo as $info) {
                    //プレイヤーごとのstockに保存
                    $player->earnedCards = array_merge($player->earnedCards, [$info]);
                }
            }
        }
    }

    private function showFinalResult($players): void
    {
        foreach ($players as $player) {
            if (count($player->earnedCards) === 0) {
                echo $player->playerName . 'の手札がなくなりました。' . PHP_EOL;
            }
        }

        foreach ($players as $player) {
            echo $player->playerName . 'の手札の枚数は' . count($player->earnedCards) . '枚です。';
        }
        echo PHP_EOL;

        foreach ($players as $player) {
            $card[] = count($player->earnedCards);
        }

        if ($card[0] > $card[1]) {
            echo 'プレイヤー1が1位、プレイヤー2が2位です。' . PHP_EOL;
        } elseif ($card[0] < $card[1]) {
            echo 'プレイヤー2が1位、プレイヤー1が2位です。' . PHP_EOL;
        }

        echo '戦争を終了します。' . PHP_EOL;
    }


    private function hadCard(array $earnedCards): bool
    {
        if (count($earnedCards) !== 0) {
            return true;
        } else {
            return false;
        }
    }
}
