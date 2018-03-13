<?php

$nomTable = "Annonce";
$section  = filtrer("section", "create");

?>

<?php if ($section == "create"): ?>

            <section>
                <h2>CREATE</h2>
                <form class="vertical">
                    <input type="text" name="titre" required placeholder="titre">
                    <input type="text" name="categorie" required placeholder="categorie">
                    <textarea type="text" name="description" cols="60" rows="5"></textarea>
                    <input type="text" name="urlImage" required placeholder="url image">
                    <input type="number" name="prix" required placeholder="prix">
                    <!-- .ext EST OPTIONNEL POUR PHP -->
                    <input type="hidden" name="--formGoal" value="<?php echo $nomTable; ?>.create">
                    <button>ENVOYER</button>
                    <div class="feedback"><?php traiterForm("$nomTable.create"); ?></div>
                </form>
            </section>

<?php endif; ?>

<?php if ($section == "update"): ?>
<?php

$id = filtrerEntier("id");

$tabResult = trouverLigne("$nomTable", "id", $id);
foreach ($tabResult as $tabLigne):

    $tabLigne = array_map("htmlspecialchars", $tabLigne);
    extract($tabLigne);

    ?>
	            <section>
	                <h2>UPDATE</h2>
    	                <form class="vertical">
                        <input type="text" name="titre" required placeholder="titre" value="<?php echo $titre ?>">
                        <input type="text" name="categorie" required placeholder="categorie" value="<?php echo $categorie ?>">
                        <textarea type="text" name="description" cols="60" rows="5"><?php echo $description ?></textarea>
                        <input type="text" name="urlImage" required placeholder="url image" value="<?php echo $urlImage ?>">
                        <input type="number" name="prix" required placeholder="prix" value="<?php echo $prix ?>">
	                    <!-- .ext EST OPTIONNEL POUR PHP -->
	                    <input type="hidden" name="id" value="<?php echo $id; ?>">
	                    <input type="hidden" name="section" value="update">
	                    <input type="hidden" name="--formGoal" value="<?php echo $nomTable; ?>.update">
	                    <button>ENVOYER</button>
	                    <div class="feedback"><?php traiterForm("$nomTable.update"); ?></div>
	                </form>
	            </section>

	<?php endforeach; ?>
<?php endif; ?>



            <section>
                <h2>READ</h2>
                <div class="feedback"><?php traiterForm("$nomTable.delete", "$nomTable.update"); ?></div>
<?php

$idUser    = lireSession("id");
$tabResult = trouverLigne("$nomTable", "idUser", "$idUser", "ORDER BY date DESC");
$tabColShow = [];
afficherTable($nomTable, $tabResult, $tabColShow);

?>
            </section>
