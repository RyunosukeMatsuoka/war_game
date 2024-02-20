<?php

namespace War;

require_once('WarGame.php');
require_once('WarPlayer.php');
require_once('WarDealer.php');
require_once('WarDeck.php');
require_once('WarDecision.php');

$player = new WarPlayer();
$dealer = new WarDealer();
$deck = new WarDeck();
$decision = new WarDecision();

$game = new WarGame($player, $dealer, $deck, $decision);

$game->start();
