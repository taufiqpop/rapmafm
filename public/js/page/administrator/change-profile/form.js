$(() => {
    $('.change-profile').on('click', function () {
        clearErrorMessage();
        $('#modal-change-profile').modal('show');

        $.ajax({
            url: BASE_URL + 'users/get-profile',
            type: "GET",
            dataType: "json",
            success: (res) => {
                $('#update-fullname').val(res.name);
                $('#update-username').val(res.username);
                $('#update-email').val(res.email);
            },
            error: (xhr) => {
                showErrorToastr('Oops', 'Gagal mengambil data profil pengguna.');
            }
        });
    });

    $('#form-change-profile').on('submit', function (e) {
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
                $('#modal-change-profile').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-change-profile').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                $('#modal-change-profile').modal('hide');
                showSuccessToastr('Sukses', 'Profile berhasil diubah.');
            },
            error: ({ status, responseJSON }) => {
                $('#modal-change-profile').find('.modal-dialog').LoadingOverlay('hide', true);

                if (status === 422) {
                    return generateErrorMessage(responseJSON, true);
                }

                return showErrorToastr('Oops', responseJSON.msg);
            }
        });
    });
});