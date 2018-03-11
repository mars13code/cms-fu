<?php

ajouterControllerDir(__DIR__ ."/controller");

ecrireOption("theme", "base");

function faireToto ()
{
    echo "(TEST THEME.FOOT)";
}

ajouterAction("theme.foot", "100-base@function", "faireToto");
ajouterAction("theme.foot", "100-base@function", null);