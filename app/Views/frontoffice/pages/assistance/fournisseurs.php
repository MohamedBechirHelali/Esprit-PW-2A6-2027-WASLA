<?php /* Service 03 — Fournisseurs. Contenu propre à la page : le layout ajoute head, navbar, footer et scripts.
   L'annuaire et les demandes sont gérés par assets/js/services/fournisseurs.js (données de démonstration). */ ?>
  <main id="main" data-service="fournisseurs">
    <section class="page-hero">
      <div class="container">
        <nav class="breadcrumbs" aria-label="Fil d'Ariane">
          <a href="<?= url('accueil') ?>">Accueil</a>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="icon-dir"><path d="m9 18 6-6-6-6"/></svg>
          <a href="<?= url('services') ?>">Services</a>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="icon-dir"><path d="m9 18 6-6-6-6"/></svg>
          <span aria-current="page">Fournisseurs</span>
        </nav>
        <div class="page-hero__row">
          <div>
            <p class="eyebrow">Service 03 · Techniciens agréés</p>
            <h1>Fournisseurs &amp; techniciens</h1>
            <p>Trouvez un électricien, un plombier ou un installateur solaire vérifié près de chez vous, comparez les avis et suivez vos demandes d'intervention.</p>
          </div>
          <div class="page-hero__actions">
            <button class="btn btn--outline" type="button" data-scroll-to="my-requests">
              <span data-icon="clock"></span>
              Mes demandes
            </button>
            <button class="btn btn--primary" type="button" data-new-request>
              <span data-icon="wrench"></span>
              Demander une intervention
            </button>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section page-section--soft">
      <div class="container">
        <p class="svc-notice"><span data-icon="info"></span><span><strong>Données de démonstration :</strong> les professionnels, avis, tarifs, coordonnées et disponibilités affichés sont fictifs. Les demandes d'intervention sont enregistrées dans ce navigateur et ne sont transmises à personne.</span></p>

        <div class="summary-grid svc-tiles" data-specialty-tiles role="group" aria-label="Filtrer par spécialité"></div>

        <div class="filter-bar">
          <span class="filter-bar__label">Filtrer</span>
          <div class="filter-search">
            <span data-icon="search"></span>
            <label class="sr-only" for="pro-search">Rechercher un professionnel</label>
            <input id="pro-search" type="search" placeholder="Nom, compétence, quartier…" data-pro-search>
          </div>
          <label class="sr-only" for="pro-gov">Localisation</label>
          <select class="select" id="pro-gov" data-pro-gov style="width:auto;min-height:34px;padding-block:6px;font-size:12px;"></select>
          <label class="sr-only" for="pro-availability">Disponibilité</label>
          <select class="select" id="pro-availability" data-pro-availability style="width:auto;min-height:34px;padding-block:6px;font-size:12px;">
            <option value="">Toutes disponibilités</option>
            <option value="now">Disponible aujourd'hui</option>
            <option value="week">Disponible cette semaine</option>
          </select>
          <label class="checkbox" style="align-items:center;"><input type="checkbox" data-pro-verified> Vérifiés uniquement</label>
          <span class="filter-bar__spacer"></span>
          <label class="sr-only" for="pro-sort">Trier</label>
          <select class="select" id="pro-sort" data-pro-sort style="width:auto;min-height:34px;padding-block:6px;font-size:12px;">
            <option value="rating">Mieux notés</option>
            <option value="reviews">Plus d'avis</option>
            <option value="name">Nom (A → Z)</option>
          </select>
        </div>

        <div class="svc-layout">
          <div class="svc-stack">
            <div class="svc-toolbar" style="margin-bottom:0;">
              <p class="text-muted" style="font-size:12.5px;" data-pro-caption aria-live="polite">Chargement…</p>
              <button class="text-link" type="button" data-pro-reset>Réinitialiser les filtres</button>
            </div>
            <div class="svc-pro-grid" data-pro-grid></div>
          </div>

          <aside class="svc-stack">
            <article class="card" id="my-requests">
              <div class="card__header">
                <div>
                  <h2 class="card__title">Mes demandes</h2>
                  <p class="svc-card-sub">Suivi de vos demandes d'intervention</p>
                </div>
                <span class="status-badge status-badge--normal" data-request-count>0</span>
              </div>
              <div class="svc-list" data-request-list></div>
            </article>
            <article class="card">
              <div class="card__body">
                <h2 class="svc-section-title">Comment ça marche ?</h2>
                <ul class="svc-timeline">
                  <li class="is-done"><span class="svc-timeline__dot"><span data-icon="search"></span></span><div><strong>Choisissez un professionnel</strong><p>Comparez spécialités, avis et zones d'intervention.</p></div></li>
                  <li class="is-done"><span class="svc-timeline__dot"><span data-icon="send"></span></span><div><strong>Décrivez votre problème</strong><p>Précisez l'urgence et le créneau souhaité.</p></div></li>
                  <li class="is-done"><span class="svc-timeline__dot"><span data-icon="calendar"></span></span><div><strong>Suivez l'intervention</strong><p>Acceptation, planification puis réalisation.</p></div></li>
                  <li class="is-done"><span class="svc-timeline__dot"><span data-icon="star"></span></span><div><strong>Évaluez le travail</strong><p>Votre avis aide les autres citoyens.</p></div></li>
                </ul>
              </div>
            </article>
          </aside>
        </div>
      </div>
    </section>

    <!-- Profil détaillé -->
    <div class="modal svc-modal" id="pro-modal" role="dialog" aria-modal="true" aria-labelledby="pro-modal-title" hidden>
      <div class="modal__panel modal__panel--wide">
        <div class="modal__head">
          <div>
            <h2 id="pro-modal-title">Profil</h2>
            <p data-pro-modal-sub></p>
          </div>
          <button class="modal__close" type="button" data-svc-close aria-label="Fermer"><span data-icon="x"></span></button>
        </div>
        <div class="svc-modal__body" data-pro-modal-body></div>
        <div class="svc-modal__foot" data-pro-modal-foot></div>
      </div>
    </div>

    <!-- Demande d'intervention -->
    <div class="modal svc-modal" id="request-modal" role="dialog" aria-modal="true" aria-labelledby="request-modal-title" hidden>
      <div class="modal__panel">
        <div class="modal__head">
          <div>
            <h2 id="request-modal-title">Demande d'intervention</h2>
            <p>Les champs marqués sont obligatoires.</p>
          </div>
          <button class="modal__close" type="button" data-svc-close aria-label="Fermer"><span data-icon="x"></span></button>
        </div>
        <form class="svc-modal__body form-grid" data-request-form novalidate>
          <div class="field">
            <label for="req-pro">Professionnel *</label>
            <select class="select" id="req-pro" name="providerId" data-required="Choisissez un professionnel."></select>
            <p class="field__error" id="req-pro-error" data-error-for="providerId"></p>
            <p class="svc-notice svc-notice--warning" data-busy-note hidden style="margin:4px 0 0;"><span data-icon="clock"></span><span>Ce professionnel est complet ce mois-ci : votre demande sera placée en liste d'attente.</span></p>
          </div>
          <div class="form-row">
            <div class="field">
              <label for="req-problem">Type de problème *</label>
              <select class="select" id="req-problem" name="problem" data-required="Précisez le type de problème."></select>
              <p class="field__error" id="req-problem-error" data-error-for="problem"></p>
            </div>
            <div class="field">
              <label>Urgence *</label>
              <div class="svc-radio-row">
                <label class="svc-radio"><input type="radio" name="urgency" value="normale" data-required="Indiquez l'urgence."><span>Normale</span></label>
                <label class="svc-radio"><input type="radio" name="urgency" value="urgente"><span>Urgente (24 h)</span></label>
              </div>
              <p class="field__error" id="req-urgency-error" data-error-for="urgency"></p>
            </div>
          </div>
          <div class="field">
            <label for="req-desc">Description du problème *</label>
            <textarea class="textarea" id="req-desc" name="description" maxlength="600" placeholder="Que se passe-t-il ? Depuis quand ? Quels appareils sont concernés ?" data-required="Décrivez votre problème." data-min="20" data-max="600"></textarea>
            <p class="field__hint" data-desc-count>0 / 600 caractères</p>
            <p class="field__error" id="req-desc-error" data-error-for="description"></p>
          </div>
          <div class="form-row">
            <div class="field">
              <label for="req-gov">Gouvernorat *</label>
              <select class="select" id="req-gov" name="gov" data-required="Choisissez un gouvernorat."></select>
              <p class="field__error" id="req-gov-error" data-error-for="gov"></p>
            </div>
            <div class="field">
              <label for="req-area">Quartier *</label>
              <input class="input" id="req-area" name="area" maxlength="60" placeholder="ex. El Menzah 6" data-required="Indiquez votre quartier." data-min="2">
              <p class="field__error" id="req-area-error" data-error-for="area"></p>
            </div>
          </div>
          <div class="form-row">
            <div class="field">
              <label for="req-date">Date souhaitée *</label>
              <input class="input" id="req-date" name="date" type="date" data-required="Choisissez une date." data-not-past>
              <p class="field__error" id="req-date-error" data-error-for="date"></p>
            </div>
            <div class="field">
              <label for="req-slot">Créneau</label>
              <select class="select" id="req-slot" name="slot">
                <option value="matin">Matin (8h – 12h)</option>
                <option value="apres-midi">Après-midi (12h – 17h)</option>
                <option value="soir">Fin de journée (17h – 20h)</option>
              </select>
            </div>
          </div>
          <div class="field">
            <label for="req-phone">Téléphone de contact *</label>
            <input class="input" id="req-phone" name="phone" type="tel" inputmode="tel" maxlength="17" placeholder="ex. 22 123 456" data-required="Indiquez un numéro de téléphone." data-pattern="phone">
            <p class="field__hint">Communiqué uniquement au professionnel choisi.</p>
            <p class="field__error" id="req-phone-error" data-error-for="phone"></p>
          </div>
          <label class="checkbox"><input type="checkbox" name="consent" data-required="Votre accord est nécessaire pour envoyer la demande."> J'accepte que ma demande et mon numéro soient transmis à ce professionnel.</label>
          <p class="field__error" id="req-consent-error" data-error-for="consent"></p>
          <div class="svc-actions" style="justify-content:flex-end;">
            <button class="btn btn--outline btn--sm" type="button" data-svc-close>Annuler</button>
            <button class="btn btn--primary btn--sm" type="submit"><span data-icon="send"></span>Envoyer la demande</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Suivi d'une demande -->
    <div class="modal svc-modal" id="request-detail" role="dialog" aria-modal="true" aria-labelledby="request-detail-title" hidden>
      <div class="modal__panel">
        <div class="modal__head">
          <div>
            <h2 id="request-detail-title">Suivi de la demande</h2>
            <p data-request-detail-sub></p>
          </div>
          <button class="modal__close" type="button" data-svc-close aria-label="Fermer"><span data-icon="x"></span></button>
        </div>
        <div class="svc-modal__body" data-request-detail-body></div>
        <div class="svc-modal__foot" data-request-detail-foot></div>
      </div>
    </div>
  </main>
