<?php

// mode dev
error_reporting(E_ALL);
@ini_set('display_errors', '1');
@ini_set('log_errors', 'Off'); // enable or disable php error logging (use 'On' or 'Off')


$cmsMode = "DEV";

// MODIFIER LE FICHIER .htaccess
// A MODIFIER AUSSI
// configuration pour le site
$rootDir = "/archives/320/public";
$dbSQL   = "cmsFun";

$cmsCLI = true;
require_once __DIR__ . "/../starter.php";

supprimerTable("Hello");

creerTable("Hello");
creerTable("nom".date("His"), "varchar(190)");
creerTable();
