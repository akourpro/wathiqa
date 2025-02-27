<?php
$slug = safer($_GET['slug']);
require_once 'sidebar.php'; // استيراد sidebar

dbSelect("articles", "*", "WHERE slug = ? AND status != ? LIMIT 1", [$slug, "disable"]);
if ($countrows == 1) {
    $articles = $rows[0];
    $short_description = mb_substr($articles['description'], 0, 125, 'UTF-8');

    dbSelect("categories", "slug, title", "WHERE id = ? LIMIT 1", [$articles['category']]);
    $categories = $rows[0];

    dbSelect("articles", "*", "WHERE category = ? AND id != ? AND status != ? LIMIT 1", [$articles['category'], $articles['id'], "disable"]);
    $all_articles = $rows;

    $view = intval($articles['views']) + 1;
    dbUpdate("articles", "views = ?", [$view, $slug], "WHERE slug = ? LIMIT 1");

    echo $twig->render('article.twig', [
        'header_cate' => $header_cate, // استيراد sidebar
        'header_articles' => $header_articles, // استيراد sidebar

        'categories' => $categories,
        'articles' => $articles,
        'all_articles' => $all_articles,
        'short_description' => $short_description
    ]);
} else {
    echo $twig->render('404.twig', []);
}
