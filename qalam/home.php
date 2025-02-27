<h4 class="py-3 mb-4"><span class="text-muted fw-light">المحتويات /</span> الصفحة الرئيسية</h4>

<?php
$description = $site['home_page'];
if (isset($_POST['submit'])) {
    $csrf->verify();

    $description = $_POST['description'];
    dbUpdate("settings", "value = ?", [$description, "home_page"], "WHERE name = ? LIMIT 1");
    sweet("success", "نجاح", "تم تحديث البيانات بنجاح", "home");
}
?>
<title>الصفحة الرئيسية</title>
<script src="../js/summernote-lite.min.js"></script>
<link href="../css/summernote-lite.min.css" rel="stylesheet">

<div class="card mb-4">
    <h5 class="card-header">تعديل الصفحة الرئيسية</h5>
    <form class="card-body" method="post" enctype="multipart/form-data">
        <div class="row g-4">

            <div class="col-md-12">
                <div class="form-floating form-floating-outline">
                    <textarea class="form-control contents" name="description"><?php echo $description ?? '' ?></textarea>
                    <label>المحتوى</label>
                </div>
            </div>

            <div class="pt-4">
                <?php $csrf->input(); ?>
                <button type="submit" name="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light"><i class="mdi mdi-plus"></i> حفظ</button>
            </div>
    </form>
</div>

<script src="js/editor.js"></script>