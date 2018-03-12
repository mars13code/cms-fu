USE `cmsFun`;

/* 
DELETE FROM Page;
*/

INSERT IGNORE INTO Page 
( urlPage, titre, contenu, template, category, dataType )
VALUES
/* PAGES */
('index', 'accueil', 'contenu de la page accueil', 'index', '', 'page'),
('galerie', 'galerie', 'contenu de la page galerie', 'defaut', '', 'page'),
('contact', 'contact', 'contenu de la page contact', 'contact', '', 'page'),
('annonce', 'espace-membre', 'contenu de la page espace-membre', 'annonce', '', 'page'),
('mentions-legales', 'mentions-legales', 'contenu de la page mentions-legales', 'defaut', '', 'page'),
('credits', 'credits', 'contenu de la page credits', 'defaut', '', 'page'),
/* AJAX */
('ajax', 'ajax', 'contenu de la page ajax', 'ajax', '', 'page'),
/* ADMIN */
('inscription', 'inscription', 'contenu de la page inscription', 'inscription', '', 'page'),
('login', 'login', 'contenu de la page login', 'login', '', 'page'),
('logout', 'logout', 'contenu de la page logout', 'logout', '', 'page'),
('espace-membre', 'espace-membre', 'contenu de la page espace-membre', 'espace-membre', '', 'page'),
('admin', 'admin-user', 'contenu de la page admin-user', 'admin-user', '', 'page'),
('admin-newsletter', 'admin-newsletter', 'contenu de la page admin-newsletter', 'admin-newsletter', '', 'page')
;

INSERT IGNORE INTO Page 
( urlPage, titre, template, priority, category, dataType )
VALUES
/* NAV */
(null, 'Accueil', 'index', '1', 'principal', 'nav'),
(null, 'Galerie', 'galerie', '2', 'principal', 'nav'),
(null, 'Contact', 'contact', '3', 'principal', 'nav'),
(null, 'Inscription', 'inscription', '4', 'principal', 'nav'),
(null, 'Espace Membre', 'espace-membre', '5', 'principal', 'nav'),
/* NAV ADMIN */
(null, 'Accueil', 'index', '1', 'membre', 'nav'),
(null, 'Contact', 'contact', '2', 'membre', 'nav'),
(null, 'Espace Membre', 'espace-membre', '3', 'membre', 'nav'),
(null, 'Logout', 'logout', '4', 'membre', 'nav'),
/* NAV ADMIN */
(null, 'Accueil', 'index', '1', 'admin', 'nav'),
(null, 'Espace Membre', 'espace-membre', '2', 'admin', 'nav'),
(null, 'Admin', 'admin', '3', 'admin', 'nav'),
(null, 'Admin Newsletter', 'admin-newsletter', '4', 'admin', 'nav'),
(null, 'Logout', 'logout', '5', 'admin', 'nav')
;

INSERT IGNORE INTO Framework 
(   id,      step,   sequence,         pool,           method,         param,        code, level, cle )
VALUES
(   '1',     '1000',   'init',         'framework',    'initCMS',      '',           'start framework', '0', ''),
(   '2',     '2000',   'option',       '',             '',             'cms.theme',  'base', '0', 'framework'),
(   '3',     '2100',   'option',       '',             '',             'test',       'hello', '0', 'framework'),
(   '4',     '3000',   'theme',        'base',         'index',        '',           'load theme', '0', ''),
(   '5',     '4000',   'plugin',       'test',         'toto',         '',           'load plugin', '0', ''),
(   '6',     '5000',   'controller',   'framework',    'traiterForm',  '',           'controller: process form', '0', ''),
(   '7',     '6000',   'view',         'framework',    'afficherPage', '',           'view: build response', '0', ''),
(   '8',     '9000',   'end',          'framework',    'endCMS',       '',           'end framework', '0', '')
;
