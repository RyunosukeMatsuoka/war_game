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

        //プレイヤーの人数、名前を入力する
        echo 'プレイヤーの人数を入力してください（2〜5）:';
        $playerNum = (int) trim(fgets(STDIN));

        $players = [];
        //プレイヤーを作成する
        for ($i = 1; $i <= $playerNum; $i++) {
            echo 'プレイヤー' . $i . 'の名前を入力してください:';
            $name = (string) trim(fgets(STDIN));
            $player = new WarPlayer($name);
            $player->playerNum = $i;
            $players[] = clone($player);
        }
        //手札をプレイヤーごとに作成する
        foreach ($players as $player) {
            for ($i = 0; $i < (self::DECK_NUM - (self::DECK_NUM % count($players))) / count($players); $i++) {
                $card = $player->drawCard($this->deck);
                $cardInfo = $card->getCardInfo();
                $player->handCards[] = $cardInfo;
                $player->stockCards = [];
            }
        }
        echo 'カードが配られました。' . PHP_EOL;
        return $players;
    }

    public function battle(array $players)
    {
        while (true) {
            if (!$this->continueBattle($players)) {
                $this->decision->showFinalResult($players);
                break;
            }
            $cardsInfo = [];
            while (true) {
                foreach ($players as $player) {
                    $handCard = array_shift($player->handCards);
                    $cardsInfo[] = $handCard;
                    $eachInfo[] = array_merge([$player->name], $handCard);
                }

                $this->showCard($eachInfo);

                $winner = $this->decision->decideWinner($eachInfo);

                if (is_string($winner)) {
                    $this->showResult($winner, $cardsInfo);

                    //勝者が勝ち取ったカードをstockに一時保管
                    $this->stockCards($winner, $cardsInfo, $players);

                    //もしプレイヤーの手札がなかったら補充する
                    foreach ($players as $player) {
                        if (!$this->hadCard($player->handCards)) {
                            $this->replenishHand($player);
                        }
                    }

                    $eachInfo = [];
                    $cardsInfo = [];
                    break;
                } else {
                    echo '引き分けです。' . PHP_EOL;
                    $eachInfo = [];
                    //もし手札がなかったら補充する
                    //手札もストックもない場合はファイナルジャッジ
                    foreach ($players as $player) {
                        if (!$this->hadCard($player->handCards) && $this->hadCard($player->stockCards)) {
                            $this->replenishHand($player);
                        } elseif (!$this->hadCard($player->handCards) && !$this->hadCard($player->stockCards)) {
                            break 2;
                        }
                    }
                }
            }
        }
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
            if ($winner === $player->name) {
                foreach ($cardsInfo as $info) {
                    //プレイヤーごとのstockに保存
                    $player->stockCards = array_merge($player->stockCards, [$info]);
                }
            }
        }
    }

    private function hadCard(array $cards): bool
    {
        if (count($cards) !== 0) {
            return true;
        } else {
            return false;
        }
    }

    public function replenishHand(mixed $player): void
    {
        $player->handCards = $player->stockCards;
        $player->stockCards = [];
        shuffle($player->handCards);
    }

    public function continueBattle(array $players): bool
    {
        foreach ($players as $player) {
            if (!$this->hadCard($player->handCards)) {
                return false;
            }
        }
        return true;
    }
}
