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

$dbSQL      ?? $dbSQL   = "cmsFun";
$userSQL    ?? $userSQL = "root";
$passSQL    ?? $passSQL = "";

//$dossierTheme = "../private";
$dossierTheme = "../projet/theme";

// charger les déclarations de mes fonctions
require_once(__DIR__ . "/model-functions.php");
require_once(__DIR__ . "/view-functions.php");
require_once(__DIR__ . "/controller-functions.php");

// variables globales
// dossiers qui vont grouper les fichiers de traitement de formulaire
// les plugins et les themes pourront ajouter leurs dossiers...
// chemin par defaut du cms
ajouterControllerDir(__DIR__ . "/controller");

startCMS();
