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
</div>