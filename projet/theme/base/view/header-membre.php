<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title><?php filtrerInfo("page.titre") ?> / <?php filtrerInfo("cms.title") ?></title>
        
        <link rel="icon" type="image/jpeg" href="assets/img/256x256-logo.jpg" />
        
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/site.css" type="text/css">
        
        <?php afficherAction("theme.head") ?>

    </head>
    <body>
        <div class="page">
            
        <header>
            <h1><a href="index.html"><img src="<?php filtrerInfo("page.logo") ?>" alt="<?php filtrerInfo("page.titre") ?>"></a></h1>
            <?php afficherMenu("membre", "<nav><ul>", "</ul></nav>") ?>
        </header>

        <main>
