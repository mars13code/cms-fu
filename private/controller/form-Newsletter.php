<?php

if ($formGoal == "Newsletter.create") {

    $nom   = filtrerTexte("nom", 1, 200);
    $email = filtrerEmail("email", 1, 200);

    if (empty($tabErreur)) {
        $ip   = filtrerIp();
        $date = creerDate();

        $tabInput = [
            "nom"   => $nom,
            "email" => $email,
            "date"  => $date,
            "ip"    => $ip,
        ];
        insererLigneUnique("Newsletter", $tabInput, "email", $email);

    }
    afficherMessage("merci de votre inscription $nom ($email)");
}

if ($formGoal == "Newsletter.delete") {
    $levelSession = filtrerAcces("level", 9);
    $id           = filtrerEntier("id", 1);
    
    if (empty($tabErreur)) {
        supprimerLigne("Newsletter", $id);
    }
    afficherMessage("ligne supprimée ($id)");
}

if ($formGoal == "Newsletter.update") {
    $levelSession = filtrerAcces("level", 9);
    $id           = filtrerEntier("id", 1);
    $nom          = filtrerTexte("nom", 1, 200);
    $email        = filtrerEmail("email", 1, 200);

    if (empty($tabErreur)) {
        $tabResult = trouverLigne("Newsletter", "email", $email, "AND id != '$id'");
        foreach ($tabResult as $tabLigne);
        if (empty($tabLigne)) {
            $tabInput = [
                "nom"   => $nom,
                "email" => $email,
            ];
            modifierLigne("Newsletter", $tabInput, ["id" => $id]);
        } else {
            ajouterErreur("(email) existe déjà");
        }
    }
    afficherMessage("ligne modifiée ($id)");
}
