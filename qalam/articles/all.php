<title>المقالات</title>
<h4 class="py-3 mb-4"><span class="text-muted fw-light">المقالات /</span> عرض الكل</h4>

<div class="row">
    <div class="col-sm">
        <a href="articles/new" class="btn btn-secondary waves-effect waves-light"><i class="mdi mdi-plus"></i> أضف جديد</a>

    </div>
</div>
<div class="card mt-2">
    <div class="table-responsive text-nowrap">
        <table class="orders_table table text-right">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>العنوان</th>
                    <th>الفئة</th>
                    <th>الرابط</th>
                    <th>الحالة</th>
                    <th>اجراء</th>
                </tr>
            </thead>
            <tbody>
                <?php
                dbSelect("articles", "id, title, category, slug, status");
                foreach ($rows as $row) {
                    dbSelect("categories", "title, slug", "WHERE id = ? LIMIT 1", [$row['category']]);
                    $category = $rows[0]['title'];
                    switch ($row['status']) {
                        case 'enable':
                            $status = 'ظاهر';
                            break;
                        default:
                            $status = 'مخفي';
                    }
                    echo '
                    <tr>
                        <td>' . $row['id'] . '</td>
                        <td>' . $row['title'] . '</td>
                        <td>' . $category . '</td>
                        <td>' . $row['slug'] . '</td>
                        <td>' . $status . '</td>
                        <td>
                            <a href="../article/' . $row['slug'] . '/show" target="_blank" class="btn btn-sm btn-primary"><i class="mdi mdi-eye"></i> عرض</a>
                            <a href="articles/' . $row['id'] . '/edit" class="btn btn-sm btn-warning"><i class="mdi mdi-pencil"></i> تعديل</a>
                            <span data-id="' . $row['id'] . '" data-action="delete" data-name="' . $row['title'] . '" class="btn btn-sm btn-danger delete"><i class="mdi mdi-delete"></i> حذف</span>
                        </td>
                    </tr>
                    ';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script src="js/articles.js"></script>