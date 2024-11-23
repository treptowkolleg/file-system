<?php

/*
 * Folgender Code kann an beliebiger Stelle ausgeführt werden,
 * um das Root-Verzeichnis zu definieren:
 */

# Prüfen, ob Konstante noch nicht definiert ist:
if(!defined('ROOT')) {

    # 1. Dateiname des Startskripts:
    $startFile = $_SERVER['PHP_SELF'];

    # 2. Ordner des Startskripts:
    $startFileDir = dirname($startFile);

    # 3. Absoluter Pfad zum Ordner
    $rootPath = realpath($startFileDir);

    # 4. Slash am Ende anfügen
    $completePath = $rootPath . DIRECTORY_SEPARATOR;

    # 5. Konstante definieren
    define('ROOT', $completePath);
}