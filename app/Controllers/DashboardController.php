<?php
/**
 * Back Office — page commune : tableau de bord.
 */

declare(strict_types=1);

class DashboardController extends Controller
{
    public function index(): void
    {
        $this->render('dashboard', [
            'office'  => 'backoffice',
            'page'    => 'dashboard',
            'title'   => 'Tableau de bord — WASLA Admin',
            // Graphiques réutilisés du Front Office (données fictives de data.js)
            'scripts' => ['js/data.js', 'js/charts.js'],
        ]);
    }
}
