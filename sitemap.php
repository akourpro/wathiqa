<?php
// إعداد الروابط مع تفاصيل إضافية
$urls = [
    [
        'loc' => $site['site_url'],
        'lastmod' => date("Y-m-d"),
        'changefreq' => 'daily',
        'priority' => '1.0',
        'title' => $site['name'] . ' - الصفحة الرئيسية',
        'image' => $site['site_url'] . "files/images/" . $site['logo'],
        'image_title' => $site['name'] . ' - الصفحة الرئيسية'
    ],
];

// بدء بناء ملف sitemap.xml
header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';

dbSelect("articles", "slug, title, photo, date, last_update", "WHERE status != ?", ["disable"]);
if ($countrows >= 1) {
    foreach ($rows as $row) {
        $loc = $site['site_url'] . "article/" . $row['slug'] . "/show";
        if (empty($row['last_update'])) {
            $lastmod = strtotime($row['last_update']);
        } else {
            $lastmod = strtotime($row['date']);
        }

        $lastmod = date("Y-m-d", $lastmod);
        $changefreq = "weekly";
        $priority = "0.8";
        $title = $row['title'];
        if (!empty($row['photo'])) {
            $image = $site['site_url'] . "files/articles/" . $row['photo'];
        } else {
            $image = $site['site_url'] . "files/images/banner.jpg";
        }
        $image_title = $row['title'];

        $urls[] = [
            'loc' => $loc,
            'lastmod' => $lastmod,
            'changefreq' => $changefreq,
            'priority' => $priority,
            'title' => $title,
            'image' => $image,
            'image_title' => $image_title
        ];
    }
}
foreach ($urls as $url) {
    echo '<url>';
    echo '<loc>' . htmlspecialchars($url['loc']) . '</loc>';
    echo '<lastmod>' . $url['lastmod'] . '</lastmod>';
    echo '<changefreq>' . $url['changefreq'] . '</changefreq>';
    echo '<priority>' . $url['priority'] . '</priority>';
    // echo '<title>' . htmlspecialchars($url['title']) . '</title>';

    if (!empty($url['image'])) {
        echo '<image:image>';
        echo '<image:loc>' . htmlspecialchars($url['image']) . '</image:loc>';
        echo '<image:title>' . htmlspecialchars($url['image_title']) . '</image:title>';
        echo '</image:image>';
    }

    echo '</url>';
}

echo '</urlset>';
