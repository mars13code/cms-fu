<?php


function bloc($id)
{
    static $tabInfo = [];
    if ($id != "") {
        if ($tabInfo[$id] ?? 0) {
            $result = ob_get_clean();
            filtrerInfo($id, $result);
            unset($tabInfo[$id]);
        } else {
            // http://php.net/manual/fr/function.uniqid.php
            $tabInfo[$id] = uniqid("bloc.");
            ob_start();
        }
    }
}

function afficher($varGlobale, $defaut = "")
{
    if (isset($GLOBALS[$varGlobale])) {
        echo $GLOBALS[$varGlobale];
    } elseif ($defaut != "") {
        echo $defaut;
    }

}

function afficherPage()
{
    global $rootDir, $dossierTheme;

    $uriPage   = extraireUri($rootDir);
    $tabResult = trouverLigne("Page", "urlPage", $uriPage);
    if (is_object($tabResult)) {
        //print_r($tabResult);
        foreach ($tabResult as $tabLigne) {
            $tabLigne = array_map("htmlspecialchars", $tabLigne);

            foreach ($tabLigne as $colonne => $colVal) {
                // memorise les infos de la page
                ecrireOption("page.$colonne", $colVal);
            }

            extract($tabLigne);
            $template ?? $template = "";
            $level ?? $level       = 0;
            $levelOK               = true;
            if ($level > 0) {
                // verifier si la page est protegee
                // et si le visiteur a le niveau suffisant
                $levelUser = lireSession("level");
                if ($level > $levelUser) {
                    $levelOK = false;
                }

            }
            if ($levelOK) {
                $themeActive    = lireOption("cms.theme");
                $cheminTemplate = "$dossierTheme/$themeActive/view-template/$template.php";
                // http://php.net/manual/fr/function.glob.php
                $tabTemplate = glob($cheminTemplate);
                foreach ($tabTemplate as $fichierTemplate) {
                    require_once $fichierTemplate;
                }

            }
        }

    }
    if (empty($tabLigne)) {
        $extension = lireOption("cms.extension");
        if ($extension == "jpg") {
            afficherImage();
        } else {
            echo "ERREUR 404: $uriPage";
        }
    }

}

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


function filtrerInfo($cle, $defaut = "")
{
    global $tabOption;
    $result = $tabOption[$cle] ?? $defaut;
    echo ajouterAction($cle, "@filter", $result);
}

function afficherOption($cle, $defaut = "")
{
    global $tabOption;
    echo $tabOption[$cle] ?? $defaut;
}

function lireOption($cle, $defaut = "")
{
    global $tabOption;
    return $tabOption[$cle] ?? $defaut;
}

function afficherAction($tag)
{
    echo ajouterAction($tag);
}


function ajouterAction($tag, ...$tabParam)
{
    static $tabInfo = [];
    $result         = "";
    if (!empty($tabParam)) {
        $cleParam    = $tabParam[0] ?? "";
        $valeurParam = $tabParam[1] ?? "";
        if ($cleParam != "") {
            if (false !== mb_stristr($cleParam, "@filter")) {

                ob_start();
                if (!empty($tabInfo["$tag"])) {
                    ksort($tabInfo["$tag"], SORT_NATURAL);

                    $nbFiltre = 0;
                    foreach (($tabInfo["$tag"] ?? []) as $cleInfo => $valeurInfo) {

                        if ((false !== mb_stristr($cleInfo, "@function"))
                            && is_callable($valeurInfo)) {
                            // la fonction peut faire echo ou return
                            // les 2 manières vont produire un contenu...
                            // pour accumuler les filtres
                            ob_start();
                            echo $valeurInfo($valeurParam);
                            $valeurParam = ob_get_clean();

                            $nbFiltre++;
                        }
                    }
                }
                echo $valeurParam;

                $result = ob_get_clean();
            } elseif ($valeurParam !== null) {
                // modifier ou ajouter une nouvelle action
                $tabInfo["$tag"]["$cleParam"] = $valeurParam;
            } elseif (isset($tabInfo["$tag"]["$cleParam"])) {
                // enlever l'action
                unset($tabInfo["$tag"]["$cleParam"]);
            }
        }

    } elseif (isset($tabInfo["$tag"])) {
        // trier le tableau
        // http://php.net/manual/fr/function.ksort.php
        ob_start();
        if (!empty($tabInfo["$tag"])) {

            ksort($tabInfo["$tag"], SORT_NATURAL);

            foreach ($tabInfo["$tag"] as $cleInfo => $valeurInfo) {

                if ((false !== mb_stristr($cleInfo, "@function"))
                    && is_callable($valeurInfo)) {
                    // la fonction peut faire echo ou return
                    // les 2 manières vont produire un contenu...
                    echo $valeurInfo();
                } else {
                    echo $valeurInfo;
                }

            }
        }

        $result = ob_get_clean();
        trim($result);
        $result = "\n$result\n";

    }

    return $result;
}
