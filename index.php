<?php

use App\Game;
use App\System\GameSystem;

require "vendor/autoload.php";

$gameSystem = new GameSystem(Game::class,"savegame/s001", true);

$game = $gameSystem->loadOrInitGame();

echo "Hallo {$game->getCharName()}!\n";
$username =readline("Name: ");
if($username != "nein") {
    $game->setCharName($username);
}

$speichern = readline("Speichern: ");
if($speichern == "ja") {
    if($bytesWritten = $gameSystem->saveGame($game, "benjamin.wagner@student.htw-berlin.de")) {
        echo sprintf("Gespeichert. Es wurden %s kB geschrieben.\n\n", round($bytesWritten/1024,2));
    }
}

