<?php
/**
 * Classe de base des modèles.
 *
 * Fournit la connexion PDO partagée (une seule connexion par requête).
 * Au premier appel, la base et les tables nécessaires sont créées si elles
 * n'existent pas encore, et le compte super administrateur est ajouté :
 * aucun import manuel n'est nécessaire (le script database/wasla.sql reste
 * disponible pour phpMyAdmin).
 */

declare(strict_types=1);

abstract class Model
{
    private static ?PDO $pdo = null;

    protected static function db(): PDO
    {
        if (self::$pdo === null) {
            $config = require __DIR__ . '/../config.php';
            self::$pdo = self::connect($config['db']);
            self::install(self::$pdo, $config);
        }
        return self::$pdo;
    }

    private static function connect(array $db): PDO
    {
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        if ($db['driver'] === 'sqlite') {
            $dir = dirname($db['sqlite_path']);
            if (!is_dir($dir)) {
                mkdir($dir, 0775, true);
            }
            return new PDO('sqlite:' . $db['sqlite_path'], null, null, $options);
        }

        $server = sprintf('mysql:host=%s;port=%d;charset=utf8mb4', $db['host'], (int) $db['port']);
        $pdo = new PDO($server, $db['user'], $db['password'], $options);
        $name = str_replace('`', '', $db['name']);
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $pdo->exec("USE `$name`");
        return $pdo;
    }

    /** Crée la table utilisateur si besoin et garantit l'existence du super admin. */
    private static function install(PDO $pdo, array $config): void
    {
        if ($pdo->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite') {
            $pdo->exec("CREATE TABLE IF NOT EXISTS utilisateur (
                id_utilisateur INTEGER PRIMARY KEY AUTOINCREMENT,
                nom            VARCHAR(80)  NOT NULL,
                prenom         VARCHAR(80)  NOT NULL,
                email          VARCHAR(180) NOT NULL UNIQUE,
                telephone      VARCHAR(20)  NULL,
                gouvernorat    VARCHAR(60)  NULL,
                mot_de_passe   VARCHAR(255) NOT NULL,
                role           VARCHAR(20)  NOT NULL DEFAULT 'citoyen',
                date_creation  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP
            )");
        } else {
            $pdo->exec(file_get_contents(__DIR__ . '/../../database/wasla.sql') ?: '');
        }

        $admin = $config['super_admin'];
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM utilisateur WHERE role = :role');
        $stmt->execute(['role' => 'admin']);
        if ((int) $stmt->fetchColumn() === 0) {
            $insert = $pdo->prepare(
                'INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, role)
                 VALUES (:nom, :prenom, :email, :mdp, :role)'
            );
            $insert->execute([
                'nom'    => $admin['nom'],
                'prenom' => $admin['prenom'],
                'email'  => strtolower($admin['email']),
                'mdp'    => password_hash($admin['password'], PASSWORD_DEFAULT),
                'role'   => 'admin',
            ]);
        }
    }
}
