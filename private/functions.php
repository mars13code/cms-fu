<?php

function tracerVisit()
{
    // http://php.net/manual/en/function.json-encode.php
    // http://php.net/manual/en/function.session-id.php
    $tabInput = [
        "urlPage" => $_SERVER["REQUEST_URI"],
        "date"    => creerDate(),
        "request" => json_encode($_REQUEST, JSON_PRETTY_PRINT),
        "meta"    => session_id(),
        "ip"      => filtrerIp(),
    ];

    insererLigne("Visit", $tabInput);
}

function startTimer($msg = "")
{
    static $tabTime = [];
    static $tabMsg  = [];

    if ($msg != "") {
        $tabTime[] = microtime(true);
        $tabMsg[]  = $msg;
    } else {
        $now       = microtime(true);
        $tabTime[] = $now;
        $tabMsg[]  = "";

        $deltaTime = $now - $tabTime[0];
        // http://php.net/manual/en/function.memory-get-peak-usage.php
        // http://php.net/manual/en/function.number-format.php
        $debugLog = ""
        . "\n" . number_format($deltaTime * 1000, 2) . "ms"
        . "\n" . number_format(memory_get_peak_usage(true) / 1024, 0) . "Ko"
        ;

        return $debugLog;
    }
}
function ajouterControllerDir($cheminController)
{
    global $tabCheminController;
    $hash                       = md5($cheminController);
    $tabCheminController[$hash] = $cheminController;
}

function installerTableSQL()
{
    $tabScript = ["database.sql", "data.sql"];
    foreach ($tabScript as $script) {
        $cheminSQL = __DIR__ . trim("/model/$script");
        if (is_file($cheminSQL)) {
            $codeSQL = file_get_contents($cheminSQL);
            $codeSQL = trim($codeSQL);
            if ($codeSQL != "") {
                envoyerRequeteSQL($codeSQL);
            }

        }

    }
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

function ecrireOption($cle, $valeur)
{
    global $tabOption;
    $tabOption ?? $tabOption = [];
    $tabOption[$cle]         = $valeur;
}

function afficher($varGlobale, $defaut = "")
{
    if (isset($GLOBALS[$varGlobale])) {
        echo $GLOBALS[$varGlobale];
    } elseif ($defaut != "") {
        echo $defaut;
    }

}

function startCMS()
{
    $codeSQL =
        <<<CODESQL
SELECT * FROM Framework
ORDER BY step ASC

CODESQL;
    $tabResult = envoyerRequeteSQL($codeSQL);
    foreach ($tabResult as $tabLigne) {
        extract($tabLigne);
        $sequence ?? $sequence = "";
        $pool ?? $pool         = "";
        $method ?? $method     = "";
        if (($pool != "") && ($method != "")) {
            $dossierRacine = __DIR__;
            if ($sequence == "plugin") {
                $dossierRacine = __DIR__ . "/../projet/plugin";
            } elseif ($sequence == "theme") {
                $dossierRacine = __DIR__ . "/../projet/theme";
            }

            $cheminFichier = "$dossierRacine/$pool/$method.php";
            //echo "$cheminFichier";
            if (is_file($cheminFichier)) {
                require_once $cheminFichier;
            }
        } else {
            if ($sequence == "option") {
                $param ?? $param = "";
                $code ?? $code   = "";
                if ($param != "") {
                    ecrireOption($param, $code);
                }

            }
        }
    }
}

function extraireUri($rootDir)
{
    $uri = $_SERVER["REQUEST_URI"];
    // http://php.net/manual/fr/function.parse-url.php
    $path = parse_url($uri, PHP_URL_PATH);
    $path = str_replace($rootDir, "", $path);

    $result = $path;
    // cas spécial pour apache => "/" utilise "/index.php"
    if ($result == "/") {
        $result = "/index.php";
    }

    // enlever le suffixe
    // http://php.net/manual/fr/function.pathinfo.php
    $result = pathinfo($result, PATHINFO_FILENAME);
    return $result;
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
            extract($tabLigne);
            $template ?? $template = "";
            $level ?? $level       = 0;
            $levelOK               = true;
            if ($level > 0) {
                $levelUser = lireSession("level");
                if ($level > $levelUser) {
                    $levelOK = false;
                }

            }
            if ($levelOK) {
                $cheminTemplate = "$dossierTheme/view-template/$template.php";
                // http://php.net/manual/fr/function.glob.php
                $tabTemplate = glob($cheminTemplate);
                foreach ($tabTemplate as $fichierTemplate) {
                    require_once $fichierTemplate;
                }

            }
        }

    }
    if (empty($tabLigne)) {
        echo "ERREUR 404: $uriPage";
    }

}

function filtrerAcces($cle, $valeur)
{
    $valeurSession = lireSession($cle, 0);
    if ($valeur > $valeurSession) {
        ajouterErreur("($cle) $valeur <= $valeurSession");
    }
    return $valeurSession;
}

