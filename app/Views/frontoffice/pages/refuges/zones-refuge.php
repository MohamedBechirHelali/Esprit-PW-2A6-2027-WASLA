<?php /* Service 04 — Zones refuge. Contenu propre à la page : le layout ajoute head, navbar, footer et scripts.
   Carte, liste et fiches gérées par assets/js/services/refuges.js (établissements de démonstration). */ ?>
  <main id="main" data-service="refuges">
    <section class="page-hero">
      <div class="container">
        <nav class="breadcrumbs" aria-label="Fil d'Ariane">
          <a href="<?= url('accueil') ?>">Accueil</a>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="icon-dir"><path d="m9 18 6-6-6-6"/></svg>
          <a href="<?= url('services') ?>">Services</a>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="icon-dir"><path d="m9 18 6-6-6-6"/></svg>
          <span aria-current="page">Zones refuge</span>
        </nav>
        <div class="page-hero__row">
          <div>
            <p class="eyebrow">Service 04 · Points d'accueil</p>
            <h1>Zones refuge</h1>
            <p>Trouvez rapidement un lieu climatisé, un point d'eau potable ou une recharge électrique ouvert près de vous pendant une coupure ou une vague de chaleur.</p>
          </div>
          <div class="page-hero__actions">
            <button class="btn btn--primary" type="button" data-locate-me>
              <span data-icon="locate"></span>
              Me localiser
            </button>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section page-section--soft">
      <div class="container">
        <p class="svc-notice"><span data-icon="info"></span><span><strong>Données de démonstration :</strong> les établissements, horaires, capacités et places disponibles sont fictifs. Les distances sont calculées à vol d'oiseau ; l'itinéraire s'ouvre dans Google Maps vers l'emplacement approximatif.</span></p>

        <div class="summary-grid">
          <div class="summary-card"><span class="summary-card__icon summary-card__icon--green" data-icon="home"></span><div><p class="summary-card__value" data-rstat="open">–</p><p class="summary-card__label">Lieux ouverts</p></div></div>
          <div class="summary-card"><span class="summary-card__icon" data-icon="users"></span><div><p class="summary-card__value" data-rstat="places">–</p><p class="summary-card__label">Places disponibles</p></div></div>
          <div class="summary-card"><span class="summary-card__icon" data-icon="snowflake"></span><div><p class="summary-card__value" data-rstat="clim">–</p><p class="summary-card__label">Espaces climatisés ouverts</p></div></div>
          <div class="summary-card"><span class="summary-card__icon summary-card__icon--amber" data-icon="map-pin"></span><div><p class="summary-card__value" data-rstat="nearest">–</p><p class="summary-card__label" data-rstat-label>Lieu ouvert le plus proche</p></div></div>
        </div>

        <div class="filter-bar">
          <div class="filter-search">
            <span data-icon="search"></span>
            <label class="sr-only" for="refuge-search">Rechercher un lieu</label>
            <input id="refuge-search" type="search" placeholder="Nom, ville, type de lieu…" data-refuge-search>
          </div>
          <span class="filter-bar__label">Équipements</span>
          <div class="svc-chips" data-feature-chips></div>
          <span class="filter-bar__spacer"></span>
          <label class="checkbox" style="align-items:center;"><input type="checkbox" data-only-available> Places disponibles</label>
          <label class="sr-only" for="refuge-distance">Proximité</label>
          <select class="select" id="refuge-distance" data-refuge-distance style="width:auto;min-height:34px;padding-block:6px;font-size:12px;">
            <option value="">Toutes distances</option>
            <option value="5">Moins de 5 km</option>
            <option value="15">Moins de 15 km</option>
            <option value="50">Moins de 50 km</option>
          </select>
        </div>

        <div class="map-page-grid">
          <div class="map-card map-card--page svc-map svc-map--tall" data-map-card>
            <div class="map-card__canvas" data-refuge-map>
              <div class="map-card__label"><span class="live-dot" aria-hidden="true"></span><span data-position-label>Position de référence : Tunis</span></div>
              <div class="map-card__legend" aria-label="Légende">
                <span class="map-card__legend-title">Statut</span>
                <span class="legend-item"><span class="legend-item__dot legend-item__dot--normal"></span>Ouvert</span>
                <span class="legend-item"><span class="legend-item__dot legend-item__dot--watch"></span>Complet</span>
                <span class="legend-item"><span class="legend-item__dot legend-item__dot--nodata"></span>Fermé</span>
                <span class="legend-item"><span class="legend-item__dot" style="background:var(--color-navy)"></span>Vous</span>
              </div>
              <p class="svc-map__empty" hidden>Aucun lieu ne correspond aux filtres</p>
            </div>
          </div>

          <aside class="map-page-side">
            <div class="card">
              <div class="card__header">
                <div>
                  <h2 class="card__title">Lieux d'accueil</h2>
                  <p class="svc-card-sub" data-refuge-caption>Chargement…</p>
                </div>
                <label class="sr-only" for="refuge-origin">Position de référence</label>
                <select class="select" id="refuge-origin" data-refuge-origin style="width:auto;min-height:34px;padding-block:6px;font-size:12px;max-width:150px;"></select>
              </div>
              <div class="svc-refuge-list" data-refuge-list aria-live="polite"></div>
              <div class="card__footer">
                <span>Triés par distance</span>
                <button class="text-link" type="button" data-refuge-reset>Réinitialiser</button>
              </div>
            </div>
          </aside>
        </div>

        <article class="card svc-detail-card" data-refuge-detail style="margin-top:16px;" hidden></article>
      </div>
    </section>

    <!-- Réservation d'une place -->
    <div class="modal svc-modal" id="reserve-modal" role="dialog" aria-modal="true" aria-labelledby="reserve-title" hidden>
      <div class="modal__panel modal__panel--narrow">
        <div class="modal__head">
          <div>
            <h2 id="reserve-title">Réserver une place</h2>
            <p data-reserve-sub></p>
          </div>
          <button class="modal__close" type="button" data-svc-close aria-label="Fermer"><span data-icon="x"></span></button>
        </div>
        <form class="svc-modal__body form-grid" data-reserve-form novalidate>
          <div class="form-row">
            <div class="field">
              <label for="res-name">Nom et prénom *</label>
              <input class="input" id="res-name" name="name" maxlength="80" autocomplete="name" data-required="Indiquez votre nom." data-pattern="name">
              <p class="field__error" id="res-name-error" data-error-for="name"></p>
            </div>
            <div class="field">
              <label for="res-people">Nombre de personnes *</label>
              <input class="input" id="res-people" name="people" type="number" min="1" max="8" value="1" data-required="Indiquez le nombre de personnes.">
              <p class="field__error" id="res-people-error" data-error-for="people"></p>
            </div>
          </div>
          <div class="field">
            <label for="res-phone">Téléphone *</label>
            <input class="input" id="res-phone" name="phone" type="tel" inputmode="tel" maxlength="17" placeholder="ex. 22 123 456" data-required="Indiquez un numéro de téléphone." data-pattern="phone">
            <p class="field__error" id="res-phone-error" data-error-for="phone"></p>
          </div>
          <div class="field">
            <label>Besoins particuliers</label>
            <div class="svc-check-grid">
              <label class="checkbox"><input type="checkbox" name="needs" value="pmr"> Accès fauteuil roulant</label>
              <label class="checkbox"><input type="checkbox" name="needs" value="medical"> Appareil médical à brancher</label>
              <label class="checkbox"><input type="checkbox" name="needs" value="bebe"> Nourrisson</label>
              <label class="checkbox"><input type="checkbox" name="needs" value="senior"> Personne âgée</label>
            </div>
          </div>
          <p class="field__hint">Démonstration : la réservation est enregistrée dans ce navigateur et n'est pas transmise à l'établissement.</p>
          <div class="svc-actions" style="justify-content:flex-end;">
            <button class="btn btn--outline btn--sm" type="button" data-svc-close>Annuler</button>
            <button class="btn btn--primary btn--sm" type="submit"><span data-icon="check"></span>Réserver</button>
          </div>
        </form>
      </div>
    </div>
  </main>
