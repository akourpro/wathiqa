<title>الفئات</title>
<link rel="stylesheet" href="../templates/default/assets/vendor/fonts/remixicon/remixicon.css" />
<h4 class="py-3 mb-4"><span class="text-muted fw-light">الفئات /</span> عرض الكل</h4>
<style>
    .swal2-container {
        z-index: 1000000;
    }
</style>
<div class="row">
    <div class="col-sm">
        <button class="btn btn-primary btn-toggle-sidebar waves-effect waves-light" data-bs-toggle="offcanvas" data-bs-target="#addEventSidebar" aria-controls="addEventSidebar">
            <i class="ri-add-line ri-16px me-1_5"></i>
            <span class="align-middle">انشاء فئة جديدة</span>
        </button>

    </div>
</div>
<div class="card mt-2">
    <div class="table-responsive">
        <!-- <table class="orders_table table text-right" width="100%"> -->
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 20%;">العنوان</th>
                    <th style="width: 20%;">الوصف</th>
                    <th style="width: 10%;">Slug</th>
                    <th style="width: 20%;">الايقونة</th>
                    <th style="width: 5%;">الحالة</th>
                    <!-- <th style="width: 10%;">آخر تحديث</th> -->
                    <th style="width: 30%;">اجراء</th>
                </tr>
            </thead>
            <tbody>
                <?php
                dbSelect("categories", "*");
                foreach ($rows as $row) {
                    switch ($row['status']) {
                        case 'enable':
                            $status = 'ظاهر';
                            break;
                        default:
                            $status = 'مخفي';
                    }
                    echo '
                    <tr>
                        <td>' . $row['id'] . '</td>
                        <td>' . $row['title'] . '</td>
                        <td>' . $row['description'] . '</td>
                        <td>' . $row['slug'] . '</td>
                        <td class="text-center"><i class="' . $row['icon'] . '"></i><br>' . $row['icon'] . '</td>
                        <td>' . $status . '</td>
                        <!-- <td>' . $row['last_update'] . '</td> -->
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">إجراء</button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a href="../category/' . $row['slug'] . '/view" class="dropdown-item text-primary edit" target="_blank"><i class="mdi mdi-eye"></i> عرض</a>
                                    <!-- <span data-id="' . $row['id'] . '" class="dropdown-item text-warning edit"><i class="mdi mdi-pencil"></i> تعديل</span> -->
                                    <span data-id="' . $row['id'] . '" data-action="delete" data-name="' . $row['title'] . '" class="dropdown-item text-danger delete"><i class="mdi mdi-delete"></i> حذف</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    ';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<div class="col app-calendar-content">
    <div class="app-overlay"></div>
    <div class="offcanvas offcanvas-end event-sidebar" tabindex="-1" id="addEventSidebar" aria-labelledby="addEventSidebarLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="addEventSidebarLabel">إضافة فئة جديدة</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <!-- <form class="event-form pt-0" id="eventForm" onsubmit="return false"> -->
            <div class="form-floating form-floating-outline mb-5">
                <input type="text" class="form-control" id="title" name="title" placeholder="اسم او عنوان الفئة" />
                <label for="title">اسم الفئة</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
                <input type="text" class="form-control" id="slug" name="slug" placeholder="الاسم في الرابط slug" required />
                <label for="slug">رابط الفئة (Slug)</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
                <input type="text" class="form-control" id="icon" name="icon" placeholder="ri-shopping-cart-line" required />
                <label for="icon">الايقونة</label>
                <small class="text-danger">مكتبة الايقونات <a href="https://remixicon.com/" target="_blank">remixicon.com</a></small>
            </div>
            <div class="form-floating form-floating-outline mb-5">
                <select class="form-select" id="status" name="status">
                    <option value="enable" selected>ظاهر</option>
                    <option value="disable">مخفي</option>
                </select>
                <label for="status">الحالة</label>
            </div>

            <div class="form-floating form-floating-outline mb-5">
                <textarea class="form-control" name="description" id="description" placeholder="وصف قصير لا يتجاوز 125 حرف (للسيو)"></textarea>
                <label for="description">وصف قصير</label>
            </div>
            <div class="mb-5 d-flex justify-content-sm-between justify-content-start my-6 gap-2">
                <div class="d-flex">
                    <span type="submit" id="addEventBtn" class="btn btn-primary btn-add-event me-4">
                        إضافة
                    </span>
                    <span type="reset" class="btn btn-outline-secondary btn-cancel me-sm-0 me-1" data-bs-dismiss="offcanvas">
                        الغاء
                    </span>
                </div>
            </div>
            <!-- </form> -->
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // استهداف حقل الإدخال
        var inputField = $("#slug");

        // استبدال المسافات بعلامات _ عند كتابة المستخدم
        inputField.on("input", function() {
            var text = $(this).val();
            // استبدال جميع المسافات بعلامات _
            var replacedText = text.replace(/\s/g, "-");
            // تحديث قيمة حقل الإدخال
            $(this).val(replacedText);
        });
    });
</script>
<script src="js/categories.js"></script>