<?php

use App\Setup;
use App\System\FileSystem;

require "vendor/autoload.php";

new Setup();

$fileSystem = new Filesystem("data/");
$fileSystem->read("test.txt");