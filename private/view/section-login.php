
<section>
    <h2>LOGIN</h2>
    <form>
        <input type="email" name="emailLogin" required placeholder="votre email">
        <input type="password" name="passwordLogin" required placeholder="votre password">
        <input type="hidden" name="--formGoal" value="User.login">
        <button>ENVOYER</button>
        <?php traiterForm("User.login") ?>
    </form>
</section>