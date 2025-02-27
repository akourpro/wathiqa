<?php
// DB CONFIG & FUNCTIONS
include_once 'includes/config.php';
include_once 'includes/functions.php';

// POST DATA
$request_body = file_get_contents('php://input');
$data = json_decode($request_body);
$action = safer($data->action);

if (!empty($action)) {
    if ($action === "create") {
        $title = safer($data->title) ?? NULL;
        $slug = safer($data->slug) ?? NULL;
        $status = safer($data->status) ?? 'enable';
        $description = safer($data->description) ?? NULL;
        $icon = safer($data->icon) ?? NULL;
        if (empty($slug)) {
            $slug = genCode("categories", "slug", "token", 6);
        }
        // Check msg Exist
        dbSelect("categories", "*", "WHERE slug = ? LIMIT 1", [$slug]);
        if ($countrows == 0) {
            if (!empty($title)) {
                dbInsert("categories", "title, slug, status, description, icon, date", [$title, $slug, $status, $description, $icon, date("Y-m-d H:i:s")]);
                echo json_encode(array('status' => true, "message" => "تم انشاء الفئة بنجاح"));
            } else {
                echo json_encode(array('status' => false, "message" => "اسم الفئة مطلوب"));
            }
        } else {
            echo json_encode(array('status' => false, "message" => "اسم الرابط موجود مسبقًا"));
            die();
        }
    }

    if ($action === "delete") {
        $id = safer($data->id);
        // Check msg Exist
        dbSelect("categories", "id", "WHERE id=? LIMIT 1", [$id]);
        if ($countrows === 1) { // 
            dbDelete("categories", "WHERE id = ? LIMIT 1", [$id]);
            echo json_encode(array('status' => true, "message" => "تم حذف الفئة بنجاح"));
            die();
        } else {
            echo json_encode(array('status' => false, "message" => "الفئة غير موجودة"));
            die();
        }
    }
} else {
    echo json_encode(array('status' => false));
    die();
}
