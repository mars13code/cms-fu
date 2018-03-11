<?php

ajouterControllerDir(__DIR__ . "/controller");

$GLOBALS["hello"] = 
<<<CODEHTML

<p><a href="#">COUCOU</a></p>

CODEHTML;

$codeFoot = 
<<<CODEHTML

<script>
console.log("hello");
</script>

CODEHTML;


function faireTestHead ()
{
    echo 
<<<CODEHTML

<style>

h1 {
    color:red;
}
</style>

CODEHTML;

}

function faireTestHeadTheme ()
{
    echo 
<<<CODEHTML

<style>

a {
    color:green;
}
</style>

CODEHTML;

}

function faireTestFoot ()
{
    echo "TEST";
}

ajouterAction("head-theme", "100-test@function", "faireTestHeadTheme");
ajouterAction("head", "100-test@function", "faireTestHead");
ajouterAction("foot", "100-test", $codeFoot);
ajouterAction("foot", "100-test2@function", "faireTestFoot");
