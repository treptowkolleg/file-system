<?php

// Zugangsdaten
$host = 'it.wagnerpictures.com';
$db = 'tk01';
$user = 'user';
$pass = 'passwort';

$query = "SELECT * FROM user WHERE firstname = :vorname AND lastname = :nachname";

$parameters = [
    'vorname' => 'Benjamin',
    'nachname' => 'Wagner'
];

// PHP-Database-Objekt instantiieren
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

    // Abfrage vorbereiten
    $statement = $pdo->prepare($query);

    // Parameter zuordnen
    foreach ($parameters as $param => $value) {
        $statement->bindValue($param, $value);
    }

// Abfrage mit Suchparametern ausführen
    $statement->execute();

// Ergebnis in Array speichern
    $result = $statement->fetchAll();

// Array ausgeben
    print_r($result);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "\n";
}





