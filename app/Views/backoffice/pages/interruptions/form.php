<?php /* Contenu propre à la page — le layout ajoute head, sidebar, header, footer et scripts. */ ?>
        <div class="admin-page-head">
          <div>
            <nav class="admin-breadcrumb" aria-label="Fil d'Ariane">
              <a href="<?= url('dashboard') ?>">Tableau de bord</a><span>/</span><a href="<?= url('admin-interruptions') ?>">Interruptions</a><span>/</span><span>Publier</span>
            </nav>
            <div class="admin-page-head__title">
              <span class="admin-page-head__icon" data-icon="zap"></span>
              <div>
                <h1>Publier une interruption</h1>
                <p>Coupure planifiée ou constatée, visible par les citoyens de la zone</p>
              </div>
            </div>
          </div>
        </div>

        <div class="admin-form-layout">
          <section class="admin-card">
            <div class="admin-card__body">
              <!-- Les noms des champs reprennent les colonnes de la table « interruption » du dictionnaire -->
              <form class="admin-form" data-admin-form novalidate>
                <fieldset class="admin-field admin-field--full">
                  <legend>Ressource coupée <span class="req">*</span></legend>
                  <div class="admin-choices">
                    <label class="admin-choice">
                      <input type="radio" name="type_ressource" value="electricite" data-required="Choisissez la ressource coupée.">
                      <span><span data-icon="zap"></span> Électricité (STEG)</span>
                    </label>
                    <label class="admin-choice">
                      <input type="radio" name="type_ressource" value="eau" data-required="Choisissez la ressource coupée.">
                      <span><span data-icon="droplet"></span> Eau (SONEDE)</span>
                    </label>
                  </div>
                  <p class="admin-field__error"></p>
                </fieldset>

                <div class="admin-field">
                  <label for="id_zone">Zone touchée <span class="req">*</span></label>
                  <select class="admin-select" id="id_zone" name="id_zone" data-required="Sélectionnez la zone touchée.">
                    <option value="">— Choisir une zone —</option>
                    <option value="1">Tunis</option>
                    <option value="2">Ariana — La Soukra</option>
                    <option value="3">Nabeul — Hammamet</option>
                    <option value="4">Sfax — Sfax Nord</option>
                    <option value="5">Kébili — Douz</option>
                  </select>
                  <p class="admin-field__error"></p>
                </div>

                <div class="admin-field">
                  <label for="statut">Statut <span class="req">*</span></label>
                  <select class="admin-select" id="statut" name="statut" data-required="Sélectionnez le statut.">
                    <option value="">— Choisir un statut —</option>
                    <option value="planifiee">Planifiée</option>
                    <option value="en_cours">En cours</option>
                    <option value="terminee">Terminée</option>
                  </select>
                  <p class="admin-field__error"></p>
                </div>

                <div class="admin-field">
                  <label for="date_debut">Début <span class="req">*</span></label>
                  <input class="admin-input" type="datetime-local" id="date_debut" name="date_debut" data-required="Indiquez la date de début.">
                  <p class="admin-field__error"></p>
                </div>

                <div class="admin-field">
                  <label for="date_fin_prevue">Fin prévue <span class="req">*</span></label>
                  <input class="admin-input" type="datetime-local" id="date_fin_prevue" name="date_fin_prevue"
                         data-required="Indiquez la fin prévue." data-after="date_debut"
                         data-after-message="La fin prévue doit être après le début.">
                  <p class="admin-field__error"></p>
                </div>

                <div class="admin-field admin-field--full">
                  <label for="cause">Cause <span class="req">*</span></label>
                  <input class="admin-input" type="text" id="cause" name="cause" placeholder="Ex. travaux, panne, surcharge…"
                         data-required="Indiquez la cause de la coupure." data-minlength="4">
                  <p class="admin-field__hint">4 caractères minimum.</p>
                  <p class="admin-field__error"></p>
                </div>

                <div class="admin-form__actions">
                  <a class="admin-btn admin-btn--outline" href="<?= url('admin-interruptions') ?>">Annuler</a>
                  <button class="admin-btn admin-btn--primary" type="submit"><span data-icon="save"></span> Enregistrer</button>
                </div>
              </form>
            </div>
          </section>

          <aside class="admin-card">
            <div class="admin-card__head">
              <h2 class="admin-card__title"><span data-icon="info"></span> À savoir</h2>
            </div>
            <div class="admin-card__body admin-aside-note">
              <dl>
                <div><dt>Qui publie ?</dt><dd>Le sous-admin STEG (électricité) ou SONEDE (eau).</dd></div>
                <div><dt>Fin réelle</dt><dd>Renseignée automatiquement lors de la clôture.</dd></div>
                <div><dt>Alertes</dt><dd>Une interruption peut déclencher une alerte pour les habitants de la zone.</dd></div>
              </dl>
            </div>
          </aside>
        </div>
