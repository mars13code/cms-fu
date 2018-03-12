
<section>
    <h2>Formulaire de contact</h2>
    <form class="vertical">
        <input type="nom" name="nom" required placeholder="votre nom">
        <input type="email" name="email" required placeholder="votre email">
        <textarea type="text" name="message" required placeholder="votre message" cols="60" rows="8"></textarea>
        <input type="hidden" name="--formGoal" value="Contact">
        <button>ENVOYER VOTRE MESSAGE</button>
        <?php traiterForm("Contact") ?>
    </form>
</section>