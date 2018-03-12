<?php

ajouterControllerDir(__DIR__ ."/controller");

ecrireOption("theme", "base");

function faireToto ()
{
    // il est possible de faire echo
    echo date("Y-m-d H:i:s");     
    // et il est aussi possible de faire return
    return "(TEST THEME.FOOT)";
}

ajouterAction("theme.foot", "100-base@function", "faireToto");
//ajouterAction("theme.foot", "100-base@function", null);

function filtrerContenu ($contenu="")
{
    echo "(AVANT)$contenu(APRES)";
}

ajouterAction("page.contenu", "100-base@function", "filtrerContenu");
