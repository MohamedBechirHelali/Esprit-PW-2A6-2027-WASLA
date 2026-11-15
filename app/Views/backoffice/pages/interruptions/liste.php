<?php /* Contenu propre à la page — le layout ajoute head, sidebar, header, footer et scripts. */ ?>
        <div class="admin-page-head">
          <div>
            <nav class="admin-breadcrumb" aria-label="Fil d'Ariane">
              <a href="<?= url('dashboard') ?>">Tableau de bord</a><span>/</span><span>Interruptions &amp; alertes</span>
            </nav>
            <div class="admin-page-head__title">
              <span class="admin-page-head__icon" data-icon="zap"></span>
              <div>
                <h1>Interruptions</h1>
                <p>Coupures d'eau et d'électricité publiées par les sous-admins STEG et SONEDE</p>
              </div>
            </div>
          </div>
          <div class="admin-page-head__actions">
            <a class="admin-btn admin-btn--primary" href="<?= url('admin-interruption-form') ?>"><span data-icon="plus"></span> Publier une interruption</a>
          </div>
        </div>

        <section class="admin-card">
          <div class="admin-toolbar">
            <div class="admin-search">
              <span class="admin-search__icon" data-icon="search"></span>
              <input type="search" placeholder="Rechercher (zone, cause…)" aria-label="Rechercher une interruption" data-table-search>
            </div>
            <select class="admin-select" aria-label="Filtrer par ressource" data-table-filter="ressource">
              <option value="">Toutes les ressources</option>
              <option value="electricite">Électricité</option>
              <option value="eau">Eau</option>
            </select>
            <select class="admin-select" aria-label="Filtrer par statut" data-table-filter="statut">
              <option value="">Tous les statuts</option>
              <option value="planifiee">Planifiée</option>
              <option value="en_cours">En cours</option>
              <option value="terminee">Terminée</option>
            </select>
          </div>

          <div class="admin-table-wrap">
            <table class="admin-table" data-admin-table>
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Ressource</th>
                  <th scope="col">Zone</th>
                  <th scope="col">Début</th>
                  <th scope="col">Fin prévue</th>
                  <th scope="col">Cause</th>
                  <th scope="col">Statut</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr data-ressource="electricite" data-statut="en_cours">
                  <td class="admin-table__id">INT-1042</td>
                  <td><span class="admin-badge admin-badge--info">Électricité</span></td>
                  <td class="admin-table__main">Sfax — Sfax Nord</td>
                  <td>07/11/2026 08:30</td>
                  <td>07/11/2026 14:00</td>
                  <td>Panne transformateur</td>
                  <td><span class="admin-badge admin-badge--danger">En cours</span></td>
                  <td><div class="admin-actions">
                    <a class="admin-action" href="<?= url('admin-interruption-form') ?>" aria-label="Modifier"><span data-icon="pencil"></span></a>
                    <button class="admin-action" type="button" data-action="close" aria-label="Clôturer"><span data-icon="lock"></span></button>
                    <button class="admin-action admin-action--danger" type="button" data-action="delete" aria-label="Supprimer"><span data-icon="trash"></span></button>
                  </div></td>
                </tr>
                <tr data-ressource="eau" data-statut="planifiee">
                  <td class="admin-table__id">INT-1041</td>
                  <td><span class="admin-badge admin-badge--ok">Eau</span></td>
                  <td class="admin-table__main">Ariana — La Soukra</td>
                  <td>09/11/2026 09:00</td>
                  <td>09/11/2026 17:00</td>
                  <td>Travaux sur canalisation</td>
                  <td><span class="admin-badge admin-badge--warn">Planifiée</span></td>
                  <td><div class="admin-actions">
                    <a class="admin-action" href="<?= url('admin-interruption-form') ?>" aria-label="Modifier"><span data-icon="pencil"></span></a>
                    <button class="admin-action" type="button" data-action="close" aria-label="Clôturer"><span data-icon="lock"></span></button>
                    <button class="admin-action admin-action--danger" type="button" data-action="delete" aria-label="Supprimer"><span data-icon="trash"></span></button>
                  </div></td>
                </tr>
                <tr data-ressource="electricite" data-statut="planifiee">
                  <td class="admin-table__id">INT-1040</td>
                  <td><span class="admin-badge admin-badge--info">Électricité</span></td>
                  <td class="admin-table__main">Nabeul — Hammamet</td>
                  <td>10/11/2026 07:00</td>
                  <td>10/11/2026 11:00</td>
                  <td>Maintenance du réseau</td>
                  <td><span class="admin-badge admin-badge--warn">Planifiée</span></td>
                  <td><div class="admin-actions">
                    <a class="admin-action" href="<?= url('admin-interruption-form') ?>" aria-label="Modifier"><span data-icon="pencil"></span></a>
                    <button class="admin-action" type="button" data-action="close" aria-label="Clôturer"><span data-icon="lock"></span></button>
                    <button class="admin-action admin-action--danger" type="button" data-action="delete" aria-label="Supprimer"><span data-icon="trash"></span></button>
                  </div></td>
                </tr>
                <tr data-ressource="eau" data-statut="terminee">
                  <td class="admin-table__id">INT-1039</td>
                  <td><span class="admin-badge admin-badge--ok">Eau</span></td>
                  <td class="admin-table__main">Kébili — Douz</td>
                  <td>05/11/2026 10:15</td>
                  <td>05/11/2026 16:00</td>
                  <td>Surcharge station de pompage</td>
                  <td><span class="admin-badge admin-badge--muted">Terminée</span></td>
                  <td><div class="admin-actions">
                    <a class="admin-action" href="<?= url('admin-interruption-form') ?>" aria-label="Modifier"><span data-icon="pencil"></span></a>
                    <button class="admin-action" type="button" data-action="close" aria-label="Clôturer"><span data-icon="lock"></span></button>
                    <button class="admin-action admin-action--danger" type="button" data-action="delete" aria-label="Supprimer"><span data-icon="trash"></span></button>
                  </div></td>
                </tr>
                <tr data-ressource="electricite" data-statut="terminee">
                  <td class="admin-table__id">INT-1038</td>
                  <td><span class="admin-badge admin-badge--info">Électricité</span></td>
                  <td class="admin-table__main">Kasserine — Zone 1</td>
                  <td>04/11/2026 18:40</td>
                  <td>04/11/2026 21:00</td>
                  <td>Intempéries</td>
                  <td><span class="admin-badge admin-badge--muted">Terminée</span></td>
                  <td><div class="admin-actions">
                    <a class="admin-action" href="<?= url('admin-interruption-form') ?>" aria-label="Modifier"><span data-icon="pencil"></span></a>
                    <button class="admin-action" type="button" data-action="close" aria-label="Clôturer"><span data-icon="lock"></span></button>
                    <button class="admin-action admin-action--danger" type="button" data-action="delete" aria-label="Supprimer"><span data-icon="trash"></span></button>
                  </div></td>
                </tr>
              </tbody>
            </table>
            <p class="admin-empty" data-table-empty hidden>Aucune interruption ne correspond à la recherche.</p>
          </div>

          <div class="admin-table-foot">
            <span><strong data-table-count>5</strong> interruption(s) affichée(s)</span>
            <div class="admin-pagination" aria-label="Pagination">
              <button type="button" aria-label="Page précédente">‹</button>
              <button class="is-active" type="button" aria-current="page">1</button>
              <button type="button">2</button>
              <button type="button" aria-label="Page suivante">›</button>
            </div>
          </div>
        </section>
