<?php

// Zugangsdaten
$host = 'it.wagnerpictures.com';
$db = 'tk01';
$user = 'user';
$pass = 'passwort';

// mit der heredoc-Schreibweise können wir unsere Abfrage übersichtlicher notieren:
$query = <<<SQL
SELECT *
FROM user
    WHERE
        firstname = :vorname
    AND lastname = :nachname
SQL;

$parameters = [
    'vorname' => 'Benjamin',
    'nachname' => 'Wagner'
];


try {
    // PHP-Database-Objekt instantiieren
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

    // Abfrage vorbereiten
    $statement = $pdo->prepare($query);

    // Parameter zuordnen
    foreach ($parameters as $param => $value) {
        $statement->bindValue($param, $value);
    }

    // Abfrage mit gebundenen Suchparametern ausführen
    $statement->execute();

    // Ergebnis in Array speichern
    $result = $statement->fetchAll();

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "\n";
}

if(!isset($result)) exit("Das Programm wurde vorzeitig beendet!");

// Nun Ergebnis verarbeiten
print_r($result);




