<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
        '/' => [[['_route' => 'accueil', '_controller' => 'App\\Controller\\AccueilController::index'], null, null, null, false, false, null]],
        '/se-connecter' => [[['_route' => 'login', '_controller' => 'App\\Controller\\AuthentificationController::login'], null, null, null, false, false, null]],
        '/enregistrer' => [[['_route' => 'register', '_controller' => 'App\\Controller\\AuthentificationController::register'], null, null, null, false, false, null]],
        '/se-deconnecter' => [[['_route' => 'logout', '_controller' => 'App\\Controller\\AuthentificationController::logout'], null, null, null, false, false, null]],
        '/mon-profil' => [
            [['_route' => 'account', '_controller' => 'App\\Controller\\AuthentificationController::account'], null, ['GET' => 0, 'POST' => 1], null, false, false, null],
            [['_route' => 'delete', '_controller' => 'App\\Controller\\AuthentificationController::delete'], null, ['DELETE' => 0], null, false, false, null],
        ],
        '/boutique' => [[['_route' => 'boutique.index', '_controller' => 'App\\Controller\\BoutiqueController::index'], null, null, null, false, false, null]],
        '/boutique/create' => [[['_route' => 'boutique.new', '_controller' => 'App\\Controller\\BoutiqueController::new'], null, null, null, false, false, null]],
        '/boutique/categories' => [[['_route' => 'categories', '_controller' => 'App\\Controller\\BoutiqueController::categories'], null, null, null, false, false, null]],
        '/panier' => [[['_route' => 'panier', '_controller' => 'App\\Controller\\CartController::index'], null, null, null, false, false, null]],
        '/panier/validate' => [[['_route' => 'cart_validate', '_controller' => 'App\\Controller\\CartController::validate'], null, null, null, false, false, null]],
        '/forum' => [[['_route' => 'forum.index', '_controller' => 'App\\Controller\\ForumController::index'], null, null, null, false, false, null]],
        '/forum/create' => [[['_route' => 'forum.new', '_controller' => 'App\\Controller\\ForumController::new'], null, null, null, false, false, null]],
        '/information' => [[['_route' => 'information', '_controller' => 'App\\Controller\\InformationController::index'], null, null, null, false, false, null]],
        '/conditions-generales-d-achat' => [[['_route' => 'cga', '_controller' => 'App\\Controller\\LegalController::cga'], null, null, null, false, false, null]],
        '/conditions-generales-de-vente' => [[['_route' => 'cgv', '_controller' => 'App\\Controller\\LegalController::cgv'], null, null, null, false, false, null]],
        '/conditions-generales-d-utilisation' => [[['_route' => 'cgu', '_controller' => 'App\\Controller\\LegalController::cgu'], null, null, null, false, false, null]],
        '/stat' => [[['_route' => 'stat', '_controller' => 'App\\Controller\\StatController::index'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:38)'
                    .'|wdt/([^/]++)(*:57)'
                    .'|profiler/([^/]++)(?'
                        .'|/(?'
                            .'|search/results(*:102)'
                            .'|router(*:116)'
                            .'|exception(?'
                                .'|(*:136)'
                                .'|\\.css(*:149)'
                            .')'
                        .')'
                        .'|(*:159)'
                    .')'
                .')'
                .'|/boutique/(?'
                    .'|deleteProduct/([^/]++)(*:204)'
                    .'|([a-z0-9\\-]*)\\-([^/]++)(*:235)'
                    .'|edit/([^/]++)(*:256)'
                .')'
                .'|/panier/(?'
                    .'|add/([^/]++)(*:288)'
                    .'|remove/([^/]++)(*:311)'
                .')'
                .'|/forum/(?'
                    .'|([a-z0-9\\-]*)\\-([^/]++)(*:353)'
                    .'|delete(?'
                        .'|Subject\\-([^/]++)(*:387)'
                        .'|Comment\\-([^/]++)(*:412)'
                    .')'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        38 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        57 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        102 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        116 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        136 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        149 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        159 => [[['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null]],
        204 => [[['_route' => 'boutique.delete', '_controller' => 'App\\Controller\\BoutiqueController::delete'], ['id'], null, null, false, true, null]],
        235 => [[['_route' => 'boutique.show', '_controller' => 'App\\Controller\\BoutiqueController::show'], ['slug', 'id'], null, null, false, true, null]],
        256 => [[['_route' => 'boutique.edit', '_controller' => 'App\\Controller\\BoutiqueController::edit'], ['id'], null, null, false, true, null]],
        288 => [[['_route' => 'cart_add', '_controller' => 'App\\Controller\\CartController::add'], ['id'], null, null, false, true, null]],
        311 => [[['_route' => 'cart_remove', '_controller' => 'App\\Controller\\CartController::remove'], ['id'], null, null, false, true, null]],
        353 => [[['_route' => 'forum.show', '_controller' => 'App\\Controller\\ForumController::show'], ['slug', 'id'], null, null, false, true, null]],
        387 => [[['_route' => 'forum.deleteSubject', '_controller' => 'App\\Controller\\ForumController::deleteSubject'], ['id'], ['DELETE' => 0], null, false, true, null]],
        412 => [
            [['_route' => 'forum.deleteComment', '_controller' => 'App\\Controller\\ForumController::deleteComment'], ['id'], ['DELETE' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
