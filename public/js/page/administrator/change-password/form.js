$(() => {
    $('#form-change-password').on('submit', function (e) {
        e.preventDefault();

        let data = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: data,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: () => {
                clearErrorMessage();
                $('#modal-change-password').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-change-password').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                $('#modal-change-password').modal('hide');
                showSuccessToastr('sukses', 'Kata sandi berhasil diganti. Selanjutnya silahkan masuk dengan kata sandi baru anda')
            },
            error: ({ status, responseJSON }) => {
                $('#modal-change-password').find('.modal-dialog').LoadingOverlay('hide', true);

                if (status == 422) {
                    return generateErrorMessage(responseJSON, true);
                }

                return showErrorToastr('oops', responseJSON.msg)
            }
        })
    })

    $('.change-password').on('click', function () {
        $('#form-change-password')[0].reset();
        clearErrorMessage();
        $('#modal-change-password').modal('show');
    })

    $('.toggle-password').on('click', function () {
        let passwordInput = $(this).closest('.input-group').find('input');
        let icon = $(this).find('i');
        
        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordInput.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    })
})
