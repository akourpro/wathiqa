<title>حسابي</title>
<?php
dbSelect("admins", "username, email, password", "WHERE id = ?", [1]);
if (isset($_POST['submit'])) {
    $csrf->verify();

    $username = safer($_POST['username']);
    $email = safer($_POST['email']);
    if (!empty($username) or !empty($email)) {

        if (!empty($_POST['password'])) {
            if ($_POST['password'] == $_POST['confirm_password']) {
                $password = password_hash($password, PASSWORD_BCRYPT);
                $columns = "password = ?";
                $values = [$password, 1];
                dbUpdate("admins", $columns, $values, "WHERE id = ?");
            } else {
                sweet("error", "خطأ", "كلمة المرور غير متطابقة", "here");
                die();
            }
        }

        $columns = "username = ?, email = ?";
        $values = [$username, $email, 1];
        dbUpdate("admins", $columns, $values, "WHERE id = ?");

        sweet("success", "نجاح", "تم تحديث بياناتك بنجاح", "here");
        die();
    } else {
        sweet("error", "خطأ", "اسم المستخدم والبريد الالكتروني حقول اجبارية.");
    }
}

?>
<h4 class="py-3 mb-4"><span class="text-muted fw-light">المدير /</span> تحرير الحساب</h4>

<div class="card mb-4">
    <h5 class="card-header">تعديل بيانات العضوية الخاصة بك</h5>
    <form class="card-body" method="post">

        <div class="row g-4">
            <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                    <input type="text" id="multicol-fullname" class="form-control" name="username" value="<?php echo $rows[0]['username']; ?>" placeholder="اسم المستخدم" required>
                    <label for="multicol-fullname">اسم المستخدم</label>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-email-toggle">
                    <div class="input-group input-group-merge">
                        <div class="form-floating form-floating-outline">
                            <input type="email" id="multicol-email" class="form-control" name="email" value="<?php echo $rows[0]['email']; ?>" placeholder="البريد الالكتروني" required>
                            <label for="multicol-email">البريد الالكتروني</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-password-toggle">
                    <div class="input-group input-group-merge">
                        <div class="form-floating form-floating-outline">
                            <input type="password" id="multicol-password" class="form-control" name="password" placeholder="كلمة المرور الجديدة">
                            <label for="multicol-password">كلمة المرور الجديدة</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-password-toggle">
                    <div class="input-group input-group-merge">
                        <div class="form-floating form-floating-outline">
                            <input type="password" id="multicol-password" class="form-control" name="confirm_password" placeholder="تأكيد كلمة المرور الجديدة">
                            <label for="multicol-password">تأكيد كلمة المرور الجديدة</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="alert alert-danger"><b>ملاحظة: </b>اترك كلمة المرور فارغة لعدم تغييرها</div>


        </div>

        <div class="pt-4">
            <?php $csrf->input(); ?>
            <button type="reset" class="btn btn-outline-secondary waves-effect"><i class="mdi mdi-delete-empty-outline"></i> تفريغ</button>
            <button type="submit" name="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light"><i class="mdi mdi-plus"></i> تعديل</button>


        </div>
    </form>
</div>