<?php
/**
 * Pages communes du Front Office : accueil, services, à propos.
 */

declare(strict_types=1);

class HomeController extends Controller
{
    public function accueil(): void
    {
        $hero = '  <link rel="preload" href="' . asset('img/hero-coast.jpg') . '" as="image" imagesrcset="'
              . asset('img/hero-coast-960.jpg') . ' 960w, ' . asset('img/hero-coast.jpg') . ' 1920w" imagesizes="100vw">' . "\n";

        $this->render('accueil', [
            'page'        => 'accueil',
            'title'       => 'WASLA — Connecter. Anticiper. Protéger.',
            'description' => "WASLA est une plateforme intelligente pour surveiller, anticiper et gérer les coupures d'eau et d'électricité en Tunisie.",
            'css'         => ['home'],
            'scripts'     => ['data/tunisia.js', 'js/data.js', 'js/icons.js', 'js/layout.js', 'js/charts.js', 'js/map.js'],
            'head'        => $hero,
        ]);
    }

    public function services(): void
    {
        $this->render('services', [
            'page'        => 'services',
            'title'       => 'Services citoyens — WASLA',
            'description' => 'Alertes personnalisées, factures, fournisseurs, zones refuge, relais de voisinage et priorité santé : découvrez les services WASLA.',
        ]);
    }

    public function aPropos(): void
    {
        $this->render('a-propos', [
            'page'        => 'a-propos',
            'title'       => 'À propos — WASLA',
            'description' => "Découvrez la mission, les valeurs et les engagements de WASLA pour une Tunisie plus résiliente face aux coupures d'eau et d'électricité.",
        ]);
    }
}
