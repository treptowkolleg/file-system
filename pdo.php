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
select name, wohnort
from lehrkraft
    order by wohnort, name
SQL;

$db = new Database($host, $user, $pass, $db);

$result = $db->setQuery($query)->fetchAll(PDO::FETCH_OBJ, Lehrkraft::class);

foreach ($result as $lehrkraft) {
    /**
     * @var Lehrkraft $lehrkraft
     */
    echo $lehrkraft->getName() . ", wohnend in " . $lehrkraft->getWohnort() . "\n";
}








