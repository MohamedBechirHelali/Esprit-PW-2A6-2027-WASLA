-- WASLA — schéma MySQL (table partagée Utilisateur).
-- La table est créée automatiquement au premier lancement de l'application ;
-- ce script peut aussi être importé à la main dans phpMyAdmin (base « wasla »).
-- Le super administrateur est ajouté par l'application (voir app/config.php).

CREATE TABLE IF NOT EXISTS utilisateur (
    id_utilisateur INT UNSIGNED  NOT NULL AUTO_INCREMENT,
    nom            VARCHAR(80)   NOT NULL,
    prenom         VARCHAR(80)   NOT NULL,
    email          VARCHAR(180)  NOT NULL,
    telephone      VARCHAR(20)   NULL,
    gouvernorat    VARCHAR(60)   NULL,
    mot_de_passe   VARCHAR(255)  NOT NULL,
    role           ENUM('citoyen','admin','steg','sonede','professionnel','fournisseur','benevole','proprietaire')
                                 NOT NULL DEFAULT 'citoyen',
    date_creation  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_utilisateur),
    UNIQUE KEY uq_utilisateur_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
