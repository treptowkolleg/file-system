<?php

$env = getenv();

echo phpinfo(INFO_ENVIRONMENT);

$HOME = false;
if (is_array($env)) {
    # Windows
    if(key_exists("HOMEDRIVE", $env) and array_key_exists("HOMEPATH", $env)) {
        $HOME = $env["HOMEDRIVE"] . $env["HOMEPATH"] . DIRECTORY_SEPARATOR;
    }
    # Linux, MacOS
    if(key_exists("HOME", $env)) {
        $HOME = $env["HOME"] . DIRECTORY_SEPARATOR;
    }
}

if($HOME) {
    echo "Mein Benutzerordner liegt unter $HOME \n";
} else {
    echo "Ich benutze ein sehr ausgefallenes Betriebssystem\n";
}


$publicPath = getenv("PUBLIC");

if($publicPath) {
    $saveDir = $publicPath . DIRECTORY_SEPARATOR . "Documents" . DIRECTORY_SEPARATOR . "Spielstand" . DIRECTORY_SEPARATOR;
} else {
    exit("Dies ist nicht Windows!");
}

# ODER

$env = getenv();
$savePath = "Documents/Spielstand";

if(array_key_exists("PUBLIC", $env)) {
    # Slash vorne und hinten entfernen:
    $savePath = trim($savePath,"/");

    # Slashes durch System-Slashes ersetzen:
    $savePath = str_replace("/", DIRECTORY_SEPARATOR, $savePath);

    # Absoluten Pfad zum Speicherordner zusammensetzen:
    $savePath = $env['PUBLIC'] . DIRECTORY_SEPARATOR . $savePath . DIRECTORY_SEPARATOR;
}


$env = [
    #       array_key       array_value
            "PUBLIC"    =>  "C:\Users\Public",
            "HOMEDRIVE" =>  "C:"
];


enum Path {
    case local;
    case public;
    case custom;
}

class GameSystem {

    private string $path;
    public function __construct(Path $path, string $subDir, string $customEnv = null)
    {
        $path = match ($path) {
            Path::local => $this->getRootPath(),
            Path::public => $this->getPublicPath(),
            Path::custom => $this->getCustomPath($customEnv),
        };
        $this->path = $path . $subDir;
    }

    function getPublicPath(): string
    {
        if ( array_key_exists("PUBLIC", getenv()) ) {
            return getenv("PUBLIC") . DIRECTORY_SEPARATOR;
        }  else {
            exit("Nicht unter Windows!");
        }
    }

    function getRootPath(): string
    {
        if(!defined('ROOT')) {
            $startFile = $_SERVER['PHP_SELF'];
            $startFileDir = dirname($startFile);
            $rootPath = realpath($startFileDir);
            $completePath = $rootPath . DIRECTORY_SEPARATOR;
            define('ROOT', $completePath);
        }
        return ROOT;
    }

    function getCustomPath(string $envKey = null): string
    {
        if ( $envKey != null and array_key_exists($envKey, getenv()) ) {
            return getenv($envKey) . DIRECTORY_SEPARATOR;
        }  else {
            exit("Env-Variable '$envKey' ist nicht definiert.!");
        }
    }

    public function getPath(): string
    {
        return $this->path;
    }

}


$gameSystem = new GameSystem(Path::custom, "Documents/Spielstand", "SAVEG");

