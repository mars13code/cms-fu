
<?php bloc("bloc.blablabla") ?>
<section>
    <h2><?php echo $titre ?></h2>
    <content>
        <h3>echo</h3>
        <?php echo $contenu ?>
    </content>
    <content>
        <h3>afficherOption</h3>
        <?php afficherOption("page.contenu") ?>
    </content>
    <?php bloc("bloc.test2") ?>
    <content>
        <h3>filtrerInfo</h3>
        <h4><?php filtrerInfo("page.titre") ?></h4>
        <?php filtrerInfo("page.contenu") ?>
    </content>
    <?php bloc("bloc.test2") ?>
</section>
<?php bloc("bloc.blablabla") ?>
