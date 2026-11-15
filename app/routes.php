<?php
/**
 * Table de routage : 'clé de page' => [Contrôleur, méthode]
 *
 * - Les pages Back Office commencent par « admin- » (ou 'dashboard') : index.php
 *   les réserve automatiquement aux comptes admin / STEG / SONEDE connectés.
 * - Chaque membre ajoute ses routes UNIQUEMENT dans le bloc de son module.
 */

return [
    // ── Commun ─────────────────────────────────────────────────────────
    'accueil'  => ['HomeController', 'accueil'],
    'services' => ['HomeController', 'services'],
    'a-propos' => ['HomeController', 'aPropos'],
    'dashboard' => ['DashboardController', 'index'],             // BO

    // ── Module 1 — Interruptions, signalements & alertes (Houssem) ────
    'carte'                   => ['InterruptionController', 'carte'],
    'admin-interruptions'     => ['InterruptionController', 'adminListe'],   // BO
    'admin-interruption-form' => ['InterruptionController', 'adminForm'],    // BO

    // ── Module 2 — Analyse des factures & consommation (Hiba) ─────────
    'connexion'   => ['UtilisateurController', 'connexion'],
    'inscription' => ['UtilisateurController', 'inscription'],
    'deconnexion' => ['UtilisateurController', 'deconnexion'],
    'mon-compte'  => ['UtilisateurController', 'monCompte'],
    'analyses'  => ['ConsommationController', 'analyses'],

    // ── Module 3 — Refuge Zones (Louay) ───────────────────────────────

    // ── Module 4 — Assistance d'urgence, solaire & fournisseurs (Bechir)
];
