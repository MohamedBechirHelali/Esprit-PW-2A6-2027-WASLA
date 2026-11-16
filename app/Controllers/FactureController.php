<?php
/**
 * Module 2 — Analyse des factures & consommation (Hiba)
 * Entités : Facture, AnalyseFacture
 */

declare(strict_types=1);

class FactureController extends Controller
{
    /** FO — Service « Factures & IA » : suivi des factures, analyse et assistant. */
    public function index(): void
    {
        $this->renderService(
            'factures/factures-ia',
            'factures',
            'Factures & IA — WASLA',
            "Suivez vos factures d'eau et d'électricité, comprenez vos consommations et obtenez des conseils pour économiser.",
            'factures'
        );
    }
}
