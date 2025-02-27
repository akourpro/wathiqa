<?php
// DB CONFIG & FUNCTIONS
include_once 'includes/config.php';
include_once 'includes/functions.php';

// POST DATA
$request_body = file_get_contents('php://input');
$data = json_decode($request_body);
$action = safer($data->action);

if (!empty($action)) {

    if ($action === "delete") {
        $id = safer($data->id);
        // Check msg Exist
        dbSelect("articles", "id", "WHERE id = ? LIMIT 1", [$id]);
        if ($countrows === 1) { // 
            dbDelete("articles", "WHERE id = ? LIMIT 1", [$id]);
            echo json_encode(array('status' => true, "message" => "تم حذف المقال بنجاح"));
            die();
        } else {
            echo json_encode(array('status' => false, "message" => "المقال غير موجود"));
            die();
        }
    }
} else {
    echo json_encode(array('status' => false));
    die();
}
