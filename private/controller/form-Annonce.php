<?php

if ($formGoal == "Annonce.create") {

    $levelSession = filtrerAcces("level", 1);

    $titre       = filtrerTexte("titre", 1, 200);
    $description = filtrerTexte("description", 1, 1000);
    $categorie   = filtrerTexte("categorie", 1, 200);
    $urlImage    = filtrerTexte("urlImage", 1, 200);
    $prix        = filtrerTexte("prix", 0, 1000000);

    if (empty($tabErreur)) {
        $ip     = filtrerIp();
        $date   = creerDate();
        $idUser = lireSession("id");

        $tabInput = [
            "titre"       => $titre,
            "description" => $description,
            "categorie"   => $categorie,
            "urlImage"    => $urlImage,
            "prix"        => $prix,
            "date"        => $date,
            "ip"          => $ip,
            "idUser"      => $idUser,
        ];
        $objetPDOStatement = insererLigneUnique("Annonce", $tabInput, "titre", $titre);

        // todo: vérifier que les id existent dans la table
        // et vérifier que les id des images appartiennent à l'auteur...
        $tabChoixImage = filtrerMultiId("choixImage");
        foreach($tabChoixImage as $choixImage)
        {
            $tabInputJointure = [
                "nomTable1"     => "Annonce",
                "nomTable2"     => "Page",
                "idTable1"      => $objetPDOStatement->cmsLID,
                "idTable2"      => $choixImage,
                ];
            
            insererLigne("Jointure", $tabInputJointure);
        }
    }
    afficherMessage("votre annonce est publiée ($titre)");
}

if ($formGoal == "Annonce.delete") {
    $levelSession = filtrerAcces("level", 1);
    $id           = filtrerEntier("id", 1);

    if (empty($tabErreur)) {
        // SECURITE: ATTENTION, UN MEMBRE NE PEUT SUPPRIMER QUE SES PROPRES ANNONCES
        $idUser = lireSession("id");
        supprimerLigne("Annonce", $id, "id", "AND idUser = '$idUser'");
    }
    afficherMessage("ligne supprimée ($id)");
}

if ($formGoal == "Annonce.update") {
    $levelSession = filtrerAcces("level", 1);

    $id          = filtrerEntier("id", 1);
    $titre       = filtrerTexte("titre", 1, 200);
    $description = filtrerTexte("description", 1, 1000);
    $categorie   = filtrerTexte("categorie", 1, 200);
    $urlImage    = filtrerTexte("urlImage", 0, 200);
    $prix        = filtrerFloat("prix", 0, 1000000);

    if (empty($tabErreur)) {
        $tabResult = trouverLigne("Annonce", "titre", $titre, "AND id != '$id'");
        foreach ($tabResult as $tabLigne);
        if (empty($tabLigne)) {
            $idUser = lireSession("id");
            $tabInput = [
                "titre"       => $titre,
                "description" => $description,
                "categorie"   => $categorie,
                "prix"        => $prix,
            ];
            if ($urlImage != "") {
                $tabInput["urlImage"] = $urlImage;
            }

            modifierLigne("Annonce", $tabInput,
                ["id" => $id, "idUser" => $idUser]);
        } else {
            ajouterErreur("(email) existe déjà");
        }
    }
    afficherMessage("ligne modifiée ($id)");
}
