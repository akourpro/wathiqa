<?php
if (login_check_admin()) {
    echo "<meta http-equiv='Refresh' content='0 url=../dashboard'>";
    exit;
}
?>
<!DOCTYPE html>

<html lang="ar" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="rtl" data-theme="theme-default" data-assets-path="../assets/">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <META NAME="ROBOTS" CONTENT="NOARCHIVE">
    <META NAME="GOOGLEBOT" CONTENT="NOARCHIVE">
    <meta name="_csrf" content="<?php echo $csrf->header(); ?>">
    <title>الدخول</title>

    <style>
        @font-face {
            font-family: 'Tajawal';
            src: url('../assets/vendor/fonts/Tajawal.ttf');
        }
    </style>

    <!-- Icons -->
    <link rel="stylesheet" href="../assets/vendor/fonts/materialdesignicons.css" />
    <link rel="stylesheet" href="../assets/vendor/fonts/flag-icons.css" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="../assets/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <!-- <link rel="stylesheet" href="../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" /> -->
    <link rel="stylesheet" href="../assets/vendor/css/rtl/theme-semi-dark.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.css" />

    <!-- Page CSS -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>
    <!-- <script src="../assets/vendor/js/template-customizer.js"></script> -->
    <script src="../assets/js/config.js"></script>
    <script src="../../js/sweetalert2.all.min.js"></script>
    <script src="../../js/functions.js"></script>
</head>

<body>
    <!-- Content -->

    <div class="position-relative">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Login -->
                <div class="card p-2">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mt-5">
                        <a href="../../" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">
                                <img src="../../files/images/<?php echo $site['logo']; ?>" alt="" width="150">
                            </span>
                        </a>
                    </div>
                    <!-- /Logo -->

                    <div class="card-body mt-2">
                        <h4 class="mb-2">مرحبًا بك من جديد 👋</h4>
                        <p class="mb-4">قم بتعبئة البيانات للدخول</p>
                        <?php

                        if (isset($_POST['submit'])) {
                            $csrf->verify();
                            $email = safer($_POST['email']);
                            $password = $_POST['password'];
                            if (!empty($email) and !empty($password)) {
                                // check login
                                $login = login_admin($email, $password);
                                if ($login == "success") {
                                    // Login success 
                                    $sys = safer(getOS()) . " - " . safer(getBrowser());
                                    $date = date("Y-m-d H:i:s");
                                    $ip = safer(getIP());
                                    $user_id = numer($_SESSION['user_id']);
                                    $columns = "user_id, date, ip, sys";
                                    $values = [$user_id, $date, $ip, $sys];
                                    dbInsert("logs", $columns, $values);
                                    echo "<meta http-equiv='Refresh' content='0; url=../dashboard'>";
                                    sweet("success", "نجاح", "تم الدخول بنجاح");
                                    exit;
                                } else {
                                    sweet("error", "خطأ", "البيانات المدخلة غير صحيحة");
                                }
                            } else {
                                sweet("error", "خطأ", "اسم المستخدم وكلمة المرور مطلوبة");
                            }
                        }
                        ?>

                        <form id="formAuthentication" class="mb-3" method="post">
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="text" class="form-control" id="email" name="email" placeholder="أدخل اسم المستخدم او البريد الالكتروني" autofocus required />
                                <label for="email">اسم المستخدم او الايميل</label>
                            </div>
                            <div class="mb-3">
                                <div class="form-password-toggle">
                                    <div class="input-group input-group-merge">
                                        <div class="form-floating form-floating-outline">
                                            <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />
                                            <label for="password">كلمة المرور</label>
                                        </div>
                                        <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <?php $csrf->input(); ?>
                                <button class="btn btn-primary d-grid w-100" type="submit" name="submit">الدخـول</button>
                            </div>
                        </form>


                        <div class="divider my-4">
                            <div class="divider-text"><span class="text-danger"><i class="tf-icons mdi mdi-heart"></i></span></div>
                        </div>

                        <div class="d-flex justify-content-center gap-2">
                            <p>برمجة وتطوير: <a href="#" target="_blank">محمد عكور</a> & <a href="#" target="_blank">بوجليدة عبدالحق</a></p>
                        </div>
                    </div>
                </div>
                <!-- /Login -->
            </div>
        </div>
    </div>



    <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
    </div>
    <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <div class="drag-target"></div>
    </div>

    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/libs/hammer/hammer.js"></script>
    <script src="../assets/vendor/libs/i18n/i18n.js"></script>
    <script src="../assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>


    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.js"></script>
    <script src="../assets/js/pages-auth.js"></script>

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

</body>

</html>