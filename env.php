<?php

$env = getenv();

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
