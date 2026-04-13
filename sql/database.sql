CREATE DATABASE IF NOT EXISTS nebula_db;
USE nebula_db;

SET FOREIGN_KEY_CHECKS = 0; -- désactive la vérification des clés étrangères (utile pour créer / vider des tables liées)

-- ============================================================
-- STRUCTURE
-- ============================================================

-- Comptes utilisateurs
DROP TABLE IF EXISTS utilisateur;
CREATE TABLE utilisateur (
  id_user    INT NOT NULL AUTO_INCREMENT,
  email      VARCHAR(100) NOT NULL,
  password   VARCHAR(255) NOT NULL,
  nom        VARCHAR(50)  NOT NULL,
  role       VARCHAR(20)  DEFAULT 'client',
  created_at TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_user),
  UNIQUE KEY (email)
); 

-- --------------------------------------------------------

-- Offres d'abonnement (Starter / Gamer / Ultra)
DROP TABLE IF EXISTS offre;
CREATE TABLE offre (
  id_offre     INT NOT NULL AUTO_INCREMENT,
  nom_offre    VARCHAR(50)    NOT NULL,
  prix_mensuel DECIMAL(10,2)  NOT NULL DEFAULT 0,
  description  TEXT,
  PRIMARY KEY (id_offre),
  UNIQUE KEY (nom_offre)
);

-- --------------------------------------------------------

-- Catalogue de jeux (peuplé via l'API IGDB au setup)
-- igdb_id permet de faire le lien avec l'API si besoin
DROP TABLE IF EXISTS jeu;
CREATE TABLE jeu (
  id_jeu      INT NOT NULL AUTO_INCREMENT,
  igdb_id     INT             DEFAULT NULL,
  titre       VARCHAR(100)    NOT NULL,
  genre       VARCHAR(150)    DEFAULT NULL,
  developpeur VARCHAR(255)    DEFAULT NULL,
  image_url   VARCHAR(255)    DEFAULT NULL,
  hero_url    VARCHAR(255)    DEFAULT NULL,
  screenshots TEXT            DEFAULT NULL,  -- JSON array d'URLs
  trailer_id  VARCHAR(50)     DEFAULT NULL,  -- YouTube video_id
  rating      DECIMAL(5,2)    DEFAULT NULL,
  date_sortie DATE            DEFAULT NULL,
  description TEXT,
  PRIMARY KEY (id_jeu),
  UNIQUE KEY (igdb_id)
);

-- --------------------------------------------------------

-- Catégories de la boutique
DROP TABLE IF EXISTS categorie;
CREATE TABLE categorie (
  id_cat  INT NOT NULL AUTO_INCREMENT,
  libelle VARCHAR(50) NOT NULL,
  PRIMARY KEY (id_cat)
);

-- --------------------------------------------------------

-- Produits de la boutique physique (vêtements, accessoires...)
DROP TABLE IF EXISTS produit;
CREATE TABLE produit (
  id_produit    INT NOT NULL AUTO_INCREMENT,
  nom_produit   VARCHAR(100)   NOT NULL,
  description   TEXT,
  prix_unitaire DECIMAL(10,2)  NOT NULL,
  image_url     VARCHAR(255)   DEFAULT NULL,
  id_cat        INT            NOT NULL,
  PRIMARY KEY (id_produit),
  FOREIGN KEY (id_cat) REFERENCES categorie(id_cat)
);

-- --------------------------------------------------------

-- Panier (login obligatoire)
-- type = 'offre' ou 'produit'
-- id_ref = id dans la table correspondante (id_offre ou id_produit)
-- nom + prix sauvegardés au moment de l'ajout (snapshot)
DROP TABLE IF EXISTS panier;
CREATE TABLE panier (
  id_panier  INT NOT NULL AUTO_INCREMENT,
  id_user    INT           NOT NULL,
  type       VARCHAR(10)   NOT NULL,          -- 'offre' ou 'produit'
  id_ref     INT           NOT NULL,          -- id dans offre ou produit
  nom        VARCHAR(150)  NOT NULL,          -- snapshot du nom
  prix       DECIMAL(10,2) NOT NULL,          -- snapshot du prix
  quantite   INT           NOT NULL DEFAULT 1,
  date_ajout TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_panier),
  UNIQUE KEY unique_item (id_user, type, id_ref),
  FOREIGN KEY (id_user) REFERENCES utilisateur(id_user) ON DELETE CASCADE
);

-- --------------------------------------------------------

-- Messages du formulaire de contact
-- email_contact pour les visiteurs non connectés
DROP TABLE IF EXISTS message;
CREATE TABLE message (
  id_msg        INT NOT NULL AUTO_INCREMENT,
  sujet         VARCHAR(100) NOT NULL,
  contenu       TEXT         NOT NULL,
  email_contact VARCHAR(100) DEFAULT NULL,
  date_envoi    TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
  id_user       INT          DEFAULT NULL,
  PRIMARY KEY (id_msg),
  FOREIGN KEY (id_user) REFERENCES utilisateur(id_user) ON DELETE SET NULL
);

-- ============================================================
-- DONNÉES INITIALES
-- ============================================================

-- Offres d'abonnement
INSERT INTO offre (nom_offre, prix_mensuel, description) VALUES
('Starter', 0.00,  'Pour découvrir Nebula — 10h/mois, HD 720p, +25 jeux'),
('Gamer',   24.99, 'Le choix des passionnés — Illimité, 4K 144FPS, +200 jeux'),
('Ultra',   44.99, 'L''expérience ultime — Support 24/7, multi-appareils');

-- Catégories boutique
INSERT INTO categorie (libelle) VALUES
('Vêtement'),
('Accessoire');

-- Produits boutique
INSERT INTO produit (nom_produit, description, prix_unitaire, image_url, id_cat) VALUES
('T-Shirt Nebula',   '100% coton · Noir · Logo violet',                29.99, '/NEBULA/public/assets/img/merch-tshirt.png',    1),
('Hoodie Nebula',    'Coton doux · Poche kangourou · Unisexe',         49.99, '/NEBULA/public/assets/img/merch-hoodie.png',    1),
('Casquette Nebula', 'Snapback · Brodé · Réglable',                    24.99, '/NEBULA/public/assets/img/merch-casquette.png', 1),
('Mug Gaming',       'Céramique · 350ml · Thermosensible',             14.99, '/NEBULA/public/assets/img/merch-mug.png',       2),
('Mousepad XXL',     '900x400mm · Surface lisse · Base antidérapante', 19.99, '/NEBULA/public/assets/img/merch-mousepad.png',  2),
('Pack Stickers',    '15 stickers · Vinyle waterproof · Mix designs',   9.99, '/NEBULA/public/assets/img/merch-stickers.png',  2);

SET FOREIGN_KEY_CHECKS = 1; -- Réactive la vérification et l’application des clés étrangères