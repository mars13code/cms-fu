
           <section>
                <h2>ANNONCE SEULE</h2>
                <div class="ligne col2">
                    
<?php

$idAnnonce = filtrerEntier("idAnnonce");
/* 
SELECT *
FROM table1
INNER JOIN table2 
ON table1.id = table2.fk_id
*/

$tabResult = trouverLigneJointure([ "Annonce" => "idUser", "User" => "id" ], "Annonce.id", "$idAnnonce", "ORDER BY Annonce.date DESC");
foreach ($tabResult as $tabLigne) {
    $tabLigne = array_map("htmlspecialchars", $tabLigne);
    extract($tabLigne);
    $htmlImage = $urlImage ? '<img src="' . $urlImage . '">' : "";

    echo
        <<<CODEHTML

    <article class="annonce-$id">
        <div>$categorie</div>
        <h3><a href="annonce.php?idAnnonce=$id">$titre</a> (par $nom)</h3>
        <strong>prix: $prix euros</strong>
        <div>$description</div>
        <div>$htmlImage</div>
        <div>$date</div>
    </article>

CODEHTML;
}

if (empty($tabLigne))
{
    echo "DESOLE AUCUNE ANNONCE TROUVEE ($idAnnonce)";
}
?>
                </div>
            </section>
