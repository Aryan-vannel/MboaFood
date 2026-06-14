-- ================================================================
-- MBOAFOOD — Script SQL complet
-- Base de données : mboa_food
-- ================================================================

CREATE DATABASE IF NOT EXISTS mboa_food
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE mboa_food;

-- ----------------------------------------------------------------
-- TABLE : users
-- ----------------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nom         VARCHAR(100)  NOT NULL,
    email       VARCHAR(150)  NOT NULL UNIQUE,
    password    VARCHAR(255)  NOT NULL,
    telephone   VARCHAR(25)   DEFAULT NULL,
    role        ENUM('client','admin','livreur') NOT NULL DEFAULT 'client',
    actif       TINYINT(1)    NOT NULL DEFAULT 1,
    created_at  DATETIME      DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME      DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ----------------------------------------------------------------
-- TABLE : adresses
-- ----------------------------------------------------------------
CREATE TABLE IF NOT EXISTS adresses (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT           NOT NULL,
    ville       VARCHAR(100)  NOT NULL,
    quartier    VARCHAR(100)  NOT NULL,
    description TEXT          DEFAULT NULL,
    is_default  TINYINT(1)    NOT NULL DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ----------------------------------------------------------------
-- TABLE : categories
-- ----------------------------------------------------------------
CREATE TABLE IF NOT EXISTS categories (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nom         VARCHAR(100)  NOT NULL,
    description TEXT          DEFAULT NULL,
    image       VARCHAR(255)  DEFAULT NULL
) ENGINE=InnoDB;

-- ----------------------------------------------------------------
-- TABLE : plats
-- ----------------------------------------------------------------
CREATE TABLE IF NOT EXISTS plats (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    categorie_id INT           DEFAULT NULL,
    nom          VARCHAR(150)  NOT NULL,
    description  TEXT          DEFAULT NULL,
    prix         INT           NOT NULL,
    image        VARCHAR(255)  DEFAULT NULL,
    disponible   TINYINT(1)    NOT NULL DEFAULT 1,
    created_at   DATETIME      DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categorie_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ----------------------------------------------------------------
-- TABLE : commandes
-- ----------------------------------------------------------------
CREATE TABLE IF NOT EXISTS commandes (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT           NOT NULL,
    adresse_id  INT           DEFAULT NULL,
    statut      ENUM('en_attente','acceptee','en_preparation','prete','en_livraison','livree','annulee')
                              NOT NULL DEFAULT 'en_attente',
    total       INT           NOT NULL DEFAULT 0,
    note        TEXT          DEFAULT NULL,
    created_at  DATETIME      DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME      DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id)    REFERENCES users(id),
    FOREIGN KEY (adresse_id) REFERENCES adresses(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ----------------------------------------------------------------
-- TABLE : details_commande
-- ----------------------------------------------------------------
CREATE TABLE IF NOT EXISTS details_commande (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    commande_id   INT  NOT NULL,
    plat_id       INT  NOT NULL,
    quantite      INT  NOT NULL DEFAULT 1,
    prix_unitaire INT  NOT NULL,
    FOREIGN KEY (commande_id) REFERENCES commandes(id) ON DELETE CASCADE,
    FOREIGN KEY (plat_id)     REFERENCES plats(id)
) ENGINE=InnoDB;

-- ----------------------------------------------------------------
-- TABLE : livraisons
-- ----------------------------------------------------------------
CREATE TABLE IF NOT EXISTS livraisons (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    commande_id    INT  NOT NULL,
    livreur_id     INT  DEFAULT NULL,
    statut         ENUM('assignee','en_cours','livree','echec') NOT NULL DEFAULT 'assignee',
    tentatives     INT  NOT NULL DEFAULT 0,
    date_livraison DATETIME  DEFAULT NULL,
    created_at     DATETIME  DEFAULT CURRENT_TIMESTAMP,
    updated_at     DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (commande_id) REFERENCES commandes(id),
    FOREIGN KEY (livreur_id)  REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ----------------------------------------------------------------
-- TABLE : factures
-- ----------------------------------------------------------------
CREATE TABLE IF NOT EXISTS factures (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    commande_id  INT           NOT NULL UNIQUE,
    numero       VARCHAR(60)   NOT NULL UNIQUE,
    montant_ht   INT           NOT NULL,
    tva          INT           NOT NULL DEFAULT 0,
    montant_ttc  INT           NOT NULL,
    date_facture DATETIME      DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (commande_id) REFERENCES commandes(id)
) ENGINE=InnoDB;

-- ================================================================
-- DONNÉES DE DÉMONSTRATION
-- Mot de passe pour tous : "password"
-- Hash bcrypt de "password" compatible PHP password_hash()
-- ================================================================

INSERT INTO users (nom, email, password, telephone, role) VALUES
('Admin MboaFood',  'admin@mboafood.cm',   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+237 677 000 001', 'admin'),
('Jean Dupont',     'client@mboafood.cm',  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+237 677 000 002', 'client'),
('Paul Mvondo',     'livreur@mboafood.cm', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+237 677 000 003', 'livreur'),
('Marie Nkono',     'marie@mboafood.cm',   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+237 677 000 004', 'client');

INSERT INTO adresses (user_id, ville, quartier, description, is_default) VALUES
(2, 'Yaoundé', 'Bastos',    'Rue des ambassades, immeuble vert, entrée principale', 1),
(2, 'Yaoundé', 'Nlongkak',  'Après le carrefour Nlongkak, maison bleue portail blanc', 0),
(4, 'Yaoundé', 'Melen',     'Derrière l''université de Yaoundé I, porte verte n°12', 1);

INSERT INTO categories (nom, description) VALUES
('Plats locaux',      'Spécialités camerounaises traditionnelles'),
('Grillades',         'Viandes et poissons grillés au charbon'),
('Soupes & Bouillons','Soupes chaudes et bouillons nutritifs'),
('Boissons',          'Boissons fraîches et chaudes'),
('Desserts',          'Douceurs et desserts maison');

INSERT INTO plats (categorie_id, nom, description, prix, disponible) VALUES
(1, 'Ndolé au poisson fumé',    'Plat emblématique camerounais : feuilles de ndolé cuisinées avec poisson fumé, crevettes et arachides.',          2500, 1),
(1, 'Eru avec Water Fufu',      'Légumes eru mijotés avec bœuf, crevettes et huile de palme. Servi avec water fufu fait maison.',                    3000, 1),
(1, 'Koki aux crevettes',       'Gâteau de haricots blancs aux crevettes, cuit à la vapeur dans des feuilles de bananier.',                          1500, 1),
(1, 'Okok mitonné',             'Feuilles d''okok broyées et mijotées à l''huile de palme avec poisson fumé et épices traditionnelles.',             2000, 1),
(1, 'Mbongo Tchobi',            'Poulet ou bœuf cuisiné en sauce noire avec des épices traditionnelles camerounaises. Saveur unique.',               2800, 1),
(2, 'Brochettes de bœuf',       'Morceaux de bœuf marinés aux épices locales, grillés au charbon. Servis avec sauce pimentée maison.',               1500, 1),
(2, 'Poulet DG',                'Poulet braisé puis sauté avec plantains et légumes variés. La fierté de la cuisine camerounaise.',                   3500, 1),
(2, 'Poisson braisé entier',    'Poisson entier mariné et grillé lentement au charbon. Accompagné de bâtons de manioc et sauce tomate.',             4000, 1),
(2, 'Soya de porc',             'Morceaux de porc grillés sur braise avec assaisonnement local. Incontournable des rues de Yaoundé.',                 1800, 1),
(3, 'Bouillon de queue bœuf',   'Bouillon riche et savoureux préparé avec queue de bœuf, légumes et épices. Mijoté plusieurs heures.',               2500, 1),
(3, 'Pepper Soup',              'Soupe épicée aux épices camerounaises traditionnelles, viande ou poisson selon disponibilité.',                      2000, 1),
(4, 'Jus de bissap',            'Jus naturel d''hibiscus fraîchement préparé, légèrement sucré. Rafraîchissant et antioxydant.',                     500,  1),
(4, 'Eau minérale 1.5L',        'Bouteille d''eau minérale fraîche.',                                                                                300,  1),
(4, 'Jus de gingembre',         'Jus de gingembre frais légèrement sucré et épicé. Excellent pour la santé.',                                        700,  1),
(4, 'Jus de folèrè',            'Jus naturel de folèrè (oseille de Guinée), saveur acidulée et désaltérante.',                                       600,  1),
(5, 'Beignets au miel',         'Beignets maison croustillants arrosés de miel local d''abeilles sauvages. Chauds et fondants.',                     800,  1),
(5, 'Cake à la banane plantain','Cake moelleux préparé avec bananes plantains caramélisées et épices douces.',                                       1000, 1);
