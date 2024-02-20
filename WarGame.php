<?php

namespace War;

require_once('WarPlayer.php');
require_once('WarDealer.php');
require_once('WarDeck.php');
require_once('WarDecision.php');

class WarGame
{
    public function __construct(public WarPlayer $player, public WarDealer $dealer, public WarDeck $deck, public WarDecision $decision)
    {
    }

    public function start()
    {
        echo '戦争を開始します。' . PHP_EOL;

        echo 'カードが配られました。' . PHP_EOL;
        while (true) {
            $allInfo = [];
            foreach ([$this->player, $this->dealer] as $user) {
                $card = $user->drawCard($this->deck);
                $cardInfo = $card->getCardInfo();
                $allInfo[] = array_merge([$user->userName], $cardInfo);
                $countCards[] = array_merge([$user->userName], $cardInfo);
            }

            $this->showCard($allInfo);

            $winner = $this->decision->decideWinner($allInfo);

            if (is_string($winner)) {
                $this->showResult($winner);
                $this->winCards($winner, $countCards);
                break;
            } else {
                echo '引き分けです。' . PHP_EOL;
            }
        }
    }

    public function showCard(array $allInfo): void
    {
        echo '戦争！' . PHP_EOL;
        foreach ($allInfo as $info) {
            echo "{$info[0]}の引いたカードは{$info[1]}の{$info[2]}です。" . PHP_EOL;
        }
    }

    public function showResult(string $winner): void
    {
        echo "{$winner}が勝ちました。" . PHP_EOL;

        echo '戦争を終了します' . PHP_EOL;
    }

    public function winCards(string $winner, array $countCards): int
    {
        if ($winner === $this->player->userName) {
            return $this->player->earnedCards = count($countCards);
        } elseif ($winner === $this->dealer->userName) {
            return $this->dealer->earnedCards = count($countCards);
        }
    }
}
