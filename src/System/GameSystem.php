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
    public function __construct(string $saveDir = "data/game/save/user", string $file = "save.txt")
    {
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