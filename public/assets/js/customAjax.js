function ajaxRequest(type, route, formData, form = null, redirect_url = null) {

    if(form){
        var old_btn_text = form.find('#submit').text();
        form.find("#submit").prop('disabled', true);
        form.find("#submit").html("Please Wait...");
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: type,
        url: route,
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success: function (data) {
            if(form){
                form.find("#submit").prop('disabled', false);
                form.find("#submit").html(old_btn_text);
            }

            if (data.code == 200) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: data.message,
                    showConfirmButton: false,
                    timer: 3000,
                    showCloseButton: false
                });
                if (data.url) {
                    setTimeout(() => {
                        location.replace(data.url);
                    }, 3000);
                } else if (redirect_url) {
                    setTimeout(() => {
                        location.replace(redirect_url);
                    }, 3000);
                }

            } else if (data.code == 100) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: data.message,
                    showConfirmButton: false,
                    timer: 3000,
                    showCloseButton: false
                });
            }else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'warning',
                    title: data.message,
                    showConfirmButton: false,
                    timer: 3000,
                    showCloseButton: false
                });
            }
            $('#data-table').DataTable().ajax.reload();
            if (form) {
                form[0].reset();
            }
        },
        error: function (data) {
            var response = data.responseJSON;

            if(form){
                form.find("#submit").prop('disabled', false);
                form.find("#submit").html(old_btn_text);
            }

            switch (data.status) {
                case 422:
                    if (response.type == 'warning') {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 3000,
                            showCloseButton: false
                        });
                    }
                    else {
                        var message = '';
                        var count = 1;
                        $.each(response.errors, function (key, errors) {
                            if(count == 1){
                                message += errors[0];
                            }
                            count ++;
                            // var input = $('[name="' + key + '"]');
                            // var wrapper = input.parent();
                            // wrapper.find('.invalid-feedback').attr('hidden', true);
                            // input.addClass('is-invalid');
                            // wrapper.append('<div class="invalid-feedback">' + errors[0] + '</div>');
                        });
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: message,
                            showConfirmButton: false,
                            timer: 3000,
                            showCloseButton: false
                        });
                    }
                    break;
                case 500:
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Some thing went wrong!',
                        showConfirmButton: false,
                        timer: 3000,
                        showCloseButton: false
                    });
                    break;
            }
        }
    });
}
