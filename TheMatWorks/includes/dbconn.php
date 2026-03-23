<?php

/* This code is the connection of the DB (DataBase) */

$host = 'localhost';
$dbname = 'thematworks';
$username = 'cheekybugger';
$password = 'unlock'; 

/* The pointer to the data source */

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

/* Errors,Default fetch = AA, Emulation off */

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       
    PDO::ATTR_EMULATE_PREPARES   => false,                  
];

/* DB connection and Error Handling */

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
?>