<?php

if (8 < lireSession("level"))
{
    // VIEW
    require_once(__DIR__ . "/../view/header-admin.php");
    require_once(__DIR__ . "/../view/crud-Upload.php");
    require_once(__DIR__ . "/../view/footer.php");
}
else
{
    // http://php.net/manual/fr/function.header.php
    header("Location: login.php");
    echo "ACCES INTERDIT";
}