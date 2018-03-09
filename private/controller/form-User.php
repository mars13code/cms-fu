<?php

if ($formGoal == "User.login") {

    $emailLogin    = filtrerEmail("emailLogin", 1, 200);
    $passwordLogin = filtrerTexte("passwordLogin", 4, 200);

    $message = "";
    if (empty($tabErreur)) {
        $tabResult = trouverLigne("User", "email", $emailLogin);
        foreach ($tabResult as $tabLigne) {
            extract($tabLigne);
            // http://php.net/manual/fr/function.password-verify.php
            if (password_verify($passwordLogin, $password)) {
                $message = "bienvenue $nom (level=$level)";
                ecrireSession($tabLigne);
                
                if ($level == 1) {
                    header("Location: espace-membre.php");
                }
                if ($level == 9) {
                    header("Location: admin.php");
                }
            } else {
                ajouterErreur("(login) infos incorrectes");
            }
        }
    }
    afficherMessage($message);

}

if ($formGoal == "User.create") {

    $nom      = filtrerTexte("nom", 1, 200);
    $email    = filtrerEmail("email", 1, 200);
    $password = filtrerTexte("password", 4, 200);

    if (empty($tabErreur)) {
        $ip    = filtrerIp();
        $date  = creerDate();
        $level = 1;

        // memoriser le motde passe hashe
        // http://php.net/manual/fr/function.password-hash.php
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $tabInput = [
            "nom"      => $nom,
            "email"    => $email,
            "password" => $passwordHash,
            "level"    => $level,
            "date"     => $date,
            "ip"       => $ip,
        ];
        insererLigneUnique("User", $tabInput, "email", $email);

    }
    afficherMessage("merci de votre inscription $nom ($email)");
}

if ($formGoal == "User.delete") {
    $levelSession = filtrerAcces("level", 9);
    $id           = filtrerEntier("id", 1);

    if (empty($tabErreur)) {
        supprimerLigne("User", $id);
    }
    afficherMessage("ligne supprimée ($id)");
}

if ($formGoal == "User.update") {
    $levelSession = filtrerAcces("level", 9);

    $id       = filtrerEntier("id", 1);
    $nom      = filtrerTexte("nom", 1, 200);
    $email    = filtrerEmail("email", 1, 200);
    $password = filtrerTexte("password", 0, 200);
    $level    = filtrerEntier("level", 0);

    if (empty($tabErreur)) {
        $tabResult = trouverLigne("User", "email", $email, "AND id != '$id'");
        foreach ($tabResult as $tabLigne);
        if (empty($tabLigne)) {
            $tabInput = [
                "nom"   => $nom,
                "email" => $email,
                "level" => $level,
            ];

            // si le mot de passe est laissé vide
            // alors il n'est pas modifié
            if ($password != "") {
                // http://php.net/manual/fr/function.password-hash.php
                $passwordHash         = password_hash($password, PASSWORD_DEFAULT);
                $tabInput["password"] = $passwordHash;
            }

            modifierLigne("User", $tabInput, ["id" => $id]);
        } else {
            ajouterErreur("(email) existe déjà");
        }
    }
    afficherMessage("ligne modifiée ($id)");
}
