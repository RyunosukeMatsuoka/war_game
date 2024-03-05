<?php

namespace War;

require_once('WarGame.php');
require_once('WarDeck.php');
require_once('WarDecision.php');

$deck = new WarDeck();
$decision = new WarDecision();

$game = new WarGame($deck, $decision);

$players = $game->start();

$game->battle($players);
