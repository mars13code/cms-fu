<?php
/*
Header add Access-Control-Allow-Origin "*"
Header add Access-Control-Allow-Headers "origin, x-requested-with, content-type, Authorization"
Header add Access-Control-Allow-Methods "PUT, GET, POST, DELETE, OPTIONS"


*/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: origin, x-requested-with, content-type, Authorization");
header("Access-Control-Allow-Origin: PUT, GET, POST, DELETE, OPTIONS");

$formGoal = filtrer("--formGoal");
traiterForm($formGoal);

$dossierUpload = $GLOBALS["dossierCMS"] . "/projet/upload";

if (isset($_FILES["file"]) && ($_FILES["file"]["error"] == 0))
{
    extract($_FILES["file"]);
    file_put_contents("$dossierUpload/toto.log", json_encode($_FILES["file"]));
    move_uploaded_file($tmp_name, "$dossierUpload/$name");
}

var_dump($_FILES);