<?php
/* Contenu propre à la page — le layout ajoute head, header, footer et scripts.
 * Variables : $errors (messages par champ), $old (valeurs saisies), $gouvernorats */
$fieldError = function (string $name) use ($errors): string {
    return '<p class="field__error' . (isset($errors[$name]) ? ' is-visible' : '') . '" data-error-for="' . $name . '">'
         . e($errors[$name] ?? '') . '</p>';
};
$invalid = fn (string $name): string => isset($errors[$name]) ? ' is-invalid' : '';
?>
  <main id="main" class="login-page">
    <div class="container">
      <div class="login-shell">
        <aside class="login-brand">
          <a class="brand" href="<?= url('accueil') ?>" aria-label="WASLA — Accueil">
            <span class="brand__mark">
              <svg viewBox="0 0 64 64" fill="none" aria-hidden="true">
                <path d="M32 3.5C32 3.5 10.5 25.5 10.5 40.5C10.5 51.8 20.1 61.5 32 61.5C43.9 61.5 53.5 51.8 53.5 40.5C53.5 25.5 32 3.5 32 3.5Z" fill="#FFFFFF" stroke="#00A3D7" stroke-width="4.5" stroke-linejoin="round"/>
                <path d="M32 12.5C32 12.5 18.5 29.5 18.5 39.5C18.5 47 24.5 53 32 53C39.5 53 45.5 47 45.5 39.5C45.5 29.5 32 12.5 32 12.5Z" fill="#003B5C"/>
                <path d="M36.2 19.5C36.2 19.5 27 31 27 39.2C27 44.2 30.8 48 35.8 48C41 48 45.2 43.8 45.2 38.6C45.2 30.5 40.4 24.5 36.2 19.5Z" fill="#73D13D"/>
                <path d="M32.2 21.5L24.6 39.2H29.4L27.2 49.2L36.8 31.8H31.9L34.2 21.5H32.2Z" fill="#EAF4FB"/>
              </svg>
            </span>
            <span class="brand__text">
              <span class="brand__name">WASLA</span>
              <span class="brand__tagline">Connecter. Anticiper. <span class="accent">Protéger.</span></span>
            </span>
          </a>

          <div class="login-brand__body">
            <h2>Rejoignez <span>WASLA.</span></h2>
            <p>Créez votre compte en une minute pour recevoir les alertes de votre gouvernorat, suivre vos factures et accéder aux services prioritaires.</p>
          </div>

          <div class="login-brand__stats">
            <div class="login-brand__stat"><strong>24</strong><span>Gouvernorats</span></div>
            <div class="login-brand__stat"><strong>98%</strong><span>Réseau stable</span></div>
            <div class="login-brand__stat"><strong>+1M</strong><span>Citoyens</span></div>
          </div>
        </aside>

        <section class="login-form-panel" aria-labelledby="register-title">
          <div class="login-form-wrap login-form-wrap--wide">
            <p class="eyebrow">Espace citoyen</p>
            <h1 id="register-title">Créer un compte</h1>
            <p>Renseignez vos informations : votre espace sera prêt immédiatement.</p>

<?php if (!empty($errors['form'])): ?>
            <div class="form-alert form-alert--error" role="alert"><?= e($errors['form']) ?></div>
<?php elseif ($errors !== []): ?>
            <div class="form-alert form-alert--error" role="alert">Veuillez corriger les champs indiqués.</div>
<?php endif; ?>

            <form class="login-form" data-register-form method="post" action="<?= url('inscription') ?>" novalidate>
              <?= csrfField() ?>
              <div class="form-row">
                <div class="field">
                  <label for="reg-prenom">Prénom</label>
                  <input class="input<?= $invalid('prenom') ?>" id="reg-prenom" name="prenom" type="text" autocomplete="given-name" maxlength="80" value="<?= e($old['prenom']) ?>" required>
                  <?= $fieldError('prenom') ?>
                </div>
                <div class="field">
                  <label for="reg-nom">Nom</label>
                  <input class="input<?= $invalid('nom') ?>" id="reg-nom" name="nom" type="text" autocomplete="family-name" maxlength="80" value="<?= e($old['nom']) ?>" required>
                  <?= $fieldError('nom') ?>
                </div>
              </div>

              <div class="field">
                <label for="reg-email">Adresse e-mail</label>
                <input class="input<?= $invalid('email') ?>" id="reg-email" name="email" type="email" autocomplete="email" maxlength="180" placeholder="vous@exemple.tn" value="<?= e($old['email']) ?>" required>
                <?= $fieldError('email') ?>
              </div>

              <div class="form-row">
                <div class="field">
                  <label for="reg-telephone">Téléphone <span class="field__optional">(facultatif)</span></label>
                  <input class="input<?= $invalid('telephone') ?>" id="reg-telephone" name="telephone" type="tel" autocomplete="tel" placeholder="22 123 456" value="<?= e($old['telephone']) ?>">
                  <?= $fieldError('telephone') ?>
                </div>
                <div class="field">
                  <label for="reg-gouvernorat">Gouvernorat</label>
                  <select class="select<?= $invalid('gouvernorat') ?>" id="reg-gouvernorat" name="gouvernorat" required>
                    <option value="">Choisir…</option>
<?php foreach ($gouvernorats as $g): ?>
                    <option value="<?= e($g) ?>"<?= $old['gouvernorat'] === $g ? ' selected' : '' ?>><?= e($g) ?></option>
<?php endforeach; ?>
                  </select>
                  <?= $fieldError('gouvernorat') ?>
                </div>
              </div>

              <div class="form-row">
                <div class="field">
                  <label for="reg-password">Mot de passe</label>
                  <input class="input<?= $invalid('password') ?>" id="reg-password" name="password" type="password" autocomplete="new-password" required>
                  <?php if (!isset($errors['password'])): ?><p class="field__hint">8 caractères min., une lettre et un chiffre.</p><?php endif; ?>
                  <?= $fieldError('password') ?>
                </div>
                <div class="field">
                  <label for="reg-password-confirm">Confirmation</label>
                  <input class="input<?= $invalid('password_confirm') ?>" id="reg-password-confirm" name="password_confirm" type="password" autocomplete="new-password" required>
                  <?= $fieldError('password_confirm') ?>
                </div>
              </div>

              <div class="field">
                <label class="checkbox"><input type="checkbox" name="terms" value="1"<?= !empty($_POST['terms']) ? ' checked' : '' ?>> J'accepte les conditions d'utilisation et la politique de confidentialité de WASLA.</label>
                <?= $fieldError('terms') ?>
              </div>

              <button class="btn btn--primary btn--block btn--lg" type="submit" data-register-submit>Créer mon compte</button>
            </form>

            <p class="login-alt">Déjà inscrit ? <a href="<?= url('connexion') ?>">Se connecter</a></p>
          </div>
        </section>
      </div>
    </div>
  </main>
