<?php
/**
 * Module 4 — Assistance d'urgence, solaire & fournisseurs (Bechir)
 * Entités : DemandeAssistance, Reponse
 */

declare(strict_types=1);

class DemandeAssistanceController extends Controller
{
    /** FO — Service « Relais de voisinage » : demandes et offres d'entraide entre voisins. */
    public function relais(): void
    {
        $this->renderService(
            'assistance/relais',
            'relais',
            'Relais de voisinage — WASLA',
            "Demandez ou proposez de l'aide près de chez vous : eau potable, recharge, hébergement, transport, assistance aux personnes âgées.",
            'relais'
        );
    }

    /** FO — Service « Priorité santé » : enregistrement et suivi des personnes vulnérables. */
    public function sante(): void
    {
        $this->renderService(
            'assistance/sante',
            'sante',
            'Priorité santé — WASLA',
            "Signalez une personne dont la santé dépend de l'eau ou de l'électricité pour qu'elle soit prise en compte en priorité lors des coupures.",
            'sante'
        );
    }
}
