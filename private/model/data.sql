USE `cmsFun`;


DELETE FROM Page;

INSERT IGNORE INTO Page 
( urlPage, titre, contenu, template, level, dataType )
VALUES
/* PAGES */
('index', 'accueil', 'contenu de la page accueil', 'index', '0', 'page'),
('galerie', 'galerie', 'contenu de la page galerie', 'galerie', '0', 'page'),
('contact', 'contact', 'contenu de la page contact', 'contact', '0', 'page'),
('annonce', 'espace-membre', 'contenu de la page espace-membre', 'annonce', '0', 'page'),
('mentions-legales', 'mentions-legales', 'contenu de la page mentions-legales', 'defaut', '0', 'page'),
('credits', 'credits', 'contenu de la page credits', 'defaut', '0', 'page'),
/* AJAX */
('ajax', 'ajax', 'contenu de la page ajax', 'ajax', '0', 'page'),
/* ADMIN */
('inscription', 'inscription', 'contenu de la page inscription', 'inscription', '0', 'page'),
('login', 'login', 'contenu de la page login', 'login', '0', 'page'),
('logout', 'logout', 'contenu de la page logout', 'logout', '1', 'page'),
('espace-membre', 'espace-membre', 'contenu de la page espace-membre', 'espace-membre', '1', 'page'),
('admin', 'admin', 'contenu de la page admin', 'admin', '8', 'page'),
('admin-user', 'admin-user', 'contenu de la page admin-user', 'admin-user', '8', 'page'),
('admin-annonce', 'admin-annonce', 'contenu de la page admin-annonce', 'admin-annonce', '8', 'page'),
('admin-newsletter', 'admin-newsletter', 'contenu de la page admin-newsletter', 'admin-newsletter', '8', 'page'),
('admin-user', 'admin-user', 'contenu de la page admin-user', 'admin-user', '8', 'page')
;

INSERT IGNORE INTO Page 
( urlPage, titre, template, priority, category, dataType )
VALUES
/* NAV */
(null, 'Galerie', 'galerie.html', '2', 'principal', 'nav'),
(null, 'Contact', 'contact.html', '3', 'principal', 'nav'),
(null, 'Inscription', 'inscription.html', '4', 'principal', 'nav'),
(null, 'Espace Membre', 'espace-membre.html', '5', 'principal', 'nav'),
/* NAV MEMBRE */
(null, 'Contact', 'contact.html', '2', 'membre', 'nav'),
(null, 'Espace Membre', 'espace-membre.html', '3', 'membre', 'nav'),
(null, 'Logout', 'logout.html', '4', 'membre', 'nav'),
/* NAV ADMIN */
(null, 'Espace Membre', 'espace-membre.html', '2', 'admin', 'nav'),
(null, 'Admin', 'admin.html', '3', 'admin', 'nav'),
(null, 'Admin Annonce', 'admin-annonce.html', '4', 'admin', 'nav'),
(null, 'Admin Newsletter', 'admin-newsletter.html', '5', 'admin', 'nav'),
(null, 'Admin User', 'admin-user.html', '6', 'admin', 'nav'),
(null, 'Logout', 'logout.html', '5', 'admin', 'nav'),
/* NAV FOOTER */
(null, 'mentions légales', 'mentions-legales.html', '1', 'footer', 'nav'),
(null, 'crédits', 'credits.html', '2', 'footer', 'nav'),
(null, 'admin', 'admin.html', '3', 'footer', 'nav')
;

DELETE FROM Framework;

INSERT IGNORE INTO Framework 
(   step,   sequence,         pool,           method,         param,        code, level, cle )
VALUES
(   '1000',   'init',         'framework',    'initCMS',      '',           'start framework', '0', ''),
(   '2000',   'option',       '',             '',             'cms.theme',  'base', '0', 'framework'),
(   '2010',   'option',       '',             '',             'cms.login',  'login.html', '0', 'framework'),
(   '2100',   'option',       '',             '',             'page.logo',  'assets/img/180x60-logo.jpg', '0', 'framework'),
(   '2100',   'option',       '',             '',             'test',       'hello', '0', 'framework'),
(   '3000',   'theme',        'base',         'index',        '',           'load theme', '0', ''),
(   '4000',   'plugin',       'test',         'toto',         '',           'load plugin', '0', ''),
(   '5000',   'controller',   'framework',    'traiterForm',  '',           'controller: process form', '0', ''),
(   '6000',   'view',         'framework',    'afficherPage', '',           'view: build response', '0', ''),
(   '9000',   'end',          'framework',    'endCMS',       '',           'end framework', '0', '')
;
