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

INSERT IGNORE INTO Framework 
(   step,   sequence,       pool,           method,         param,      code, level, cle )
VALUES
(   '1',    'init',         'framework',    'initCMS',      '',        'start framework', '0', 'framework'),
(   '10',   'controller',   'framework',    'traiterForm',  '',        'start framework', '0', 'framework'),
(   '20',   'option',       '',             '',             'test',    'hello', '0', 'framework'),
(   '50',   'plugin',       'test',         'toto',         '',        'start framework', '0', 'framework'),
(   '100',  'view',         'framework',    'afficherPage', '',        'start framework', '0', 'framework'),
(   '1000', 'end',          'framework',    'endCMS',       '',        'end framework', '0', 'framework')
;
