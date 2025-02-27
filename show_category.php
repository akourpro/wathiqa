<?php
$slug = safer($_GET['slug']);
require_once 'sidebar.php'; // استيراد sidebar


dbSelect("categories", "*", "WHERE slug = ? AND status != ? LIMIT 1", [$slug, "disable"]);
if ($countrows == 1) {
    $categories = $rows[0];

    dbSelect("articles", "slug, title, photo, description", "WHERE category = ?  AND status != ?", [$categories['id'], "disable"]);
    $articles = $rows;


    echo $twig->render('category.twig', [
        'header_cate' => $header_cate, // استيراد sidebar
        'header_articles' => $header_articles, // استيراد sidebar

        'categories' => $categories,
        'articles' => $articles
    ]);
} else {
    echo $twig->render('404.twig', []);
}
