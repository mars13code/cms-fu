
<section>
    <h2>LOGIN</h2>
    <form>
        <input type="nom" name="nom" required placeholder="votre nom">
        <input type="email" name="email" required placeholder="votre email">
        <textarea type="text" name="message" required placeholder="votre message"></textarea>
        <input type="hidden" name="--formGoal" value="Contact">
        <button>ENVOYER</button>
        <?php traiterForm("Contact") ?>
    </form>
</section>