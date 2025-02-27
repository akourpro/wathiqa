<h4 class="py-3 mb-4"><span class="text-muted fw-light">المقالات /</span> اضافة جديد</h4>

<?php
if (isset($_POST['submit'])) {
    $csrf->verify();

    $title = safer($_POST['title']);
    $description = $_POST['description'];
    $category = $_POST['category'];
    $slug = safer($_POST['slug']);
    $status = safer($_POST['status']);


    if (!empty($title)) {
        if (empty($slug)) {
            $slug = genCode("articles", "slug", "token", 6);
        }
        dbSelect("articles", "slug", "WHERE slug = ? LIMIT 1", [$slug]);
        if ($countrows == 0) {
            $columns = "title, description, slug, category, status, date";
            $values = [$title, $description, $slug, $category, $status, date("Y-m-d H:i:s")];
            $id = dbInsert("articles", $columns, $values);

            if ($_FILES['photo']['name']) {
                $image_name = genCode("articles", "photo", "id", 16);
                $up = up($image_name, "photo", "../../files/articles", 20);
                if ($up == "uploaded_done") {
                    dbUpdate("articles", "photo = ?", [$filename, $id], "WHERE id = ? LIMIT 1");
                }
            }
            sweet("success", "نجاح", "تم نشر المقالة بنجاح", "articles");
        } else {
            sweet("error", "خطأ", "عنوان الرابط (slug) موجود بالفعل !");
        }
    } else {
        sweet("error", "خطأ", "عنوان المقال مطلوب");
    }
}
?>
<title>اضافة مقال جديد</title>
<script src="../js/summernote-lite.min.js"></script>
<link href="../css/summernote-lite.min.css" rel="stylesheet">

<div class="card mb-4">
    <h5 class="card-header">نشر مقال جديد</h5>
    <form class="card-body" method="post" enctype="multipart/form-data">
        <div class="row g-4">

            <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" name="title" placeholder="عنوان المقال" value="<?php echo $title ?? '' ?>" required>
                    <label>عنوان المقال</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" name="slug" id="slug" placeholder="رابط المقال slug" value="<?php echo $slug ?? '' ?>">
                    <label>رابط المقال (Slug)</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                    <select class="form-control" name="category">
                        <?php
                        dbSelect("categories", "id, title");
                        if ($countrows >= 1) {
                            foreach ($rows as $row) {
                                if (isset($_POST['category']) and $_POST['category'] == $row['id']) {
                                    echo '<option value="' . $row['id'] . '" selected>' . $row['title'] . '</option>';
                                } else {
                                    echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                }
                            }
                        }
                        ?>
                    </select>
                    <label>الفئة</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                    <select class="form-control" name="status">
                        <option value="enable" selected>ظاهر</option>
                        <option value="disable">مخفي</option>
                    </select>
                    <label>الحالة</label>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-floating form-floating-outline">
                    <textarea class="form-control contents" name="description"><?php echo $description ?? '' ?></textarea>
                    <label>المقال</label>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                    <input type="file" class="form-control" name="photo">
                    <label>صورة المقال <sup>(اختياري - مساعد للسيو)</sup></label>
                </div>
            </div>
        </div>
        <div class="pt-4">
            <?php $csrf->input(); ?>
            <button type="reset" class="btn btn-outline-secondary waves-effect"><i class="mdi mdi-delete-empty-outline"></i> تفريغ</button>
            <button type="submit" name="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light"><i class="mdi mdi-plus"></i> إضافة</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        // استهداف حقل الإدخال
        var inputField = $("#slug");

        // استبدال المسافات بعلامات _ عند كتابة المستخدم
        inputField.on("input", function() {
            var text = $(this).val();
            // استبدال جميع المسافات بعلامات _
            var replacedText = text.replace(/\s/g, "-");
            // تحديث قيمة حقل الإدخال
            $(this).val(replacedText);
        });
    });
</script>
<script src="js/editor.js"></script>