<?php

use App\Game;
use App\Setup;
use App\System\FileSystem;

require "vendor/autoload.php";

new Setup();

$fileSystem = new FileSystem("data/");

$game = null;

if(file_exists("./data/game.txt")) {
    $game = unserialize(file_get_contents("./data/game.txt"));
    echo "Spiel geladen!\n";
}

if(!$game) {
    $game = new Game();
}

echo "Hallo {$game->getCharName()}!\n";

$username =readline("Name: ");
if($username != "nein") {
    $game->setCharName($username);
}
$speichern = readline("Speichern: ");
if($speichern == "ja") {
    file_put_contents("./data/game.txt", serialize($game));
}



if(file_exists("./data/test2.txt")) {
    $spielstand = $fileSystem->getFileAsArray("test2.txt");
} else {
    file_put_contents("./data/test2.txt", "Neuer Spielstand");
}
$saveGameContent = $fileSystem->getFileAsArray("test.txt");

print_r($saveGameContent);

$saveGameContent[] = "Ich bin eine neue Zeile!";

$input = readline("Daten: ");
$saveGameContent[] = $input;

$fileSystem->putFile("test.txt", $saveGameContent);