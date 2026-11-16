<?php /* Service 05 — Relais de voisinage. Contenu propre à la page : le layout ajoute head, navbar, footer et scripts.
   Publications, réponses et rapprochements gérés par assets/js/services/relais.js (données de démonstration). */ ?>
  <main id="main" data-service="relais">
    <section class="page-hero">
      <div class="container">
        <nav class="breadcrumbs" aria-label="Fil d'Ariane">
          <a href="<?= url('accueil') ?>">Accueil</a>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="icon-dir"><path d="m9 18 6-6-6-6"/></svg>
          <a href="<?= url('services') ?>">Services</a>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="icon-dir"><path d="m9 18 6-6-6-6"/></svg>
          <span aria-current="page">Relais de voisinage</span>
        </nav>
        <div class="page-hero__row">
          <div>
            <p class="eyebrow">Service 05 · Entraide locale</p>
            <h1>Relais de voisinage</h1>
            <p>Pendant une coupure, un voisin a souvent ce qui vous manque. Demandez de l'aide, proposez la vôtre et laissez WASLA rapprocher les besoins et les offres de votre quartier.</p>
          </div>
          <div class="page-hero__actions">
            <button class="btn btn--outline" type="button" data-new-post="offer">
              <span data-icon="handshake"></span>
              Proposer mon aide
            </button>
            <button class="btn btn--primary" type="button" data-new-post="request">
              <span data-icon="plus"></span>
              Demander de l'aide
            </button>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section page-section--soft">
      <div class="container">
        <p class="svc-notice"><span data-icon="shield-check"></span><span><strong>Confidentialité :</strong> seuls le prénom, l'initiale du nom et le quartier sont affichés, jamais d'adresse exacte. <strong>Démonstration :</strong> les publications existantes sont fictives et vos messages restent dans ce navigateur.</span></p>

        <div class="svc-toolbar">
          <div class="tabs svc-tabs" data-svc-tabs="feed" aria-label="Type de publications">
            <button class="tab is-active" type="button" data-tab="all">Toutes <span class="svc-count" data-feed-count="all">0</span></button>
            <button class="tab" type="button" data-tab="request">Demandes d'aide <span class="svc-count" data-feed-count="request">0</span></button>
            <button class="tab" type="button" data-tab="offer">Offres d'aide <span class="svc-count" data-feed-count="offer">0</span></button>
            <button class="tab" type="button" data-tab="mine">Mes publications <span class="svc-count" data-feed-count="mine">0</span></button>
          </div>
          <div class="svc-toolbar__group">
            <div class="filter-search">
              <span data-icon="search"></span>
              <label class="sr-only" for="post-search">Rechercher une publication</label>
              <input id="post-search" type="search" placeholder="Rechercher…" data-post-search>
            </div>
            <label class="sr-only" for="post-sort">Trier</label>
            <select class="select" id="post-sort" data-post-sort>
              <option value="recent">Plus récentes</option>
              <option value="near">Plus proches de moi</option>
              <option value="urgent">Plus urgentes</option>
            </select>
          </div>
        </div>

        <div class="svc-layout--three svc-layout" style="margin-top:0;">
          <aside class="svc-stack">
            <article class="card svc-filter-card">
              <div class="card__header"><h2 class="card__title" style="font-size:15px;">Filtres</h2><button class="text-link" type="button" data-post-reset>Réinitialiser</button></div>
              <div class="card__body">
                <div class="svc-filter-group">
                  <h3>Mon quartier</h3>
                  <div class="form-grid" style="gap:8px;">
                    <label class="sr-only" for="my-gov">Mon gouvernorat</label>
                    <select class="select" id="my-gov" data-my-gov></select>
                    <label class="sr-only" for="my-area">Mon quartier</label>
                    <input class="input" id="my-area" data-my-area maxlength="60" placeholder="Quartier (ex. El Menzah 6)">
                    <label class="checkbox"><input type="checkbox" data-near-only> Uniquement près de chez moi (≤ 15 km)</label>
                  </div>
                </div>
                <div class="svc-filter-group">
                  <h3>Catégories</h3>
                  <div class="svc-chips" data-post-categories></div>
                </div>
                <div class="svc-filter-group">
                  <h3>Urgence</h3>
                  <div class="svc-chips" data-post-urgency></div>
                </div>
                <div class="svc-filter-group">
                  <h3>Statut</h3>
                  <label class="checkbox"><input type="checkbox" data-show-resolved> Afficher les demandes résolues</label>
                </div>
              </div>
            </article>
          </aside>

          <div class="svc-stack" data-feed aria-live="polite"></div>

          <aside class="svc-stack svc-aside-right">
            <article class="card">
              <div class="card__header">
                <div>
                  <h2 class="card__title" style="font-size:15px;">Correspondances suggérées</h2>
                  <p class="svc-card-sub">Offres proches de vos demandes</p>
                </div>
                <span class="svc-icon svc-icon--sm" data-icon="sparkles"></span>
              </div>
              <div data-match-list></div>
            </article>
            <article class="card">
              <div class="card__body">
                <h2 class="svc-section-title" style="font-size:14px;">Règles de la communauté</h2>
                <ul class="svc-bullets">
                  <li><span data-icon="check"></span>Ne publiez jamais d'adresse exacte ni de numéro de téléphone.</li>
                  <li><span data-icon="check"></span>Rencontrez-vous dans un lieu public ou un point refuge.</li>
                  <li><span data-icon="check"></span>Signalez tout abus : un modérateur vérifie chaque signalement.</li>
                  <li><span data-icon="check"></span>En cas d'urgence vitale, appelez le 190 (SAMU) ou le 198 (Protection civile).</li>
                </ul>
              </div>
            </article>
          </aside>
        </div>
      </div>
    </section>

    <!-- Nouvelle publication -->
    <div class="modal svc-modal" id="post-modal" role="dialog" aria-modal="true" aria-labelledby="post-modal-title" hidden>
      <div class="modal__panel">
        <div class="modal__head">
          <div>
            <h2 id="post-modal-title">Nouvelle publication</h2>
            <p>Votre adresse exacte n'est jamais affichée : seul le quartier est visible.</p>
          </div>
          <button class="modal__close" type="button" data-svc-close aria-label="Fermer"><span data-icon="x"></span></button>
        </div>
        <form class="svc-modal__body form-grid" data-post-form novalidate>
          <div class="field">
            <label>Type de publication *</label>
            <div class="svc-radio-row">
              <label class="svc-radio"><input type="radio" name="type" value="request" data-required="Choisissez un type."><span><span data-icon="circle-alert"></span>J'ai besoin d'aide</span></label>
              <label class="svc-radio"><input type="radio" name="type" value="offer"><span><span data-icon="handshake"></span>Je propose mon aide</span></label>
            </div>
            <p class="field__error" id="post-type-error" data-error-for="type"></p>
          </div>
          <div class="field">
            <label for="post-category">Catégorie *</label>
            <select class="select" id="post-category" name="category" data-required="Choisissez une catégorie."></select>
            <p class="field__error" id="post-category-error" data-error-for="category"></p>
          </div>
          <div class="field">
            <label for="post-title">Titre *</label>
            <input class="input" id="post-title" name="title" maxlength="80" placeholder="ex. Besoin de 2 bidons d'eau potable" data-required="Donnez un titre à votre publication." data-min="8" data-no-phone>
            <p class="field__error" id="post-title-error" data-error-for="title"></p>
          </div>
          <div class="field">
            <label for="post-text">Description *</label>
            <textarea class="textarea" id="post-text" name="text" maxlength="500" placeholder="Décrivez le besoin ou l'aide proposée, sans adresse exacte ni numéro de téléphone." data-required="Ajoutez une description." data-min="20" data-max="500" data-no-phone></textarea>
            <p class="field__error" id="post-text-error" data-error-for="text"></p>
          </div>
          <div class="form-row">
            <div class="field">
              <label for="post-gov">Gouvernorat *</label>
              <select class="select" id="post-gov" name="gov" data-required="Choisissez un gouvernorat."></select>
              <p class="field__error" id="post-gov-error" data-error-for="gov"></p>
            </div>
            <div class="field">
              <label for="post-area">Quartier (approximatif) *</label>
              <input class="input" id="post-area" name="area" maxlength="60" placeholder="ex. El Menzah 6" data-required="Indiquez votre quartier." data-min="2" data-no-phone>
              <p class="field__error" id="post-area-error" data-error-for="area"></p>
            </div>
          </div>
          <div class="field svc-conditional" data-when="request" hidden>
            <label>Niveau d'urgence *</label>
            <div class="svc-radio-row">
              <label class="svc-radio"><input type="radio" name="urgency" value="haute" data-required="Indiquez l'urgence."><span>Urgent</span></label>
              <label class="svc-radio"><input type="radio" name="urgency" value="moyenne"><span>Modéré</span></label>
              <label class="svc-radio"><input type="radio" name="urgency" value="faible"><span>Peu urgent</span></label>
            </div>
            <p class="field__error" id="post-urgency-error" data-error-for="urgency"></p>
          </div>
          <div class="field svc-conditional" data-when="offer" hidden>
            <label for="post-availability">Disponibilité *</label>
            <input class="input" id="post-availability" name="availability" maxlength="60" placeholder="ex. Tous les soirs de 18h à 22h" data-required="Précisez quand vous êtes disponible." data-min="3">
            <p class="field__error" id="post-availability-error" data-error-for="availability"></p>
          </div>
          <label class="checkbox"><input type="checkbox" name="rules" data-required="Merci d'accepter les règles de la communauté."> Je respecte les règles de la communauté et je n'indique pas d'adresse exacte.</label>
          <p class="field__error" id="post-rules-error" data-error-for="rules"></p>
          <div class="svc-actions" style="justify-content:flex-end;">
            <button class="btn btn--outline btn--sm" type="button" data-svc-close>Annuler</button>
            <button class="btn btn--primary btn--sm" type="submit"><span data-icon="send"></span>Publier</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Répondre / contacter -->
    <div class="modal svc-modal" id="reply-modal" role="dialog" aria-modal="true" aria-labelledby="reply-title" hidden>
      <div class="modal__panel modal__panel--narrow">
        <div class="modal__head">
          <div>
            <h2 id="reply-title">Répondre</h2>
            <p data-reply-sub></p>
          </div>
          <button class="modal__close" type="button" data-svc-close aria-label="Fermer"><span data-icon="x"></span></button>
        </div>
        <form class="svc-modal__body form-grid" data-reply-form novalidate>
          <div data-reply-thread></div>
          <div class="field">
            <label for="reply-text" data-reply-label>Votre message *</label>
            <textarea class="textarea" id="reply-text" name="message" maxlength="400" style="min-height:100px;" data-required="Écrivez votre message." data-min="10" data-no-phone data-autofocus></textarea>
            <p class="field__hint" data-reply-hint></p>
            <p class="field__error" id="reply-text-error" data-error-for="message"></p>
          </div>
          <div class="svc-actions" style="justify-content:flex-end;">
            <button class="btn btn--outline btn--sm" type="button" data-svc-close>Annuler</button>
            <button class="btn btn--primary btn--sm" type="submit"><span data-icon="send"></span><span data-reply-submit>Envoyer</span></button>
          </div>
        </form>
      </div>
    </div>

    <!-- Signalement -->
    <div class="modal svc-modal" id="report-modal" role="dialog" aria-modal="true" aria-labelledby="report-post-title" hidden>
      <div class="modal__panel modal__panel--narrow">
        <div class="modal__head">
          <div>
            <h2 id="report-post-title">Signaler un abus</h2>
            <p>La publication sera masquée pour vous et vérifiée par un modérateur.</p>
          </div>
          <button class="modal__close" type="button" data-svc-close aria-label="Fermer"><span data-icon="x"></span></button>
        </div>
        <form class="svc-modal__body form-grid" data-report-post-form novalidate>
          <div class="field">
            <label for="report-reason">Motif *</label>
            <select class="select" id="report-reason" name="reason" data-required="Choisissez un motif.">
              <option value="">Choisir…</option>
              <option>Arnaque ou demande d'argent</option>
              <option>Informations personnelles exposées</option>
              <option>Contenu offensant</option>
              <option>Publication fausse ou trompeuse</option>
              <option>Autre</option>
            </select>
            <p class="field__error" id="report-reason-error" data-error-for="reason"></p>
          </div>
          <div class="field">
            <label for="report-details">Précisions (facultatif)</label>
            <textarea class="textarea" id="report-details" name="details" maxlength="300" style="min-height:80px;"></textarea>
          </div>
          <div class="svc-actions" style="justify-content:flex-end;">
            <button class="btn btn--outline btn--sm" type="button" data-svc-close>Annuler</button>
            <button class="btn btn--secondary btn--sm" type="submit"><span data-icon="flag"></span>Signaler</button>
          </div>
        </form>
      </div>
    </div>
  </main>
