<?php

namespace App\System;

class FileSystem
{

    private string $path;

    public function __construct(string $path) {

        $path = trim($path,"/");
        if(!is_dir($dirPath = ROOT_PATH.$path)){
            if(!mkdir($dirPath, recursive: true)) {
                exit("Fehler beim Erstellen des Ordners $dirPath");
            }
        }
        $this->path = str_replace("/", DIRECTORY_SEPARATOR, $dirPath.DIRECTORY_SEPARATOR);
    }

    public function readAsStream(string $file): void
    {
        $handle = fopen($path = $this->getFilePath($file), "rb");
        if(!$handle) exit("Kann Datei nicht öffnen: ".$path);

        $i = 1;
        while(!feof($handle)) {
            echo $i . ": " . fgets($handle);
            $i++;
        }
        fclose($handle);
    }

    public function writeAsStrem(string $file, string $content = ""): bool|int
    {
        $handle = fopen($path = $this->getFilePath($file), "wb");
        if(!$handle) exit("Kann Datei nicht schreiben: ".$path);

        $bytesWritten = fputs($handle, $content);
        fclose($handle);
        return $bytesWritten;
    }

    public function getFileContentAsArray(string $file, bool $skipEmptyLines = true): bool|array
    {
        $filePath = $this->getFilePath($file);

        if(!file_exists($filePath)) return false;
        if($skipEmptyLines) return file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        else return file($filePath, FILE_IGNORE_NEW_LINES);
    }

    public function getFileContentAsString(string $file, bool $skipEmptyLines = true): bool|string
    {
        $filePath = $this->getFilePath($file);

        if(!file_exists($filePath)) return false;
        if($skipEmptyLines) return file_get_contents($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        else return file_get_contents($filePath, FILE_IGNORE_NEW_LINES);
    }

    public function putFileContentFromArray(string $file, array $content): bool|int
    {
        return file_put_contents($this->getFilePath($file), implode("\n", $content) );
    }

    public function putFileContentFromString(string $file, string $content): bool|int
    {
        return file_put_contents($this->getFilePath($file), $content);
    }

    public function getFilePath(string $file): string
    {
        return $this->path.$file;
    }

    public function getPath(): string
    {
        return $this->path;
    }

}