DROP DATABASE IF EXISTS sitekenan;
CREATE DATABASE IF NOT EXISTS sitekenan;

USE sitekenan;

CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL
);

CREATE TABLE site_content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    section VARCHAR(50) NOT NULL,
    content TEXT NOT NULL
);

INSERT INTO site_content (section, content) VALUES ('main_text', "Pendant mon stage à l'ESIEA, j'ai créé un site web avec HTML, CSS et JavaScript. J'ai utilisé HTML pour structurer le site,
                CSS pour la personnalisation et pour le rendre plus responsive, puis JavaScript pour ajouter des fonctionnalités interactives.
                Ce stage m'a permis de comprendre la construction d'un site web et son fonctionnement.
                Grâce à cela, j'ai pu créer un site web sympa et compact."'),
                ('propos', "test");

INSERT INTO utilisateurs (username, password, email)
VALUES ('kenan', '$2y$10$RuGJUfGRGPR4xN4gYDZK3uDsbmQDRwAkLqNYI.WW/qC6Bn3dz1i7O', 'kenan@example.com');