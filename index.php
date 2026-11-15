<?php
/**
 * WASLA — point d'entrée unique (routeur).
 *
 * Toutes les pages passent par ce fichier : index.php?page=<clé>
 * La clé est cherchée dans app/routes.php, qui indique le contrôleur
 * et la méthode à appeler.
 */

declare(strict_types=1);

require_once __DIR__ . '/app/helpers.php';
require_once __DIR__ . '/app/auth.php';
require_once __DIR__ . '/app/Controllers/Controller.php';

startSession();

$routes = require __DIR__ . '/app/routes.php';

$page = $_GET['page'] ?? 'accueil';

if (!is_string($page) || !isset($routes[$page])) {
    http_response_code(404);
    $page = 'accueil';
}

[$controllerName, $method] = $routes[$page];

try {
    // Back Office : réservé aux administrateurs connectés
    if ($page === 'dashboard' || str_starts_with($page, 'admin-')) {
        requireBackOffice();
    }

    require_once __DIR__ . '/app/Controllers/' . $controllerName . '.php';

    (new $controllerName())->$method();
} catch (PDOException $exception) {
    http_response_code(500);
    header('Content-Type: text/html; charset=utf-8');
    echo '<!DOCTYPE html><html lang="fr"><meta charset="UTF-8"><title>Base de données indisponible — WASLA</title>'
       . '<body style="font-family:system-ui,sans-serif;max-width:640px;margin:60px auto;padding:0 16px;line-height:1.6">'
       . '<h1>Base de données indisponible</h1>'
       . '<p>WASLA n\'arrive pas à se connecter à MySQL. Vérifiez que MySQL est démarré (Laragon / XAMPP / WAMP) '
       . 'et que les paramètres de <code>app/config.php</code> sont corrects (hôte, utilisateur, mot de passe).</p>'
       . '<p>Sans MySQL, vous pouvez utiliser SQLite : mettez <code>\'driver\' =&gt; \'sqlite\'</code> dans '
       . '<code>app/config.local.php</code>.</p>'
       . '<pre style="background:#f3f5f8;padding:12px;border-radius:8px;white-space:pre-wrap">' . e($exception->getMessage()) . '</pre>'
       . '</body></html>';
}
