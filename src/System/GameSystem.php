<?php

namespace App\System;

use ReflectionClass;
use ReflectionException;

class GameSystem
{

    private FileSystem $fileSystem;
    private string $fileExtension;
    private string $className;
    private ReflectionClass $class;

    #####################
    # Magische Methoden #
    #####################

    /**
     * @param string $class
     * @param string $saveDir
     * @param bool $useUserDir
     * @param string $fileExtension
     * @throws ReflectionException
     */
    public function __construct( string $class, string $saveDir = "savegame", bool $useUserDir = false, string $fileExtension = ".txt" )
    {
        if (!defined("ROOT_PATH")) {
            define("ROOT_PATH", realpath(dirname($_SERVER['PHP_SELF'])) . DIRECTORY_SEPARATOR);
        }
        # Lade Konfiguration aus der Environment-Datei
        $envFileSystem = new FileSystem(ROOT_PATH);
        $file = null;
        if(file_exists(ROOT_PATH . ".env.local")) {
            $file = $envFileSystem->getFileContentAsArray(".env.local");

        } elseif(file_exists(ROOT_PATH . ".env")) {
            $file = $envFileSystem->getFileContentAsArray(".env");
        }
        echo "\nErfasste Umgebungsvariablen:\n";
        foreach ($file as $line) {
            if ($line[0] != "#") {
                echo $line . PHP_EOL;
                putenv($line);
            }
        }

        $this->fileSystem = new FileSystem($saveDir, $useUserDir);
        $this->fileExtension = $fileExtension;
        $this->className = $class;
        $this->class = new ReflectionClass($class);
    }

    ###############
    # Save & Load #
    ###############

    public function saveGame(object $object, string $email = null): bool|int
    {
        if($object instanceof $this->className) {
            $serial = serialize($object);
            $bytesWritten = $this->fileSystem->putFileContentFromString($file = $this->class->getShortName().$this->fileExtension, $serial);
            if($email) new MailSystem($email, $this->fileSystem->getFilePath($file));
            return $bytesWritten;
        } else {
            return false;
        }
    }

    public function loadOrInitGame(): object
    {
        if (!$game = unserialize($this->fileSystem->getFileContentAsString($this->class->getShortName().$this->fileExtension))) $game = new $this->className();
        return $game;
    }

    #####################
    # Getter und Setter #
    #####################

    public function getFileSystem(): FileSystem
    {
        return $this->fileSystem;
    }

}