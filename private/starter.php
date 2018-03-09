<?php

global  $rootDir,   $cmsMode, 
        $dbSQL,     $userSQL,   $passSQL;

$cmsMode ?? $cmsMode = "PROD";
// sur un vrai site, on est directement a la racine
$rootDir ?? $rootDir = "";

if ($cmsMode == "DEV")
{
    // mode dev
    error_reporting(E_ALL);
    @ini_set('display_errors', '1');
    @ini_set('log_errors','Off'); // enable or disable php error logging (use 'On' or 'Off')
}

// variables globales
// dossier qui va grouper les fichiers de traitement de formulaire
$cheminController = __DIR__ . "/controller";

$dbSQL      ?? $dbSQL   = "cmsFun";
$userSQL    ?? $userSQL = "root";
$passSQL    ?? $passSQL = "";

// charger les déclarations de mes fonctions
require_once(__DIR__ . "/functions.php");

// controller
traiterForm();

// view
afficherPage($rootDir);