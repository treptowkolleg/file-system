<?php

namespace App;

class Setup
{

    public function __construct()
    {
        // Konstante für Wurzelverzeichnis deklarieren
        if(!defined('ROOT_PATH')) {
            define('ROOT_PATH', dirname(__DIR__).DIRECTORY_SEPARATOR);
        }
    }

}