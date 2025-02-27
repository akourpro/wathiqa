<title>الإعدادات</title>
<h4 class="py-3 mb-4"><span class="text-muted fw-light">الاعدادات /</span> إعدادات الموقع</h4>

<?php
if (isset($_POST['submit'])) {
    $csrf->verify();

    if (!empty(safer($_POST['name'])) or !empty(safer($_POST['description'])) or !empty(safer($_POST['site_metaTags']))) {

        if (!empty($_FILES['logo']['name'])) { // التحقق من وجود صورة جديدة
            unlink("../../files/images/" . $site['logo']);
            $logoName = "logo";
            $up = up($logoName, "logo", "../../files/images", 20);
            if ($up == "uploaded_done") {
                $columns = "value = ?";
                $values = [$filename, "logo"];
                dbUpdate("settings", $columns, $values, "WHERE name = ?");
            }
        }
        if (!empty($_FILES['banner']['name'])) { // التحقق من وجود صورة جديدة
            unlink("../../files/images/banner.jpg");
            $up = up("banner.jpg", "banner", "../../files/images", 20);
        }
        // Update query
        $settingsData = [
            'name' => safer($_POST['name']),
            'site_mail' => safer($_POST['site_mail']),
            'description' => safer($_POST['description']),
            'site_phone' => safer($_POST['site_phone']),
            'site_metaTags' => safer($_POST['site_metaTags']),
            'lang' => safer($_POST['lang']),
            'h_status' => safer($_POST['h_status']),
            'h_button' => safer($_POST['h_button']),
            'h_href' => safer($_POST['h_href']),
            'h_target' => safer($_POST['h_target']),
            'b_status' => safer($_POST['b_status']),
            'b_button' => safer($_POST['b_button']),
            'b_href' => safer($_POST['b_href']),
            'b_target' => safer($_POST['b_target']),
            'facebook' => safer($_POST['facebook']),
            'twitter' => safer($_POST['twitter']),
            'instagram' => safer($_POST['instagram']),
            'github' => safer($_POST['github']),
            'smtp_host' => safer($_POST['smtp_host']),
            'smtp_user' => safer($_POST['smtp_user']),
            'smtp_pass' => safer($_POST['smtp_pass'])
        ];

        // حلقة لتحديث البيانات
        foreach ($settingsData as $name => $value) {
            $columns = "value = ?";
            $vars = [$value];
            $where = "WHERE name = ?";
            dbUpdate("settings", $columns, array_merge($vars, [$name]), $where);
        }
        sweet("success", "نجاح", "تم تحديث اعدادات الموقع بنجاح", "settings");
    } else {
        sweet("error", "خطأ", "اسم الموقع و وصف الموقع و الكلمات المفتاحية هي حقول اجبارية");
    }
}
?>
<div class="card mb-4">
    <h5 class="card-header">ضبط اعدادات الموقع الأساسية</h5>
    <form class="card-body" method="post" enctype="multipart/form-data">
        <h6>1. الاعدادات الأساسية</h6>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" name="name" value="<?php echo $site['name']; ?>" placeholder="اسم الموقع" required>
                    <label>اسم الموقع</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating form-floating-outline">
                    <!-- <input type="text" class="form-control" name="description" value="<?php echo $site['description']; ?>" placeholder="وصف الموقع" aria-label="وصف الموقع" aria-describedby="multicol-email2" required> -->
                    <textarea class="form-control" name="description" placeholder="وصف الموقع" required><?php echo $site['description']; ?></textarea>
                    <label>وصف الموقع</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating form-floating-outline">
                    <!-- <input type="text" class="form-control" name="site_metaTags" value="<?php echo $site['site_metaTags']; ?>" placeholder="الكلمات الدلالية" aria-label="الكلمات الدلالية" aria-describedby="multicol-email2"> -->
                    <textarea class="form-control" name="site_metaTags" placeholder="الكلمات الدلالية" required><?php echo $site['site_metaTags']; ?></textarea>
                    <label>الكلمات الدلالية</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating form-floating-outline">
                    <input type="email" class="form-control" name="site_mail" value="<?php echo $site['site_mail']; ?>" placeholder="ايميل الموقع">
                    <label>ايميل الموقع</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" placeholder="جوال الموقع" name="site_phone" value="<?php echo $site['site_phone']; ?>" aria-describedby="multicol-phone">
                    <label>جوال الموقع</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating form-floating-outline">
                    <select class="form-control" name="lang" aria-describedby="multicol-mode">
                        <option value="1" <?php if ($site['lang'] == "ar") echo 'selected'; ?>>العربية</option>
                        <option value="0" <?php if ($site['lang'] == "en") echo 'selected'; ?>>English</option>
                    </select>
                    <label>لغة الموقع</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating form-floating-outline">
                    <select class="form-control" name="dir" aria-describedby="multicol-mode">
                        <option value="rtl" <?php if ($site['dir'] == "rtl") echo 'selected'; ?>>من اليمين لليسار</option>
                        <option value="ltr" <?php if ($site['dir'] == "ltr") echo 'selected'; ?>>من اليسار لليمين</option>
                    </select>
                    <label>اتجاه الموقع</label>
                </div>
            </div>

        </div>
        <hr class="my-4 mx-n4">
        <h6>2. الأزرار</h6>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="form-floating form-floating-outline">
                    <select class="form-control" name="h_status">
                        <option value="active" <?php if ($site['h_status'] == "active") echo "selected" ?>>مفعل</option>
                        <option value="disabled" <?php if ($site['h_status'] == "disabled") echo "selected" ?>>مخفي</option>
                    </select>
                    <label>الزر في الهيدر</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" name="h_button" value="<?php echo $site['h_button']; ?>" placeholder="نص الزر">
                    <label>اسم الزر</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" name="h_href" value="<?php echo $site['h_href']; ?>" placeholder="رابط توجيه الزر">
                    <label>رابط الزر</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating form-floating-outline">
                    <select class="form-control" name="h_target">
                        <option value="blank" <?php if ($site['h_target'] == "blank") echo "selected" ?>>الفتح في صفحة جديدة</option>
                        <option value="here" <?php if ($site['h_target'] == "here") echo "selected" ?>>الفتح في الصفحة الحالية</option>
                    </select>
                    <label>اجرائية الرابط</label>
                </div>
            </div>
            <!-- footer -->
            <div class="col-md-3">
                <div class="form-floating form-floating-outline">
                    <select class="form-control" name="b_status">
                        <option value="active" <?php if ($site['b_status'] == "active") echo "selected" ?>>مفعل</option>
                        <option value="disabled" <?php if ($site['b_status'] == "disabled") echo "selected" ?>>مخفي</option>
                    </select>
                    <label>الزر السفلي</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" name="b_button" value="<?php echo $site['b_button']; ?>" placeholder="نص الزر">
                    <label>اسم الزر</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" name="b_href" value="<?php echo $site['b_href']; ?>" placeholder="رابط توجيه الزر">
                    <label>رابط الزر</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating form-floating-outline">
                    <select class="form-control" name="b_target">
                        <option value="blank" <?php if ($site['b_target'] == "blank") echo "selected" ?>>الفتح في صفحة جديدة</option>
                        <option value="here" <?php if ($site['b_target'] == "here") echo "selected" ?>>الفتح في الصفحة الحالية</option>
                    </select>
                    <label>اجرائية الرابط</label>
                </div>
            </div>
        </div>
        <hr class="my-4 mx-n4">
        <h6>3. مواقع التواصل</h6>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" name="facebook" value="<?php echo $site['facebook']; ?>" placeholder="فيس بوك">
                    <label>فيس بوك</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" name="twitter" value="<?php echo $site['twitter']; ?>" placeholder="تويتر">
                    <label>تويتر</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" name="instagram" value="<?php echo $site['instagram']; ?>" placeholder="انستقرام">
                    <label>انستقرام</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" name="github" value="<?php echo $site['github']; ?>" placeholder="Github">
                    <label>Github</label>
                </div>
            </div>
        </div>

        <hr class="my-4 mx-n4">
        <h6>4. اعدادات الايميل</h6>
        <div class="row">
            <div class="col">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" name="smtp_host" value="<?php echo $site['smtp_host']; ?>" placeholder="المستضيف">
                    <label>المستضيف</label>
                </div>
            </div>
            <div class="col">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" name="smtp_user" value="<?php echo $site['smtp_user']; ?>" placeholder="اليوزر">
                    <label>اليوزر</label>
                </div>
            </div>
            <div class="col">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" name="smtp_pass" value="<?php echo $site['smtp_pass']; ?>" placeholder="كلمة المرور">
                    <label>كلمة المرور</label>
                </div>
            </div>

        </div>

        <hr class="my-4 mx-n4">
        <h6>5. صورة المقالات الافتراضية (مهم من أجل SEO)</h6>
        <div class="row">
            <div class="col">
                <div class="form-floating form-floating-outline">
                    <img src="../files/images/banner.jpg" width="200" />
                </div>
            </div>
            <div class="col">
                <div class="form-floating form-floating-outline">
                    <input type="file" class="form-control" name="banner">
                    <label>الصورة الافتراضية (اتركه فارغ لعدم التغيير)</label>
                </div>
            </div>
        </div>

        <hr class="my-4 mx-n4">
        <h6>6. شعار (لوقو) الموقع</h6>
        <div class="row">
            <div class="col">
                <div class="form-floating form-floating-outline">
                    <img src="../files/images/<?php echo $site['logo'] ?>" width="200" />
                </div>
            </div>

            <div class="col">
                <div class="form-floating form-floating-outline">
                    <input type="file" class="form-control" name="logo">
                    <label>شعار الموقع (اتركه فارغ لعدم التغيير)</label>
                </div>
            </div>
        </div>
        <div class="pt-4">
            <?php $csrf->input(); ?>
            <button type="reset" class="btn btn-outline-secondary waves-effect">الغاء</button>
            <button type="submit" name="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">اعتمد</button>
        </div>
    </form>
</div>