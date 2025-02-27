<?php
$search = safer($_GET['search']);
$search = preg_replace('/[^a-zA-Z0-9أ-ي\s]/u', '', $search);
require_once 'sidebar.php'; // استيراد sidebar


dbSelect("articles", "slug, title, photo, description", "WHERE (title LIKE ? OR description LIKE ?) AND status != ? ", ["%$search%", "%$search%", "disable"]);
if ($countrows >= 1) {
    $results = $rows;
    $alert = '<div class="alert alert-success">تم العثور على <b>' . $countrows . '</b> نتيجة</div>';
    echo $twig->render('search.twig', [
        'header_cate' => $header_cate, // استيراد sidebar
        'header_articles' => $header_articles, // استيراد sidebar
        'results' => $results,
        'word_search' => $search,
        'alert' => $alert
    ]);
} else {
    $countrows = 0;
    $alert = '<div class="alert alert-warning">لم يتم العثور على أي نتيجة</div>';
    echo $twig->render('search.twig', [
        'header_cate' => $header_cate, // استيراد sidebar
        'header_articles' => $header_articles, // استيراد sidebar
        'alert' => $alert
    ]);
}

dbInsert("search", "words, countrows, date", [$search, $countrows, date("Y-m-d H:i:s")]);
