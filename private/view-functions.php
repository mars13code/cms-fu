<?php

function afficherMenu ($category, $before="", $after="")
{
    $resultat = "";
    $tabResult = trouverLigne("Page", "category", $category, "ORDER BY priority ASC");
    foreach($tabResult as $tabLigne)
    {
        extract($tabLigne);
        $resultat .= 
<<<CODEHTML
    <li><a href="$template">$titre</a></li>
CODEHTML;
        
    }
    if (!empty($resultat)) {
        $resultat = "$before$resultat$after";
    }
    echo $resultat;
}

function afficherImage()
{
    // http://php.net/manual/en/function.imagecreatetruecolor.php
    header('Content-Type: image/png');
    $path     = lireOption("cms.path");
    $filename = lireOption("cms.filename");
    // http://php.net/manual/en/function.sscanf.php
    $name = $width = $height = 0;
    //list($name, $width, $height) = sscanf($filename, "%s,%d,%d");
    list($width, $height, $name) = sscanf($filename, "%dx%d-%s");

    $width  = min($width, 2000);
    $height = min($height, 2000);

    $im = @imagecreatetruecolor($width, $height);
    // http://php.net/manual/en/function.mt-rand.php
    $red   = mt_rand(0, 255);
    $green = mt_rand(0, 255);
    $blue  = mt_rand(0, 255);

    $color1 = imagecolorallocate($im, $red, $green, $blue);
    $color2 = imagecolorallocate($im, $green, $blue, $red);
    // http://php.net/manual/en/function.imagefill.php
    imagefill($im, 0, 0, $color1);

    imagestring($im, 1, 5, 5, "$width|$height", $color2);
    imagepng($im);
    imagedestroy($im);

}

function afficherMessage($message)
{
    global $tabErreur;
    if (empty($tabErreur)) {
        echo $message;
    } else {
        echo implode(", ", $tabErreur);
    }
}
