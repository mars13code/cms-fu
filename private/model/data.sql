USE `cmsFun`;

/* 
DELETE FROM Page;
*/

INSERT IGNORE INTO Page 
( urlPage, titre, contenu, template )
VALUES
('index', 'accueil', 'contenu de la page accueil', 'index'),
('galerie', 'galerie', 'contenu de la page galerie', 'defaut'),
('inscription', 'inscription', 'contenu de la page inscription', 'inscription'),
('login', 'login', 'contenu de la page login', 'login'),
('logout', 'logout', 'contenu de la page logout', 'logout'),
('espace-membre', 'espace-membre', 'contenu de la page espace-membre', 'espace-membre'),
('admin', 'admin-user', 'contenu de la page admin-user', 'admin-user'),
('admin-newsletter', 'admin-newsletter', 'contenu de la page admin-newsletter', 'admin-newsletter'),
('annonce', 'espace-membre', 'contenu de la page espace-membre', 'annonce'),
('mentions-legales', 'mentions-legales', 'contenu de la page mentions-legales', 'defaut'),
('credits', 'credits', 'contenu de la page credits', 'defaut')
;

