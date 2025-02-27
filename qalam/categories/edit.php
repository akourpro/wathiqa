<?php
$id = numer($_GET['id']);
dbSelect("stories", "photo, message", "WHERE id = ? LIMIT 1", [$id]);
if ($countrows != 1) {
    sweet("error", "خطأ", "القصة غير موجودة", "stories");
    die();
}


if (isset($_POST['submit'])) {
    $csrf->verify();
    $update_message = safer($_POST['message']);

    if (!empty($update_message)) {

        if (!empty($_FILES['photo']['name'])) {
            unlink("../../me/files/stories/" . $rows[0]['photo']);
            $image_name = genCode("stories", "photo", "id", 16);
            $up = up($image_name, "photo", "../../me/files/stories", 20);
            if ($up == "uploaded_done") {
                $columns = "photo = ?";
                $values = [$filename, $id];
                dbUpdate("stories", $columns, $values, "WHERE id = ?");
            }
        }

        $columns = "message = ?";
        $values = [$update_message, $id];
        dbUpdate("stories", $columns, $values, "WHERE id = ?");
        sweet("success", "نجاح", "تم تعديل القصة بنجاح", "stories");
    } else {
        sweet("error", "خطأ", "الرسالة مطلوبة");
    }
}

?>
<title>تعديل القصة</title>
<h4 class="py-3 mb-4"><span class="text-muted fw-light">قصص النجاح /</span> تعديل القصة</h4>
<div class="card mb-4">
    <h5 class="card-header">تعديل القصة</h5>
    <form class="card-body" method="post" enctype="multipart/form-data" action="stories/<?php echo $id ?>/edit">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                    <input type="text" id="multicol-message" class="form-control" name="message" placeholder="الرسالة" value="<?php echo $rows[0]['message'] ?>" required>
                    <label for="multicol-message">الرسالة</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-photo-toggle">
                    <div class="input-group input-group-merge">
                        <div class="form-floating form-floating-outline">
                            <input type="file" id="multicol-photo" class="form-control" placeholder="صورة الرسالة" name="photo" aria-describedby="multicol-photo">
                            <label for="multicol-photo">صورة الرسالة (اتركه فارغ لعدم التغيير)</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-photo-toggle">
                    <div class="input-group input-group-merge">
                        <div class="form-floating form-floating-outline">
                            <p>الصورة الحالية: </p>
                            <img src="../me/files/stories/<?php echo $rows[0]['photo'] ?>" width="250" />
                            <!-- <label for="multicol-photo">الصورة الحالية</label> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-4">
            <?php $csrf->input(); ?>
            <button type="reset" class="btn btn-outline-secondary waves-effect"><i class="mdi mdi-delete-empty-outline"></i> تفريغ</button>
            <button type="submit" name="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light"><i class="mdi mdi-plus"></i> تعديل</button>
        </div>
    </form>
</div>