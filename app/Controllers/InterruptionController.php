<?php
/**
 * Module 1 — Interruptions, signalements & alertes (Houssem)
 * Entité : Interruption
 */

declare(strict_types=1);

class InterruptionController extends Controller
{
    /** FO — Cas d'utilisation « Consulter la carte des interruptions » (contient aussi le formulaire de signalement). */
    public function carte(): void
    {
        $this->render('interruptions/carte', [
            'page'        => 'carte',
            'title'       => 'Carte des réseaux — WASLA',
            'description' => "Visualisez l'état de l'électricité et de l'eau dans les 24 gouvernorats de Tunisie, filtrez par statut et signalez une coupure avec WASLA.",
            'css'         => ['home', 'pages'],
            'scripts'     => ['data/tunisia.js', 'js/data.js', 'js/icons.js', 'js/layout.js', 'js/map.js', 'js/pages.js'],
        ]);
    }

    /** BO — « Publier / modifier / clôturer une interruption » : liste (sous-admin STEG/SONEDE). */
    public function adminListe(): void
    {
        $this->render('interruptions/liste', [
            'office' => 'backoffice',
            'page'   => 'admin-interruptions',
            'title'  => 'Interruptions — WASLA Admin',
        ]);
    }

    /** BO — formulaire de publication / modification d'une interruption. */
    public function adminForm(): void
    {
        $this->render('interruptions/form', [
            'office' => 'backoffice',
            'page'   => 'admin-interruption-form',
            'title'  => 'Publier une interruption — WASLA Admin',
        ]);
    }
}
