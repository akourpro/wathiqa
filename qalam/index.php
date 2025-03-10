<title>الرئيسية</title>
<div class="row gy-4 mb-4">
    <div class="col-lg-12">
        <div class="card h-100">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="mb-2">احصائيات الموقع</h4>
                </div>
            </div>
            <div class="card-body d-flex justify-content-between flex-wrap gap-3">
                <div class="d-flex gap-3">
                    <div class="avatar">
                        <div class="avatar-initial bg-label-primary rounded">
                            <i class="mdi mdi-account-outline mdi-24px"></i>
                        </div>
                    </div>
                    <div class="card-info">
                        <h4 class="mb-0"><?php dbSelect("categories", "id");
                                            if ($countrows >= 1) echo $countrows; ?></h4>
                        <small>مجموع التصنيفات</small>
                    </div>
                </div>
                <div class="d-flex gap-3">
                    <div class="avatar">
                        <div class="avatar-initial bg-label-warning rounded">
                            <i class="mdi mdi-poll mdi-24px"></i>
                        </div>
                    </div>
                    <div class="card-info">
                        <h4 class="mb-0"><?php dbSelect("articles", "id");
                                            if ($countrows >= 1) echo $countrows; ?></h4>
                        <small>مجموع الشروحات</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <?php
        $updateUrl = 'https://raw.githubusercontent.com/akourpro/wathiqa/main/version.json';
        $updateData = file_get_contents($updateUrl);
        $update = json_decode($updateData, true);

        $currentVersion = '1.2';

        if ($update && version_compare($update['version'], $currentVersion, '>')):
            if (isset($_POST['update'])) {
                $zipPath = safer($_SERVER['DOCUMENT_ROOT']) . '/update.zip';
                $extractPath = safer($_SERVER['DOCUMENT_ROOT']);
                $sqlFilePath = safer($_SERVER['DOCUMENT_ROOT']) . '/update.sql';

                if (downloadUpdate($update['download_url'], $zipPath)) {
                    if (applyUpdate($zipPath, $extractPath, ['includes/config.php', '.htaccess', 'images/banner.jpg', 'images/logo.png'])) {
                        sweet("success", "نجاح", "تم التحديث بنجاح إلى الإصدار " . $update['version'], "here");

                        if (!empty($update['sql_file']) && file_exists($sqlFilePath)) {
                            echo runDatabaseUpdate($sqlFilePath);
                        }
                    } else {
                        sweet("error", "خطأ", "فشل في فك ضغط ملف التحديث", "here");
                    }
                    unlink($zipPath);
                    unlink($sqlFilePath);
                } else {
                    sweet("error", "خطأ", "فشل في تحميل التحديث من Github", "here");
                }
            }
        ?>
            <div class="modal fade" id="newUpdate" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
                    <div class="modal-content">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-body p-0">
                            <div class="text-center mb-6">
                                <h4 class="mb-2">تحديث جديد</h4>
                                <p>يوجد تحديث جديد للسكربت</p>
                            </div>
                            <form class="row g-5" method="POST">
                                <div class="col-12">
                                    <div class='alert alert-danger'>
                                        🚀 إصدار جديد متوفر: <b><?php echo $update['version'] ?></b><br>
                                        🔧 التغييرات: <?php echo  $update['changelog'] ?><br>
                                        📥 <a href="<?php echo $update['download_url'] ?>" target="_blank">تحميل التحديث يدويًا</a>
                                    </div>
                                    <br>
                                    <div class="alert alert-info"><b>نصيحة: </b>قم بعمل نسخة احتياطية للملفات وقاعدة البيانات قبل التحديث</div>
                                </div>

                                <div class="col-12 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                                    <button type="submit" name="update" class="btn btn-primary">تحديث السكربت</button>
                                    <button type="reset" class="btn btn-outline-secondary btn-reset" data-bs-dismiss="modal" aria-label="Close">ذكرني لاحقًا</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                $(window).on('load', function() {
                    $('#newUpdate').modal('show');
                });
            </script>
        <?php endif; ?>
    </div>
</div>