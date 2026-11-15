<?php
/**
 * Session et authentification : utilisateur connecté, protection des pages,
 * jeton CSRF et messages flash.
 */

declare(strict_types=1);

require_once __DIR__ . '/Models/Utilisateur.php';

function startSession(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_set_cookie_params([
            'httponly' => true,
            'samesite' => 'Lax',
            'secure'   => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        ]);
        session_name('WASLASESSID');
        session_start();
    }
}

/** Utilisateur connecté (ligne de la table utilisateur) ou null. */
function currentUser(): ?array
{
    static $user = false;
    if ($user === false) {
        $user = null;
        if (isset($_SESSION['user_id'])) {
            $user = Utilisateur::findById((int) $_SESSION['user_id']);
            if ($user === null) {
                unset($_SESSION['user_id']); // compte supprimé entre-temps
            }
        }
    }
    return $user;
}

function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

function isBackOfficeUser(): bool
{
    $user = currentUser();
    return $user !== null && Utilisateur::isBackOffice($user);
}

/** Ouvre la session de l'utilisateur après connexion ou inscription. */
function loginUser(array $user): void
{
    session_regenerate_id(true);
    $_SESSION['user_id'] = (int) $user['id_utilisateur'];
}

function logoutUser(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
}

/** Page d'accueil propre au rôle : Back Office pour les admins, espace citoyen sinon. */
function homeFor(array $user): string
{
    return Utilisateur::isBackOffice($user) ? 'dashboard' : 'mon-compte';
}

function redirect(string $page): never
{
    header('Location: ' . url($page));
    exit;
}

function requireLogin(): void
{
    if (!isLoggedIn() || currentUser() === null) {
        flash('info', 'Veuillez vous connecter pour accéder à cette page.');
        redirect('connexion');
    }
}

function requireBackOffice(): void
{
    requireLogin();
    if (!isBackOfficeUser()) {
        flash('error', "Votre compte n'a pas accès à l'administration.");
        redirect('mon-compte');
    }
}

function csrfToken(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrfField(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrfToken()) . '">';
}

function csrfValid(): bool
{
    $token = $_POST['csrf'] ?? '';
    return is_string($token) && hash_equals(csrfToken(), $token);
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

/** @return array<int, array{type: string, message: string}> */
function takeFlashes(): array
{
    $messages = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $messages;
}

/** Initiales pour l'avatar (ex. « Super Admin » → « SA »). */
function initials(array $user): string
{
    return mb_strtoupper(mb_substr($user['prenom'], 0, 1) . mb_substr($user['nom'], 0, 1));
}

function roleLabel(string $role): string
{
    return [
        'admin'  => 'Super Admin',
        'steg'   => 'Sous-admin STEG',
        'sonede' => 'Sous-admin SONEDE',
        'citoyen' => 'Citoyen',
    ][$role] ?? ucfirst($role);
}
