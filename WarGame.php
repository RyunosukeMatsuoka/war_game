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
            $players[] = clone($player);
        }
        //手札をプレイヤーごとに作成
        foreach ($players as $player) {
            for ($i = 0; $i < self::DECK_NUM / count($players); $i++) {
                $card = $player->drawCard($this->deck);
                $cardInfo = $card->getCardInfo();
                $player->handCards[] = $cardInfo;
                $player->stockCards = [];
                /* $cardInfo = []; */
            }
        }
        echo 'カードが配られました。' . PHP_EOL;

        while (true) {
            if ($this->hadCard($players[0]->handCards) && $this->hadCard($players[1]->handCards)) {
                $cardsInfo = [];
                while (true) {
                    foreach ($players as $player) {
                        $handCard = $this->drawCard($player->handCards);
                        $cardsInfo[] = $handCard;
                        $eachInfo[] = array_merge([$player->playerName], $handCard);
                    }

                    $this->showCard($eachInfo);

                    $winner = $this->decision->decideWinner($eachInfo);

                    if (is_string($winner)) {
                        $this->showResult($winner, $cardsInfo);

                        //勝者が勝ち取ったカードをstockに一時保管
                        $this->stockCards($winner, $cardsInfo, $players);

                        foreach ($players as $player) {
                            array_shift($player->handCards);
                        }

                        //もしプレイヤーの手札がなかったら補充する
                        foreach ($players as $player) {
                            if (count($player->handCards) === 0) {
                                $player->handCards = $player->stockCards;
                                $player->stockCards = [];
                                shuffle($player->handCards);
                            }
                        }

                        $eachInfo = [];
                        $cardsInfo = [];
                        break;
                    } else {
                        foreach ($players as $player) {
                            array_shift($player->handCards);
                        }
                        //もし手札がなかったら補充する
                        //手札もストックもない場合はファイナルジャッジ
                        foreach ($players as $player) {
                            if (count($player->handCards) === 0 && count($player->stockCards) === 0) {
                                    break 2;
                                } elseif (count($player->stockCards) !== 0 && count($player->handCards) === 0) {
                                    $player->handCards = $player->stockCards;
                                    $player->stockCards = [];
                                    shuffle($player->handCards);
                                }
                            }
                    }
                        $eachInfo = [];
                        echo '引き分けです。' . PHP_EOL;
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

    private function stockCards(string $winner, array $cardsInfo, array $players)
    {
        foreach ($players as $player) {
            if ($winner === $player->playerName) {
                foreach ($cardsInfo as $info) {
                    $player->stockCards = array_merge($player->stockCards, [$info]);
                }
            }
        }
    }

    private function showFinalResult($players): void
    {
        foreach ($players as $player) {
            if (count($player->handCards) === 0) {
                echo $player->playerName . 'の手札がなくなりました。' . PHP_EOL;
            }
        }

        foreach ($players as $player) {
            echo $player->playerName . 'の手札の枚数は' . count($player->handCards) + count($player->stockCards) . '枚です。';
        }
        echo PHP_EOL;

        foreach ($players as $player) {
            $finalCardNum[] = count($player->handCards);
        }

        if ($finalCardNum[0] > $finalCardNum[1]) {
            echo 'プレイヤー1が1位、プレイヤー2が2位です。' . PHP_EOL;
        } elseif ($finalCardNum[0] < $finalCardNum[1]) {
            echo 'プレイヤー2が1位、プレイヤー1が2位です。' . PHP_EOL;
        }

        echo '戦争を終了します。' . PHP_EOL;
    }


    private function hadCard(array $cards): bool
    {
        if (count($cards) !== 0) {
            return true;
        } else {
            return false;
        }
    }
}
