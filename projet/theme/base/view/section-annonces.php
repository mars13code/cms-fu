
<?php bloc("bloc.section") ?>
           <section>
                <h2>LISTE DES ANNONCES</h2>
                <div class="ligne col3">
                    
<?php

/* 
SELECT *
FROM table1
INNER JOIN table2 
ON table1.id = table2.fk_id
*/

$tabResult = trouverLigneJointure([ "Annonce" => "idUser", "User" => "id" ], "", "", "ORDER BY Annonce.date DESC");
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
        <div class="description">$description</div>
        <div>$htmlImage</div>
        <div>$date</div>
    </article>

CODEHTML;
}

?>
                </div>
            </section>
<?php bloc("bloc.section") ?>
