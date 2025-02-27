<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تثبيت سكربت وثيقة</title>
</head>
<style>
    @font-face {
        font-family: 'Tajawal';
        src: url('Tajawal.ttf');
    }

    body {
        font-family: 'Tajawal', 'sans-serif';
        margin: 0;
        padding: 0;
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    form {
        margin: 0 auto;
        width: 400px;
        padding: 20px;
        border: 1px solid #ccc;
    }

    label {
        display: block;
        margin-bottom: 05px;
    }

    input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
    }

    button {
        display: block;
        margin-top: 20px;
        padding: 10px 20px;
        border: none;
        background-color: #007bff;
        color: white;
        cursor: pointer;
    }

    .small {
        color: red;
        margin-bottom: 20px;
    }
</style>

<body>
    <h1>تثبيت سكربت وثيقة</h1>
    <center style="direction: rtl;">
        <?php
        if (isset($_POST["check"])) {

            //post adat
            $hostname = $_POST["hostname"];
            $username = $_POST["username"];
            $password = $_POST["password"];
            $database = $_POST["database"];
            $site_url = $_POST["site_url"];
            $site_folder = $_POST["site_folder"];

            // DB CONFIG

            define("HOST", $hostname);     // The host you want to connect to.
            define("USER", $username);    // The database username. 
            define("PASSWORD", $password);    // The database password. 
            define("DATABASE", $database);    // The database name. 
            define("CHARSET", "utf8mb4");    // The database name. 
            try {
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                    PDO::MYSQL_ATTR_FOUND_ROWS   => true,
                ];

                $con = new PDO("mysql:host=" . HOST . ";dbname=" . DATABASE . ";charset=" . CHARSET, USER, PASSWORD, $options);
            } catch (PDOException $e) {
                die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage() . "<br><b class='small'>تحقق من بيانات الاتصال بقاعدة البيانات</b>");
            }

            // update db config
            // Read the existing config file
            $configContent = file_get_contents("../includes/config.php");
            // Update the values
            $configContent = preg_replace("/define\(\"HOST\", \"(.*?)\"\);/", "define(\"HOST\", \"$hostname\");", $configContent);
            $configContent = preg_replace("/define\(\"USER\", \"(.*?)\"\);/", "define(\"USER\", \"$username\");", $configContent);
            $configContent = preg_replace("/define\(\"PASSWORD\", \"(.*?)\"\);/", "define(\"PASSWORD\", \"$password\");", $configContent);
            $configContent = preg_replace("/define\(\"DATABASE\", \"(.*?)\"\);/", "define(\"DATABASE\", \"$database\");", $configContent);
            // Write the updated config file
            file_put_contents("../includes/config.php", $configContent);
            echo "1 - تم إعداد ملف <b>config.php</b> .. <br>";

            // حقن ملف db.sql في قاعدة البيانات
            $sqlFile = 'db.sql';
            if (file_exists($sqlFile)) {
                $sqlCommands = file_get_contents($sqlFile);

                try {
                    $con->exec($sqlCommands);
                    echo "1.1 - تم استيراد قاعدة البيانات بنجاح <br>";
                } catch (PDOException $e) {
                    echo "1.1 - فشل في استيراد قاعدة البيانات: " . $e->getMessage() . "<br>";
                    echo "<b class='small'>فشل التثبيت</b>";
                    die();
                }
            } else {
                echo "1.1 - ملف قاعدة البيانات <b>db.sql</b> غير موجود <b class='small'>فشل التثبيت</b><br>";
                die();
            }


            // update site settings
            $stmt = $con->prepare("UPDATE settings SET value=? WHERE name='site_url' LIMIT 1");
            $stmt->execute([$site_url]);
            $stmt = $con->prepare("UPDATE settings SET value=? WHERE name='site_folder' LIMIT 1");
            $stmt->execute([$site_folder]);
            echo "2 - تم تحديث إعدادات قاعدة البيانات .. <br>";

            // htacess edit path
            if ($site_folder) {
                $site_path =  $_SERVER["DOCUMENT_ROOT"] . "/" . $site_folder . "/";
            } else {
                $site_path =  $_SERVER["DOCUMENT_ROOT"] . "/";
            }
            // Read the content of the file
            $fileContent = file_get_contents("../.htaccess");
            // Modify the desired part of the content
            $fileContent = preg_replace('/#php_value include_path "(.*?)"/', 'php_value include_path "' . $site_path . '"', $fileContent);
            // Save the modified content back to the file
            file_put_contents("../.htaccess", $fileContent);
            echo "3 - تم تحديث ملف <b>.htaccess</b> .. <br>";

            unlink('db.sql');
            echo "4 - تم حذف ملف القاعدة المؤقت ..<br>";

            unlink('index.php');
            echo "5 - تم حذف ملف التثبيت بنجاح <br><a href='../' target='_blank'>انقر هنا لفتح الموقع</a><br><a href='../qalam' target='_blank'>انقر هنا لفتح لوحة تحكم الموقع</a><br>";
            echo "بيانات الدخول الى لوحة التحكم:<br>";
            echo "البريد الالكتروني: admin@gmail.com<br>";
            echo "كلمة المرور: admin<br>";
            unlink('Tajawal.ttf');
            unlink('.htaccess');
        }
        ?><br>
    </center>
    <form action="index.php" method="post">
        <label for="hostname">Hostname:</label>
        <input type="text" id="hostname" name="hostname" placeholder="اسم المضيف" required>
        <small class="small">مثال: localhost</small>
        <hr>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="اسم مستخدم قاعدة البيانات" required>
        <small class="small">مثال: root</small>
        <hr>

        <label for="password">Password:</label>
        <input type="password" id="password" placeholder="كلمة مرور قاعدة البيانات" name="password">
        <small class="small">مثال: root</small>
        <hr>

        <label for="database">Database Name:</label>
        <input type="text" id="database" name="database" placeholder="اسم قاعدة البيانات" required>
        <small class="small">مثال: wathiqa</small>
        <hr>

        <label for="database">Site URL:</label>
        <input type="text" id="site_url" name="site_url" placeholder="رابط الموقع (ينتهي بعلامة / )" required>
        <small class="small">مثال: https://your-site.com/</small>
        <hr>

        <label for="database">Site Folder:</label>
        <input type="text" id="site_folder" placeholder="اسم المجلد الفرعي للموقع (اتركه فارغ اذا كان في الرئيسية)" name="site_folder">
        <small class="small">مثال: wathiqa</small>

        <input type="hidden" id="check" name="check" value="1">

        <button type="submit">تثبيت</button>
    </form>
</body>

</html>