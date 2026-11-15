<?php
/**
 * Module 2 — Analyse des factures & consommation (Hiba)
 * Entité : Consommation
 */

declare(strict_types=1);

class ConsommationController extends Controller
{
    /** FO — Cas d'utilisation « Consulter sa consommation ». */
    public function analyses(): void
    {
        $this->render('factures/analyses', [
            'page'        => 'analyses',
            'title'       => 'Analyses & tendances — WASLA',
            'description' => "Suivez l'évolution de la consommation d'électricité et d'eau, identifiez les zones à risque et consultez les derniers incidents en Tunisie.",
            'scripts'     => ['js/data.js', 'js/icons.js', 'js/layout.js', 'js/charts.js', 'js/pages.js'],
        ]);
    }
}
