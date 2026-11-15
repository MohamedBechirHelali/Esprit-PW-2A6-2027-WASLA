<?php
/**
 * Table partagée Utilisateur (connexion, inscription, profil).
 */

declare(strict_types=1);

require_once __DIR__ . '/Model.php';

class Utilisateur extends Model
{
    /** Rôles qui donnent accès au Back Office. */
    public const BACKOFFICE_ROLES = ['admin', 'steg', 'sonede'];

    public static function findByEmail(string $email): ?array
    {
        $stmt = self::db()->prepare('SELECT * FROM utilisateur WHERE email = :email');
        $stmt->execute(['email' => strtolower(trim($email))]);
        return $stmt->fetch() ?: null;
    }

    public static function findById(int $id): ?array
    {
        $stmt = self::db()->prepare('SELECT * FROM utilisateur WHERE id_utilisateur = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    /** Vérifie l'e-mail et le mot de passe ; retourne l'utilisateur ou null. */
    public static function authenticate(string $email, string $password): ?array
    {
        $user = self::findByEmail($email);
        if ($user === null || !password_verify($password, $user['mot_de_passe'])) {
            return null;
        }
        return $user;
    }

    /** Crée un compte citoyen et retourne son identifiant. */
    public static function create(array $data): int
    {
        $stmt = self::db()->prepare(
            'INSERT INTO utilisateur (nom, prenom, email, telephone, gouvernorat, mot_de_passe, role)
             VALUES (:nom, :prenom, :email, :telephone, :gouvernorat, :mdp, :role)'
        );
        $stmt->execute([
            'nom'         => $data['nom'],
            'prenom'      => $data['prenom'],
            'email'       => strtolower(trim($data['email'])),
            'telephone'   => $data['telephone'] !== '' ? $data['telephone'] : null,
            'gouvernorat' => $data['gouvernorat'] !== '' ? $data['gouvernorat'] : null,
            'mdp'         => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'        => 'citoyen',
        ]);
        return (int) self::db()->lastInsertId();
    }

    public static function isBackOffice(array $user): bool
    {
        return in_array($user['role'], self::BACKOFFICE_ROLES, true);
    }
}
