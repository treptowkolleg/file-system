<?php

enum Path {
    case localDir;
    case publicDir;
    case customDir;
}

class GameSystem {

    private string $path;
    public function __construct(Path $path, string $subDir, string $customEnv = null)
    {
        $path = match ($path) {
            Path::localDir => $this->getRootPath(),
            Path::publicDir => $this->getPublicPath(),
            Path::customDir => $this->getCustomPath($customEnv),
        };
        $this->path = $path;
        $this->initSubDir($subDir);
    }

    private function getPublicPath(): string
    {
        return $this->getCustomPath("PUBLIC");
    }

    private function getRootPath(): string
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

    private function getCustomPath(string $envKey = null): string
    {
        if ( $envKey != null and array_key_exists($envKey, getenv()) ) {
            return getenv($envKey) . DIRECTORY_SEPARATOR;
        }  else {
            # Fallback
            return $this->getRootPath();
        }
    }

    private function initSubDir(string $subDir): void
    {
        $path = trim($subDir,"/");
        if(!is_dir($dirPath = $this->path . $path)){
            if(!mkdir($dirPath, recursive: true)) {
                exit("Fehler beim Erstellen des Ordners $dirPath");
            }
        }
        $this->path = str_replace("/", DIRECTORY_SEPARATOR, $dirPath.DIRECTORY_SEPARATOR);
    }

    # GETTER

    public function getPath(): string
    {
        return $this->path;
    }

}


$gameSystem = new GameSystem(Path::customDir, "Documents/Spielstand", "SAVEG");

echo $gameSystem->getPath();

