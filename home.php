<?php

require_once 'sidebar.php';


echo $twig->render('home.twig', [
    'header_cate' => $header_cate, // استيراد sidebar
    'header_articles' => $header_articles, // استيراد sidebar

    'home_page' => html_entity_decode($site['home_page'])

]);
