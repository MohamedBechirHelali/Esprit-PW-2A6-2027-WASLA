<?php
/**
 * Module 2 — Analyse des factures & consommation (Hiba)
 * Table partagée : Utilisateur (connexion, inscription, profil, comptes citoyens)
 */

declare(strict_types=1);

class UtilisateurController extends Controller
{
    public const GOUVERNORATS = [
        'Ariana', 'Béja', 'Ben Arous', 'Bizerte', 'Gabès', 'Gafsa', 'Jendouba', 'Kairouan',
        'Kasserine', 'Kébili', 'Le Kef', 'Mahdia', 'La Manouba', 'Médenine', 'Monastir', 'Nabeul',
        'Sfax', 'Sidi Bouzid', 'Siliana', 'Sousse', 'Tataouine', 'Tozeur', 'Tunis', 'Zaghouan',
    ];

    /** FO — Cas d'utilisation « S'authentifier ». */
    public function connexion(): void
    {
        // Déjà connecté : on va directement à son espace
        if (($user = currentUser()) !== null) {
            redirect(homeFor($user));
        }

        $errors = [];
        $old = ['email' => ''];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim((string) ($_POST['email'] ?? ''));
            $password = (string) ($_POST['password'] ?? '');
            $old['email'] = $email;

            if (!csrfValid()) {
                $errors['form'] = 'Votre session a expiré. Veuillez réessayer.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
                $errors['form'] = 'Veuillez saisir votre adresse e-mail et votre mot de passe.';
            } elseif (($user = Utilisateur::authenticate($email, $password)) === null) {
                $errors['form'] = 'Adresse e-mail ou mot de passe incorrect.';
            } else {
                loginUser($user);
                flash('success', Utilisateur::isBackOffice($user)
                    ? 'Connecté en tant que ' . roleLabel($user['role']) . '. Bienvenue dans le Back Office.'
                    : 'Bienvenue, ' . $user['prenom'] . ' !');
                redirect(homeFor($user));
            }
        }

        $this->render('factures/connexion', [
            'page'        => 'connexion',
            'title'       => 'Connexion — WASLA',
            'description' => 'Connectez-vous à votre espace citoyen WASLA pour suivre vos factures, recevoir des alertes personnalisées et accéder aux services prioritaires.',
        ], compact('errors', 'old'));
    }

    /** FO — Cas d'utilisation « S'inscrire ». */
    public function inscription(): void
    {
        if (($user = currentUser()) !== null) {
            redirect(homeFor($user));
        }

        $errors = [];
        $old = ['nom' => '', 'prenom' => '', 'email' => '', 'telephone' => '', 'gouvernorat' => ''];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($old as $key => $_) {
                $old[$key] = trim((string) ($_POST[$key] ?? ''));
            }
            $password = (string) ($_POST['password'] ?? '');
            $confirm = (string) ($_POST['password_confirm'] ?? '');
            $old['telephone'] = preg_replace('/[\s.-]/', '', $old['telephone']) ?? '';

            if (!csrfValid()) {
                $errors['form'] = 'Votre session a expiré. Veuillez réessayer.';
            }
            if (!preg_match("/^[\\p{L}][\\p{L}' -]{1,79}$/u", $old['nom'])) {
                $errors['nom'] = 'Veuillez saisir un nom valide (lettres uniquement).';
            }
            if (!preg_match("/^[\\p{L}][\\p{L}' -]{1,79}$/u", $old['prenom'])) {
                $errors['prenom'] = 'Veuillez saisir un prénom valide (lettres uniquement).';
            }
            if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL) || strlen($old['email']) > 180) {
                $errors['email'] = 'Veuillez saisir une adresse e-mail valide.';
            } elseif (Utilisateur::findByEmail($old['email']) !== null) {
                $errors['email'] = 'Un compte existe déjà avec cette adresse e-mail.';
            }
            if ($old['telephone'] !== '' && !preg_match('/^(\+216)?[2-9]\d{7}$/', $old['telephone'])) {
                $errors['telephone'] = 'Numéro tunisien à 8 chiffres attendu (ex. 22 123 456).';
            }
            if ($old['gouvernorat'] === '' || !in_array($old['gouvernorat'], self::GOUVERNORATS, true)) {
                $errors['gouvernorat'] = 'Veuillez choisir votre gouvernorat.';
            }
            if (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
                $errors['password'] = 'Au moins 8 caractères, dont une lettre et un chiffre.';
            }
            if ($confirm !== $password) {
                $errors['password_confirm'] = 'Les mots de passe ne correspondent pas.';
            }
            if (empty($_POST['terms'])) {
                $errors['terms'] = "Veuillez accepter les conditions d'utilisation.";
            }

            if ($errors === []) {
                $id = Utilisateur::create($old + ['password' => $password]);
                loginUser(Utilisateur::findById($id));
                flash('success', 'Votre compte a été créé. Bienvenue sur WASLA, ' . $old['prenom'] . ' !');
                redirect('mon-compte');
            }
        }

        $gouvernorats = self::GOUVERNORATS;
        $this->render('factures/inscription', [
            'page'        => 'inscription',
            'title'       => 'Créer un compte — WASLA',
            'description' => 'Créez votre compte citoyen WASLA pour recevoir des alertes, suivre vos factures et accéder aux services prioritaires.',
        ], compact('errors', 'old', 'gouvernorats'));
    }

    /** Déconnexion (formulaire POST protégé par le jeton CSRF). */
    public function deconnexion(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrfValid()) {
            logoutUser();
            startSession();
            flash('success', 'Vous êtes déconnecté. À bientôt !');
        }
        redirect('connexion');
    }

    /** FO — Espace personnel du citoyen connecté. */
    public function monCompte(): void
    {
        requireLogin();

        $this->render('factures/mon-compte', [
            'page'        => 'mon-compte',
            'title'       => 'Mon espace — WASLA',
            'description' => 'Votre espace personnel WASLA.',
            'scripts'     => ['js/data.js', 'js/icons.js', 'js/layout.js', 'js/pages.js'],
        ], ['user' => currentUser()]);
    }
}
