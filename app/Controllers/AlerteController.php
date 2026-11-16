<?php
/**
 * Module 1 — Interruptions, signalements & alertes (Houssem)
 * Entité : Alerte
 */

declare(strict_types=1);

class AlerteController extends Controller
{
    /** FO — Service « Alertes personnalisées » : centre de notifications du citoyen. */
    public function index(): void
    {
        $this->renderService(
            'interruptions/alertes',
            'alertes',
            'Alertes personnalisées — WASLA',
            "Recevez les alertes de coupure d'eau et d'électricité, de fortes chaleurs et d'incidents pour les lieux qui comptent pour vous.",
            'alertes',
            true
        );
    }
}