function ecrireSession($tabLigne)
{
    // http://php.net/manual/fr/function.session-start.php
    $_SESSION ?? session_start();
    foreach ($tabLigne as $cle => $valeur) {
        $_SESSION[$cle] = $valeur;
    }
}

function lireSession($cle, $defaut = "")
{
    // http://php.net/manual/fr/function.session-start.php
    $_SESSION ?? session_start();
    return $_SESSION[$cle] ?? $defaut;
}

function verifierErreur0()
{
    global $tabErreur;
    if (empty($tabErreur)) {
        return true;
    } else {
        return false;
    }
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

function ajouterErreur($message)
{
    global $tabErreur;
    //$tabErreur ?? $tabErreur = []; // FAIT PAR PHP
    $tabErreur[] = "$message";

    return count($tabErreur);
}

function filtrer($name, $defaut = "")
{
    $result = trim(strip_tags($_REQUEST["$name"] ?? $defaut));
    return $result;
}

function filtrerEntier($name, $min = null, $max = null)
{
    $result = intval(filtrer($name));
    if (is_int($min) && ($result < $min)) {
        ajouterErreur("($name) trop petit");
    }
    if (is_int($max) && ($result > $max)) {
        ajouterErreur("($name) trop grand");
    }
    return $result;
}

function filtrerFloat($name, $min = null, $max = null)
{
    // http://php.net/manual/fr/function.floatval.php
    $result = floatval(filtrer($name));
    if (is_float($min) && ($result < $min)) {
        ajouterErreur("($name) trop petit");
    }
    if (is_float($max) && ($result > $max)) {
        ajouterErreur("($name) trop grand");
    }
    return $result;
}

function filtrerTexte($name, $min = 0, $max = null)
{
    $result = filtrer($name);

    if (mb_strlen($result) < intval($min)) {
        ajouterErreur("($name) trop petit");
    }
    if (is_int($max) && (mb_strlen($min) > intval($max))) {
        ajouterErreur("($name) trop grand");
    }

    return $result;
}

function filtrerEmail($name, $min = 0, $max = 200)
{
    $result = filtrerTexte($name, $min, $max);

    // http://php.net/manual/fr/function.filter-var.php
    if (($result != "") && ($result !== filter_var($result, FILTER_VALIDATE_EMAIL))) {
        ajouterErreur("($name) email incorrect");
    }
    return $result;
}

function filtrerIp()
{
    return trim(strip_tags($_SERVER["REMOTE_ADDR"]));
}

function creerDate($format = "Y-m-d H:i:s")
{
    return date($format);
}

function ajouterErreurSQL(...$tabParam)
{
    static $tabErreur    = [];
    static $tabStatement = [];
    if (!empty($tabParam)) {
        $p0 = $tabParam[0];
        $p1 = $tabParam[1];
        if (is_object($p0)) {
            $tabErreur[]    = $p0;
            $tabStatement[] = $p1;
            if ($p1 != null) {
                $p1->debugDumpParams();
            }
        }
    } else {
        foreach ($tabErreur as $index => $e) {

            echo "<pre>";
            echo $e->getMessage();
            echo "</pre>";
            $objetPDOStatement = $tabStatement[$index];
            if ($objetPDOStatement != null) {
                $objetPDOStatement->debugDumpParams();
            }
        }
    }
}
function envoyerRequeteSQL($codeSQL, $tabInput = [])
{
    static $objetPDO   = null;
    $objetPDOStatement = null;
    try {
        if ($objetPDO == null) {
            global $dbSQL, $userSQL, $passSQL;
            $dsn      = "mysql:host=localhost;dbname=$dbSQL;charset=utf8mb4";
            $objetPDO = new PDO($dsn, $userSQL, $passSQL);
            $objetPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        $objetPDOStatement = $objetPDO->prepare($codeSQL);
        $objetPDOStatement->execute($tabInput);

        $objetPDOStatement->setFetchMode(PDO::FETCH_ASSOC);

    } catch (PDOException $exception) {
        ajouterErreurSQL($exception, $objetPDOStatement);
        $errorCode = $exception->getCode();
        if ($errorCode == "42S02") {
            // Base table or view not found
            installerTableSQL();
        }
    }
    return $objetPDOStatement;
}

function insererLigneUnique($nomTable, $tabInput, $nomColonne = "", $valeurColonne = "")
{
    if ($nomColonne != "") {
        $tabResult = trouverLigne($nomTable, $nomColonne, $valeurColonne);
        foreach ($tabResult as $tabLigne) {
            ajouterErreur("($nomColonne) existe déjà");
            break;
        }
    }

    if (empty($tabLigne)) {
        $objetPDOStatement = insererLigne($nomTable, $tabInput);
        return $objetPDOStatement;
    }

}

function insererLigne($nomTable, $tabInput)
{
    $tabKeys = array_keys($tabInput);
    $cols    = implode(", ", $tabKeys);
    $tokens  = implode(", :", $tabKeys);

    $codeSQL =
        <<<CODESQL

INSERT INTO $nomTable
( $cols )
VALUES
( :$tokens )

CODESQL;

    $objetPDOStatement = envoyerRequeteSQL($codeSQL, $tabInput);

    // print_r($objetPDOStatement);

    return $objetPDOStatement;
}

function modifierLigne($nomTable, $tabInput, $tabWhere)
{
    $cols = "";
    foreach ($tabInput as $col => $val) {
        $cols .= ", $col = :$col";
    }
    // http://php.net/manual/fr/function.trim.php
    $cols = trim($cols, ", ");
    // ajouter id dans les tokens
    $where = "";
    foreach ($tabWhere as $col => $val) {
        $where .= "AND $col = :Where$col ";
        $tabInput["Where$col"] = $val;
    }
    // http://php.net/manual/fr/function.trim.php
    $where = trim($where);

    $codeSQL =
        <<<CODESQL

UPDATE $nomTable
SET
$cols
WHERE 1 = 1
$where

CODESQL;

    $objetPDOStatement = envoyerRequeteSQL($codeSQL, $tabInput);

    // print_r($objetPDOStatement);

    return $objetPDOStatement;
}

function supprimerLigne($nomTable, $valeurColonne, $nomColonne = "id", $extraSQL = "")
{
    if ($nomColonne != "") {
        $codeSQL =
            <<<CODESQL

DELETE FROM $nomTable
WHERE
$nomColonne = :$nomColonne
$extraSQL

CODESQL;

        $objetPDOStatement = envoyerRequeteSQL($codeSQL, [$nomColonne => $valeurColonne]);

        return $objetPDOStatement;
    }
}

/*
SELECT *
FROM table1
INNER JOIN table2 ON table1.id = table2.fk_id
 */
function trouverLigneJointure($tabJointure, $nomColonne = "", $valeurColonne = "", $extraSQL = "")
{
    // http://sql.sh/cours/jointures/inner-join
    list($nomTable1, $nomTable2) = array_keys($tabJointure);
    list($joint1, $joint2)       = array_values($tabJointure);

    $nomTable1 ?? $nomTable2 ?? $joint1 ?? $joint2 ?? ajouterErreur("(SQL) erreur jointure");
    // todo: vérifier si pas de texte vide

    if (verifierErreur0()) {

        $clauseWhere = "";
        $tabWhere    = [];
        if ($nomColonne != "") {
            $tokenColonne = str_replace(".", "_", $nomColonne);
            $clauseWhere  = "WHERE $nomColonne = :$tokenColonne";
            $tabWhere     = [$tokenColonne => $valeurColonne];
        }

        $codeSQL =
            <<<CODESQL

SELECT *
FROM $nomTable1
INNER JOIN $nomTable2
ON $nomTable1.$joint1 = $nomTable2.$joint2
$clauseWhere
$extraSQL


CODESQL;

        $objetPDOStatement = envoyerRequeteSQL($codeSQL, $tabWhere);

        return $objetPDOStatement;
    }
}

function trouverLigne($nomTable, $nomColonne = "", $valeurColonne = "", $extraSQL = "")
{
    $clauseWhere = "";
    if ($nomColonne != "") {
        $clauseWhere = "WHERE $nomColonne = :$nomColonne";
    }

    $codeSQL =
        <<<CODESQL

SELECT * FROM $nomTable
$clauseWhere
$extraSQL


CODESQL;

    $objetPDOStatement = envoyerRequeteSQL($codeSQL, [$nomColonne => $valeurColonne]);

    return $objetPDOStatement;
}

function traiterForm(...$tabGoal)
{
    global $tabCheminController;
    global $tabErreur; // obligatoire pour les fichiers de traitement...

    static $feedback = "";
    static $formGoal = "";

    if (empty($tabGoal)) {
        // CONTROLLER
        $formGoal = trim(strip_tags($_REQUEST["--formGoal"] ?? ""));

        if ($formGoal != "") {
            // http://php.net/manual/fr/function.ob-start.php
            ob_start();

            // ON NE PREND PAS EN COMPTE LE SUFFIXE
            // POUR PERMETTRE DE RASSEMBLER PLUSIEURS TRAITEMENTS DANS UN SEUL FICHIER
            // exemple: CRUD

            // http://php.net/manual/fr/function.pathinfo.php
            $formName = pathinfo($formGoal, PATHINFO_FILENAME);
            // sécurité: enlever les caractères spéciaux
            // http://php.net/manual/fr/function.preg-replace.php
            $formName = preg_replace("/[^a-zA-Z0-9-_]/i", "", $formName);

            foreach ($tabCheminController as $cheminController) {
                // http://php.net/manual/fr/function.glob.php
                $tabFichier = glob("$cheminController/form-$formName.php");
                foreach ($tabFichier as $fichier) {
                    require_once $fichier;
                }
            }
            // http://php.net/manual/fr/function.ob-get-clean.php
            $feedback = ob_get_clean();
        }
    } elseif (in_array($formGoal, $tabGoal)) {
        // VIEW
        // http://php.net/manual/fr/function.in-array.php
        echo $feedback;
    }
}
