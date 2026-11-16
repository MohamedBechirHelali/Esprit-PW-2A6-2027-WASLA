<?php
/**
 * Petites fonctions utilitaires utilisées par les vues.
 */

declare(strict_types=1);

/** Pages du menu « Services » : le lien Services du menu reste actif sur chacune d'elles. */
const SERVICE_PAGES = ['services', 'alertes', 'factures', 'fournisseurs', 'refuges', 'relais', 'sante'];

/**
 * Retourne la classe CSS « active » si $page est la page courante.
 * Même rôle que navActive() dans l'atelier.
 */
function isActive(string $page, string $currentPage, string $class = 'is-active'): string
{
    return $page === $currentPage ? $class : '';
}

/**
 * Retourne l'attribut aria-current si $page est la page courante (accessibilité).
 */
function ariaCurrent(string $page, string $currentPage): string
{
    return $page === $currentPage ? 'aria-current="page"' : '';
}

/**
 * Retourne la classe « is-open » si la page courante fait partie du groupe
 * (sous-menu de la sidebar du Back Office). Même rôle que isOpen() dans l'atelier.
 */
function isOpen(array $pages, string $currentPage): string
{
    return in_array($currentPage, $pages, true) ? 'is-open' : '';
}

/**
 * Indique si une page est déclarée dans app/routes.php.
 * Sert à n'activer un lien du menu que lorsque la page existe vraiment.
 */
function routeExists(string $page): bool
{
    static $routes = null;
    if ($routes === null) {
        $routes = require __DIR__ . '/routes.php';
    }
    return isset($routes[$page]);
}

/**
 * Lien vers une page si elle existe, sinon « # » (page pas encore créée).
 */
function pageUrl(string $page, string $anchor = ''): string
{
    return routeExists($page) ? url($page, $anchor) : '#';
}

/**
 * Échappe un texte avant de l'afficher dans le HTML (protection XSS).
 */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Chemin public d'un fichier d'assets.
 * Exemple : asset('css/tokens.css') → app/Views/frontoffice/assets/css/tokens.css
 */
function asset(string $path, string $office = 'frontoffice'): string
{
    return 'app/Views/' . $office . '/assets/' . ltrim($path, '/');
}

/**
 * Lien vers une page de l'application, via le routeur.
 * Exemple : url('services', 'refuge') → index.php?page=services#refuge
 */
function url(string $page, string $anchor = ''): string
{
    return 'index.php?page=' . rawurlencode($page) . ($anchor !== '' ? '#' . $anchor : '');
}
