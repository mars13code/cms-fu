USE `cmsFun`;

/* 
DELETE FROM Page;
*/

INSERT IGNORE INTO Page 
( urlPage, titre, contenu, template )
VALUES
('index', 'accueil', 'contenu de la page accueil', 'index'),
('galerie', 'galerie', 'contenu de la page galerie', 'defaut'),
('contact', 'contact', 'contenu de la page contact', 'contact'),
('ajax', 'ajax', 'contenu de la page ajax', 'ajax'),
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
(   id,     step,   sequence,         pool,           method,         param,      code, level, cle )
VALUES
(   '1',     '10',    'init',         'framework',    'initCMS',      '',        'start framework', '0', 'framework'),
(   '2',     '100',   'option',       '',             '',             'test',    'hello', '0', 'framework'),
(   '3',     '200',   'theme',        'base',         'index',        '',        'start framework', '0', 'framework'),
(   '4',     '300',   'plugin',       'test',         'toto',         '',        'start framework', '0', 'framework'),
(   '5',     '1000',  'controller',   'framework',    'traiterForm',  '',        'start framework', '0', 'framework'),
(   '6',     '2000',  'view',         'framework',    'afficherPage', '',        'start framework', '0', 'framework'),
(   '7',     '10000', 'end',          'framework',    'endCMS',       '',        'end framework', '0', 'framework')
;
