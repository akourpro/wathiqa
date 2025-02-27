<h4 class="py-3 mb-4"><span class="text-muted fw-light">قصص النجاح /</span> اضافة جديد</h4>

<?php
if (isset($_POST['submit'])) {
    $csrf->verify();

    $message = safer($_POST['message']);


    if (!empty($message)) {
        $image_name = genCode("stories", "photo", "id", 16);
        $up = up($image_name, "photo", "../../me/files/stories", 20);

        if ($up == "uploaded_done") {

            $columns = "photo, message";
            $values = [$filename, $message];
            dbInsert("stories", $columns, $values);

            sweet("success", "نجاح", "تم نشر القصة بنجاح", "stories");
        }
    } else {
        sweet("error", "خطأ", "الرسالة مطلوبة");
    }
}
?>
<title>اضافة قصة نجاح</title>
<div class="card mb-4">
    <h5 class="card-header">نشر قصة جديدة</h5>
    <form class="card-body" method="post" enctype="multipart/form-data">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                    <input type="text" id="multicol-message" class="form-control" name="message" placeholder="الرسالة" required>
                    <label for="multicol-message">الرسالة</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-photo-toggle">
                    <div class="input-group input-group-merge">
                        <div class="form-floating form-floating-outline">
                            <input type="file" id="multicol-photo" class="form-control" name="photo" required>
                            <label for="multicol-photo">صورة الرسالة</label>
                        </div>
                    </div>
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