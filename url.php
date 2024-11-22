<?php


require 'vendor/autoload.php';

$options = [
    "ssl"=>[
        "allow_self_signed"=>true,
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ]
];

$websiteContent = file_get_contents("https://www.treptow-kolleg.de", false, stream_context_create($options));

echo $websiteContent;