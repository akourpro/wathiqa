<?php
$templatesDir = '../templates';
$folders = array_filter(glob($templatesDir . '/*'), 'is_dir');

?>
<title>القوالب</title>
<div class="container mt-5">
    <h1 class="text-center mb-4">معرض القوالب</h1>
    <div class="row">
        <?php foreach ($folders as $folder): ?>
            <?php
            $templateName = basename($folder);
            $screenshotPath = "$folder/screenshot.png";
            if (file_exists($screenshotPath)): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo $screenshotPath; ?>" class="card-img-top" alt="<?php echo $templateName; ?>" style="height: 250px">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0"><?php echo $templateName; ?></h5>
                                <p class="card-text mb-0">هذا هو قالب <?php echo $templateName; ?>.</p>
                            </div>
                            <?php if ($site['theme'] == $templateName) {
                                echo '<span class="btn btn-success">مفعل</span>';
                            } else {
                                echo '<span data-name="' . $templateName . '" class="btn btn-primary active">تفعيل</span>';
                            }
                            ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

<script>
    $(".active").click(function() {
        name = $(this).data("name");

        Swal.fire({
            title: "هل انت متأكد تفعيل القالب (" + name + ")",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#4a971c",
            cancelButtonColor: "#9A9A9A",
            confirmButtonText: "نعم",
            cancelButtonText: "تراجع",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "api/themes",
                    data: JSON.stringify({
                        name: name
                    }),
                    dataType: "json",
                    encode: true,
                    beforeSend: function() {
                        let timerInterval;
                        Swal.fire({
                            title: "الرجاء الانتظار ...",
                            // timer: 5000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                                timerInterval = setInterval(() => {}, 100);
                            },
                            willClose: () => {
                                clearInterval(timerInterval);
                            },
                        });
                    },
                }).done(function(data) {
                    if (data.status) {
                        Swal.fire({
                            icon: "success",
                            title: data.message,
                            toast: true,
                            position: "top-start",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener("mouseenter", Swal.stopTimer);
                                toast.addEventListener("mouseleave", Swal.resumeTimer);
                            },
                        });
                        setTimeout(location.reload.bind(location), 500);
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: data.message,
                            toast: true,
                            position: "top-start",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener("mouseenter", Swal.stopTimer);
                                toast.addEventListener("mouseleave", Swal.resumeTimer);
                            },
                        });
                    }
                });
            }
        });
    });
</script>