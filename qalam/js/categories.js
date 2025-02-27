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

        $("#addEventBtn").click(function() {
            action = "create";
            title = $("#title").val();
            slug = $("#slug").val();
            statuss = $("#status").val();
            description = $("#description").val();
            icon = $("#icon").val();

            $.ajax({
                type: "POST",
                url: "api/categories",
                data: JSON.stringify({
                    action: action,
                    title: title,
                    slug: slug,
                    status: statuss,
                    description: description,
                    icon: icon
                }),
                dataType: "json",
                encode: true,
                beforeSend: function() {
                    let timerInterval;
                    Swal.fire({
                        title: "الرجاء الانتظار ...",
                        timer: 5000,
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
                    $("#title").val('');
                    $("#slug").val('');
                    $("#status").val('');
                    $("#description").val('');
                    $("#icon").val('');
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
        });




        $(".delete").click(function() {
            id = $(this).data("id");
            action = $(this).data("action");
            cateName = $(this).data("name");

            Swal.fire({
                title: "هل انت متأكد من حذف الفئة (" + cateName + ")",
                icon: "error",
                showCancelButton: true,
                confirmButtonColor: "#FF0000",
                cancelButtonColor: "#9A9A9A",
                confirmButtonText: "نعم",
                cancelButtonText: "تراجع",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "api/categories",
                        data: JSON.stringify({
                            id: id,
                            action: action
                        }),
                        dataType: "json",
                        encode: true,
                        beforeSend: function() {
                            let timerInterval;
                            Swal.fire({
                                title: "الرجاء الانتظار ...",
                                timer: 5000,
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

        $(".edit").click(function() {
            action = "edit";
            edit_id = $(this).data("id");
            edit_id = $('#categoryId').val(edit_id);

            edit_title = $(this).data("title");
            edit_title = $('#title_edit').val(edit_title);

            edit_slug = $(this).data("slug");
            edit_slug = $('#slug_edit').val(edit_slug);

            edit_icon = $(this).data("icon");
            edit_icon = $('#icon_edit').val(edit_icon);


            edit_status = $(this).data("status");
            edit_status = $('#status_edit').val(edit_status);

            edit_description = $(this).data("description");
            edit_description = $('#description_edit').val(edit_description);

        });

        $('#editEventBtn').click(function() {
            edit_id = $('#categoryId').val();
            edit_title = $('#title_edit').val();
            edit_slug = $('#slug_edit').val();
            edit_icon = $('#icon_edit').val();
            edit_status = $('#status_edit').val();
            edit_description = $('#description_edit').val();
            $.ajax({
                type: "POST",
                url: "api/categories",
                data: JSON.stringify({
                    action: "edit",
                    id: edit_id,
                    title: edit_title,
                    slug: edit_slug,
                    status: edit_status,
                    description: edit_description,
                    icon: edit_icon
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
        });
    });