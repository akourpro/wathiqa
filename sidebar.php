<?php


dbSelect("categories", "id, title, slug, icon", "WHERE status = ?", ["enable"]);
$header_cate = $rows;
dbSelect("articles", "id, title, slug, category", "WHERE status = ?", ["enable"]);
$header_articles = $rows;
