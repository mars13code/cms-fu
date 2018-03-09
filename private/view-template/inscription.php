<?php

if (0 <= lireSession("level"))
{
    // VIEW
    require_once(__DIR__ . "/../view/header.php");
    require_once(__DIR__ . "/../view/section-inscription.php");
    require_once(__DIR__ . "/../view/footer.php");
}
else
{
    echo "ACCES INTERDIT";
}