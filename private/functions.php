<?php
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
            }

            $cheminFichier = "$dossierRacine/$pool/$method.php";
            //echo "$cheminFichier";
            if (is_file($cheminFichier)) {
                require_once $cheminFichier;
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

function afficherPage ()
{
    global $rootDir;
    
    $uriPage   = extraireUri($rootDir);
    $tabResult = trouverLigne("Page", "urlPage", $uriPage);
    if(is_object($tabResult))
    {
        //print_r($tabResult);
        foreach($tabResult as $tabLigne) {
            $tabLigne = array_map("htmlspecialchars", $tabLigne);
            extract($tabLigne);
            $template ?? $template = "";
            $level ?? $level = 0;
            $levelOK = true;
            if ($level > 0)
            {
                $levelUser = lireSession("level");
                if ($level > $levelUser) $levelOK = false;
            }
            if ($levelOK)
            {
                $cheminTemplate = "../private/view-template/$template.php";
                // http://php.net/manual/fr/function.glob.php
                $tabTemplate = glob($cheminTemplate);
                foreach ($tabTemplate as $fichierTemplate) {
                    require_once($fichierTemplate);
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

function envoyerRequeteSQL($codeSQL, $tabInput = [])
{
    static $objetPDO = null;

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
        echo "[SQL]" . $exception->getMessage();
        if ($objetPDOStatement != null) {
            $objetPDOStatement->debugDumpParams();
            print_r($objetPDOStatement);
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
    global $cheminController;
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
            // http://php.net/manual/fr/function.glob.php
            $tabFichier = glob("$cheminController/form-$formName.php");
            foreach ($tabFichier as $fichier) {
                require_once $fichier;
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
