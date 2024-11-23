<?php

namespace App\System;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use ReflectionClass;
use ReflectionException;

class GameSystem
{

    private FileSystem $fileSystem;

    private string $className;
    private ReflectionClass $class;

    #####################
    # Magische Methoden #
    #####################

    /**
     * @param string $class
     * @param string $saveDir
     * @param bool $useUserDir
     * @throws ReflectionException
     */
    public function __construct( string $class, string $saveDir = "savegame", bool $useUserDir = false)
    {
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
            if($email) new MailSystem($email, $serial);
            return $this->fileSystem->putFileContentFromString($this->class->getShortName(), $serial);
        } else {
            return false;
        }
    }

    public function loadGame(): object
    {
        if (!$game = unserialize($this->fileSystem->getFileContentAsString($this->class->getShortName()))) $game = new $this->className();
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