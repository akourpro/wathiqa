<?php

/**
 * AUTO LOAD WITH HEADER
 */

include_once 'includes/config.php';

include_once 'includes/functions.php';


include_once 'includes/csrf.php';
$csrf = new CSRF_Protect('_csrf', "DOCS-auth");
// include twig 
require_once 'includes/libs/twig/vendor/autoload.php';
$loader = new \Twig\Loader\FilesystemLoader(getpath() . 'templates/' . $site['theme']);
$twig = new \Twig\Environment($loader, [
    'debug' => true,
    // 'cache' => 'compilation_cache',
]);

$filter = new \Twig\TwigFilter('unserialize', 'unserialize');
$twig->addFilter($filter);

$twig->addFunction(new \Twig\TwigFunction('nl2br_raw', function ($string) {
    return nl2br($string, false); // إضافة وسوم <br> بدون تحويل HTML
}));


$twig->addExtension(new \Twig\Extension\DebugExtension());
$templatePath = 'templates/' . $site['theme'];

$twig->addGlobal('templatePath', $templatePath);
// $twig->addGlobal('lang', $lang);

$twig->addGlobal('csrftoken', $csrf->header());
$twig->addGlobal('siteUrl', $site["site_url"]);

// $twig->addGlobal('lango', $lango);
$twig->addGlobal('siteName', $site['name']);
$twig->addGlobal('siteDescription', $site['description']);
$twig->addGlobal('siteMetaTags', $site['site_metaTags']);
$twig->addGlobal('logo', $site['logo']);


$twig->addGlobal('facebook', $site['facebook']);
$twig->addGlobal('instagram', $site['instagram']);
$twig->addGlobal('twitter', $site['twitter']);
$twig->addGlobal('github', $site['github']);


$twig->addGlobal('site_mail', $site['site_mail']);
$twig->addGlobal('site_phone', $site['site_phone']);

$twig->addGlobal('h_status', $site['h_status']);
$twig->addGlobal('h_button', $site['h_button']);
$twig->addGlobal('h_href', $site['h_href']);
$twig->addGlobal('h_target', $site['h_target']);
