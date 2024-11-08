<?php

use App\Setup;
use App\System\FileSystem;

require "vendor/autoload.php";

new Setup();

$fileSystem = new FileSystem("data/");

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