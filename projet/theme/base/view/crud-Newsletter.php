<?php

$nomTable   = "Newsletter";
$section    = filtrer("section", "create");

?>

<?php if ($section == "create"): ?>

            <section>
                <h2>CREATE</h2>
                <form>
                    <input type="text" name="nom" required placeholder="votre nom">
                    <input type="email" name="email" required placeholder="votre email">
                    <!-- .ext EST OPTIONNEL POUR PHP -->
                    <input type="hidden" name="--formGoal" value="<?php echo $nomTable ?>.create">
                    <button>ENVOYER</button>
                    <div class="feedback"><?php traiterForm("$nomTable.create") ?></div>
                </form>
            </section>
            
<?php endif; ?>

<?php if ($section == "update"): ?>
<?php

$id = filtrerEntier("id");

$tabResult = trouverLigne("$nomTable", "id", $id);
foreach($tabResult as $tabLigne):

    $tabLigne = array_map("htmlspecialchars", $tabLigne);
    extract($tabLigne);
    
?>
            <section>
                <h2>UPDATE</h2>
                <form>
                    <input type="text" name="nom" required placeholder="votre nom" value="<?php echo $nom ?>">
                    <input type="email" name="email" required placeholder="votre email" value="<?php echo $email ?>">
                    <!-- .ext EST OPTIONNEL POUR PHP -->
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <input type="hidden" name="section" value="update">
                    <input type="hidden" name="--formGoal" value="<?php echo $nomTable ?>.update">
                    <button>ENVOYER</button>
                    <div class="feedback"><?php traiterForm("$nomTable.update") ?></div>
                </form>
            </section>
            
<?php endforeach; ?>
<?php endif; ?>


            
            <section>
                <h2>READ</h2>
                <div class="feedback"><?php traiterForm("$nomTable.delete", "$nomTable.update") ?></div>
                <table>
                    <tbody>
                        
<?php

$tabResult = trouverLigne("$nomTable", "", "", "ORDER BY date DESC");
$tabColShow = [];

afficherTable($nomTable, $tabResult, $tabColShow);

?>
                    </tbody>
                </table>
            </section>
