<?php
/*
Header add Access-Control-Allow-Origin "*"
Header add Access-Control-Allow-Headers "origin, x-requested-with, content-type, Authorization"
Header add Access-Control-Allow-Methods "PUT, GET, POST, DELETE, OPTIONS"

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: origin, x-requested-with, content-type, Authorization");
header("Access-Control-Allow-Origin: PUT, GET, POST, DELETE, OPTIONS");


*/



if ($formGoal == "Upload.ajax") {
    $uploadFile = filtrerUpload("uploadFile");
    afficherMessage("Le fichier $uploadFile est bien arrivé.");
}
