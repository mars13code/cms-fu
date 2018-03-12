<?php

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
            $valeurColonne = htmlspecialchars($valeurColonne);
            ajouterErreur("($valeurColonne) existe déjà");
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
