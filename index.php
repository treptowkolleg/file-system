<?php

use App\Setup;
use App\System\FileSystem;

require "vendor/autoload.php";

new Setup();

$fileSystem = new FileSystem("data/");
$fileSystem->readAsStream("test.txt");

