<?php

namespace App\System;

use App\Game;

class GameSystem
{

    private FileSystem $fileSystem;

    private string $saveFile;

    #####################
    # Magische Methoden #
    #####################

    /**
     * @param string $saveDir
     * @param string $file
     */
    public function __construct(string $saveDir = "data/game", string $file = "save.txt")
    {
        if(!is_dir($dirPath = ROOT_PATH.$saveDir)){
            if(!mkdir($dirPath)) {
                exit("Fehler beim Erstellen des Ordners $dirPath");
            }
        }
        // Slash ans Ende anfügen, falls nicht vorhanden
        $saveDir = rtrim($saveDir,"/").'/';

        $this->fileSystem = new FileSystem($saveDir);
        $this->saveFile = $file;
    }

    ###############
    # Save & Load #
    ###############

    public function saveGame(Game $gameObject): bool
    {
        return $this->fileSystem->putFileContentFromString($this->saveFile, serialize($gameObject));
    }

    public function loadGame(): bool|Game
    {
        return unserialize($this->fileSystem->getFileContentAsString($this->saveFile));
    }


}