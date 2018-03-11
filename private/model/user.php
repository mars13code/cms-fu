<?php

// mode dev
error_reporting(E_ALL);
@ini_set('display_errors', '1');
@ini_set('log_errors', 'Off'); // enable or disable php error logging (use 'On' or 'Off')

$codeSQL = "";

$tabUser = file(__DIR__ . "/user.csv");
foreach ($tabUser as $ligneCSV) {
    $ligneCSV = trim($ligneCSV);
    if ($ligneCSV != "") {
        list($id, $nom, $email, $pass, $level) = explode(",", $ligneCSV);
        // http://php.net/manual/fr/function.password-hash.php
        $passH = password_hash($pass, PASSWORD_DEFAULT);
        $date  = date("Y-m-d H:i:s");

        $codeSQL .= "\n" . "( '$id', '$nom', '$email', '$passH', '$level', '$date' ),";
    }
}
$codeSQL = trim($codeSQL, ",");

$contenuSQL =
    <<<CODESQL
USE `cmsFun`;

INSERT IGNORE INTO User
( id, nom, email, password, level, date )
VALUES
$codeSQL
;

CODESQL;

file_put_contents(__DIR__ . "/user.sql", $contenuSQL);
