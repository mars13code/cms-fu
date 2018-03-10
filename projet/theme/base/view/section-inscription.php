
            <section>
                <h2>CREATE</h2>
                <form>
                    <input type="text" name="nom" required placeholder="votre nom">
                    <input type="email" name="email" required placeholder="votre email">
                    <input type="password" name="password" required placeholder="votre password">
                    <!-- .ext EST OPTIONNEL POUR PHP -->
                    <input type="hidden" name="--formGoal" value="User.create">
                    <button>ENVOYER</button>
                    <div class="feedback"><?php traiterForm("User.create") ?></div>
                </form>
            </section>

