<?php

if (0 < lireSession("level"))
{
    // VIEW
    require_once(__DIR__ . "/../view/header-membre.php");
    require_once(__DIR__ . "/../view/crud-Annonce.php");
    require_once(__DIR__ . "/../view/footer.php");
}
else
{
    // http://php.net/manual/fr/function.header.php
    header("Location: login.php");
    echo "ACCES INTERDIT";
}