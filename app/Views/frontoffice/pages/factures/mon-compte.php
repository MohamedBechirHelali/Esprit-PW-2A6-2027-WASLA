<?php
/* Espace personnel — le layout ajoute head, header, footer et scripts.
 * Variable : $user (utilisateur connecté). */
$memberSince = date('d/m/Y', strtotime($user['date_creation']) ?: time());
$isAdmin = Utilisateur::isBackOffice($user);
?>
  <main id="main">
    <section class="page-hero">
      <div class="container">
        <nav class="breadcrumbs" aria-label="Fil d'Ariane">
          <a href="<?= url('accueil') ?>">Accueil</a>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="icon-dir"><path d="m9 18 6-6-6-6"/></svg>
          <span aria-current="page">Mon espace</span>
        </nav>
        <div class="page-hero__row">
          <div>
            <p class="eyebrow">Mon espace</p>
            <h1>Bonjour, <?= e($user['prenom']) ?></h1>
            <p>Retrouvez ici l'état du réseau dans votre gouvernorat, vos analyses et les services WASLA.</p>
          </div>
          <div class="page-hero__actions">
<?php if ($isAdmin): ?>
            <a class="btn btn--primary" href="<?= url('dashboard') ?>"><span data-icon="settings"></span> Administration</a>
<?php endif; ?>
            <form method="post" action="<?= url('deconnexion') ?>">
              <?= csrfField() ?>
              <button class="btn btn--outline" type="submit"><span data-icon="log-out"></span> Se déconnecter</button>
            </form>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section">
      <div class="container account-grid">
        <aside class="card account-profile">
          <div class="account-profile__head">
            <span class="account-avatar" aria-hidden="true"><?= e(initials($user)) ?></span>
            <div>
              <h2><?= e($user['prenom'] . ' ' . $user['nom']) ?></h2>
              <span class="chip"><?= e(roleLabel($user['role'])) ?></span>
            </div>
          </div>
          <dl class="account-details">
            <div><dt>Adresse e-mail</dt><dd><?= e($user['email']) ?></dd></div>
            <div><dt>Téléphone</dt><dd><?= e($user['telephone'] ?: '—') ?></dd></div>
            <div><dt>Gouvernorat</dt><dd><?= e($user['gouvernorat'] ?: '—') ?></dd></div>
            <div><dt>Membre depuis</dt><dd><?= e($memberSince) ?></dd></div>
          </dl>
        </aside>

        <div class="account-main">
          <h2 class="account-title">Accès rapides</h2>
          <div class="account-actions">
            <a class="service-card account-action" href="<?= url('carte') ?>">
              <span class="service-card__icon" data-icon="map"></span>
              <h3>Carte des réseaux</h3>
              <p>Consultez l'état de l'électricité et de l'eau<?= $user['gouvernorat'] ? ' à ' . e($user['gouvernorat']) : '' ?> et signalez une coupure.</p>
            </a>
            <a class="service-card account-action" href="<?= url('analyses') ?>">
              <span class="service-card__icon service-card__icon--green" data-icon="chart-line"></span>
              <h3>Analyses &amp; consommation</h3>
              <p>Suivez les tendances de consommation et comparez-les à la moyenne de votre zone.</p>
            </a>
            <a class="service-card account-action" href="<?= url('services', 'alertes') ?>">
              <span class="service-card__icon service-card__icon--amber" data-icon="bell"></span>
              <h3>Alertes personnalisées</h3>
              <p>Soyez prévenu des interruptions planifiées et des incidents dans votre zone.</p>
            </a>
            <a class="service-card account-action" href="<?= url('services', 'factures') ?>">
              <span class="service-card__icon service-card__icon--navy" data-icon="file-text"></span>
              <h3>Factures</h3>
              <p>Analysez vos factures STEG et SONEDE et recevez des recommandations.</p>
            </a>
            <a class="service-card account-action" href="<?= url('services', 'refuge') ?>">
              <span class="service-card__icon" data-icon="home"></span>
              <h3>Zones refuge</h3>
              <p>Trouvez un lieu pour accéder à l'eau ou à l'électricité pendant une coupure.</p>
            </a>
            <a class="service-card account-action" href="<?= url('services', 'sante') ?>">
              <span class="service-card__icon service-card__icon--red" data-icon="heart-pulse"></span>
              <h3>Assistance d'urgence</h3>
              <p>Demandez de l'aide à un bénévole, un fournisseur ou un propriétaire solaire.</p>
            </a>
          </div>
        </div>
      </div>
    </section>
  </main>
