<?php
/**
 * Module 3 — Refuge Zones (Louay)
 * Entités : RefugeZone, ReservationRefuge
 */

declare(strict_types=1);

class RefugeZoneController extends Controller
{
    /** FO — Service « Zones refuge » : carte et liste des points d'accueil. */
    public function index(): void
    {
        $this->renderService(
            'refuges/zones-refuge',
            'refuges',
            'Zones refuge — WASLA',
            "Trouvez un lieu d'accueil climatisé, un point d'eau potable ou une recharge électrique proche de vous pendant une coupure.",
            'refuges',
            true
        );
    }
}
