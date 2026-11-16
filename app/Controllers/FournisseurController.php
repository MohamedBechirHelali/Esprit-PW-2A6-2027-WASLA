<?php
/**
 * Module 4 — Assistance d'urgence, solaire & fournisseurs (Bechir)
 * Entités : Fournisseur, Service
 */

declare(strict_types=1);

class FournisseurController extends Controller
{
    /** FO — Service « Fournisseurs » : annuaire des professionnels et demandes d'intervention. */
    public function index(): void
    {
        $this->renderService(
            'assistance/fournisseurs',
            'fournisseurs',
            'Fournisseurs & techniciens — WASLA',
            "Trouvez un électricien, un plombier ou un installateur solaire vérifié près de chez vous et envoyez une demande d'intervention.",
            'fournisseurs'
        );
    }
}
