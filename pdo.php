<?php

// Zugangsdaten
$host = 'it.wagnerpictures.com';
$db = 'tk01';
$user = 'kvtkberlin';
$pass = 'x1#Y39pf2';

// PHP-Database-Objekt instantiieren
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

    // Abfrage vorbereiten
    $statement = $pdo->prepare("SELECT * FROM user WHERE firstname = :vorname AND lastname = :nachname");

// Parameter vorbereiten
    $params = [
        'vorname' => 'Benjamin',
        'nachname' => 'Wagner'
    ];

    foreach ($params as $param => $value) {
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





