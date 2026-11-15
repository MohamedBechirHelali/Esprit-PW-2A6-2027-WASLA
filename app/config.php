<?php
/**
 * Configuration de l'application.
 *
 * Pour changer ces valeurs sur votre machine sans les envoyer sur GitHub,
 * créez app/config.local.php qui retourne un tableau avec les clés à remplacer
 * (ce fichier est ignoré par Git). Exemple :
 *
 *   <?php return ['db' => ['password' => 'monMotDePasse']];
 */

$config = [
    'db' => [
        // 'mysql' (Laragon / XAMPP / WAMP) ou 'sqlite' (aucun serveur à installer)
        'driver'   => 'mysql',
        'host'     => '127.0.0.1',
        'port'     => 3306,
        'name'     => 'wasla',
        'user'     => 'root',
        'password' => '',
        // Utilisé seulement si driver = 'sqlite'
        'sqlite_path' => __DIR__ . '/../database/wasla.sqlite',
    ],

    // Compte super administrateur créé automatiquement au premier lancement
    // s'il n'existe pas encore dans la table utilisateur.
    'super_admin' => [
        'nom'      => 'Admin',
        'prenom'   => 'Super',
        'email'    => 'admin@wasla.tn',
        'password' => 'Admin@2026',
    ],
];

$local = __DIR__ . '/config.local.php';
if (is_file($local)) {
    $config = array_replace_recursive($config, require $local);
}

return $config;
