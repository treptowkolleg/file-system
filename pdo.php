<?php


use App\Entity\Lehrkraft;
use App\Model\Database;

require 'vendor/autoload.php';


// Zugangsdaten
$host = 'it.xxx.com';
$db = 'xxx';
$user = 'xxx';
$pass = 'xxx';

$query = <<<SQL
select *
from lehrkraft
    order by wohnort, name
SQL;

$db = new Database($host, $user, $pass, $db);

$results = $db->fetchAllAsObject(Lehrkraft::class);

foreach ($results as $lehrkraft) {
    /**
     * @var Lehrkraft $lehrkraft
     */
    echo "{$lehrkraft->getName()}, geboren in {$lehrkraft->getWohnort()} im Jahr {$lehrkraft->getGeburtsjahr()->format("Y")}\n";
}








