
            <section>
                <h2>PRESENTATION</h2>
                <article>
                    <h3><a href="inscription.php">INSCRIPTION</a></h3>
                </article>
                <article>
                    <h3><a href="login.php">LOGIN</a></h3>
                </article>
            </section>

            <section>
                <h2>FORMULAIRE 1</h2>
                <form>
                    <!-- .ext EST OPTIONNEL POUR PHP -->
                    <input type="hidden" name="--formGoal" value="nom.ext">
                    <button>ENVOYER</button>
                    <?php traiterForm("nom.ext") ?>
                </form>
            </section>

            <section>
                <h2>FORMULAIRE 2</h2>
                <form>
                    <!-- .ext EST OPTIONNEL POUR PHP -->
                    <input type="hidden" name="--formGoal" value="nom.ext2">
                    <button>ENVOYER</button>
                    <?php traiterForm("nom.ext2") ?>
                </form>
            </section>

            <section>
                <h2>FORMULAIRE 3</h2>
                <form>
                    <!-- .ext EST OPTIONNEL POUR PHP -->
                    <input type="hidden" name="--formGoal" value="nom3">
                    <button>ENVOYER</button>
                    <?php traiterForm("nom3") ?>
                </form>
            </section>

            <section>
                <h2>FORMULAIRE 1,2,3</h2>
                    <?php traiterForm("nom.ext", "nom.ext2", "nom3") ?>
            </section>
