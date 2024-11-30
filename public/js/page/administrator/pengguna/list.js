let table;
$(() => {
    // Update Role
    $('#form-update-role').on('submit', function (e) {
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
                $('#modal-update-role').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-update-role').find('.modal-dialog').LoadingOverlay('hide', true);
                showSuccessToastr('sukses', 'Data peran berhasil diperbarui');
                table.ajax.reload();
                $('#modal-update-role').modal('hide');
            },
            error: ({ status, responseJSON }) => {
                $('#modal-update-role').find('.modal-dialog').LoadingOverlay('hide', true);

                return showErrorToastr('oops', responseJSON.msg);
            }
        })
    })

    $('#table-data').on('click', '.btn-update-role', function () {
        let data = table.row($(this).closest('tr')).data();
        let { id, name, roles } = data;

        $('.user-name').text(name);
        $('#update-role-user-id').val(id);

        $('.checkbox-role').prop('checked', false);
        for (const role of roles) {
            $('#role-' + role.id).prop('checked', true);
        }

        $('#modal-update-role').modal('show');
    })

    // Reset Password
    $('#table-data').on('click', '.btn-reset-password', function () {
        let data = table.row($(this).closest('tr')).data();

        let { id, name } = data;

        Swal.fire({
            title: 'Anda yakin?',
            html: `Anda akan mereset kata sandi milik "<b>${name}</b>"!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Reset!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(BASE_URL + 'users/reset-password', {
                    id,
                    _method: 'PATCH'
                }).done((res) => {
                    showSuccessToastr('sukses', 'Kata sandi pengguna berhasil direset');
                    table.ajax.reload();
                }).fail((res) => {
                    let { status, responseJSON } = res;
                    showErrorToastr('oops', responseJSON.message);
                })
            }
        })
    })

    // Delete
    $('#table-data').on('click', '.btn-delete', function () {
        let data = table.row($(this).closest('tr')).data();

        let { id, name } = data;

        Swal.fire({
            title: 'Anda yakin?',
            html: `Anda akan menghapus pengguna "<b>${name}</b>"!`,
            footer: 'Data yang sudah dihapus tidak bisa dikembalikan kembali!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(BASE_URL + 'users/delete', {
                    id,
                    _method: 'DELETE'
                }).done((res) => {
                    showSuccessToastr('sukses', 'Pengguna berhasil dihapus');
                    table.ajax.reload();
                }).fail((res) => {
                    let { status, responseJSON } = res;
                    showErrorToastr('oops', responseJSON.message);
                })
            }
        })
    })

    // Switch Status
    $('#table-data').on('change', '.switch-active', function () {
        let id = $(this).data('id');
        let value = $(this).val();

        $.post(BASE_URL + 'users/switch', {
            id,
            value,
            _method: 'PATCH'
        }).done((res) => {
            showSuccessToastr('sukses', value == '1' ? 'User berhasil diaktifkan' : 'User berhasil dinonaktifkan');
            table.ajax.reload();
        }).fail((res) => {
            let { status, responseJSON } = res;
            showErrorToastr('oops', responseJSON.message);
            console.log(res);
        })
    })

    // Update User
    $('#form-pengguna-update').on('submit', function (e) {
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
                $('#modal-pengguna-update').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-pengguna-update').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-pengguna-update').modal('hide');
            },
            error: ({ status, responseJSON }) => {
                $('#modal-pengguna-update').find('.modal-dialog').LoadingOverlay('hide', true);

                if (status == 422) {
                    generateErrorMessage(responseJSON, true);
                    return false;
                }

                showErrorToastr('oops', responseJSON.msg)
            }
        })
    })

    $('#table-data').on('click', '.btn-update', function () {
        let tr = $(this).closest('tr');
        let data = table.row(tr).data();

        clearErrorMessage();
        $('#form-pengguna-update')[0].reset();

        $.each(data, (key, value) => {
            $('#update-' + key).val(value);
        })

        $('#modal-pengguna-update').modal('show');
    })

    // Create User
    $('#form-pengguna').on('submit', function (e) {
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
                $('#modal-pengguna').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-pengguna').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-pengguna').modal('hide');
            },
            error: ({ status, responseJSON }) => {
                $('#modal-pengguna').find('.modal-dialog').LoadingOverlay('hide', true);

                if (status == 422) {
                    generateErrorMessage(responseJSON);
                    return false;
                }

                showErrorToastr('oops', responseJSON.msg)
            }
        })
    })

    $('.btn-tambah').on('click', function () {
        $('#form-pengguna')[0].reset();
        clearErrorMessage();
        $('#modal-pengguna').modal('show');
    });

    // List
    table = $('#table-data').DataTable({
        language: dtLang,
        serverSide: true,
        processing: true,
        ajax: {
            url: BASE_URL + 'users/data',
            type: 'get',
            dataType: 'json'
        },
        order: [[7, 'desc']],
        columnDefs: [{
            targets: [0, -2],
            orderable: false,
            searchable: false,
            className: 'text-center align-top'
        }, {
            targets: [1, 2, 3, 4],
            className: 'text-left align-top'
        }, {
            targets: [5],
            className: 'text-center align-top'
        }, {
            targets: [-1],
            visible: false,
        }],
        columns: [{
            data: 'DT_RowIndex'
        }, {
            data: 'name',
        }, {
            data: 'username'
        }, {
            data: 'real_password'
        }, {
            data: 'encrypted_id',
            render: (data, type, row) => {
                if (row.roles && Array.isArray(row.roles)) {
                    return row.roles.map(role => role.name).join(', ');
                }
                return '';
            }
        }, {
            data: 'is_active',
            render: (data, type, row) => {
                return `
                <div class="custom-control custom-switch mb-3" dir="ltr">
                    <input type="checkbox" class="custom-control-input switch-active" id="aktif-${row.id}" data-id="${row.id}" ${data == '1' ? 'checked' : ''} value="${data == '1' ? 0 : 1}">
                    <label class="custom-control-label" for="aktif-${row.id}">${data == '1' ? 'Aktif' : 'Nonaktif'}</label>
                </div>
                `;
            }
        }, {
            data: 'encrypted_id',
            render: (data, type, row) => {
                const button_edit = $('<button>', {
                    class: 'btn btn-primary btn-update',
                    html: '<i class="bx bx-pencil"></i>',
                    'data-id': data,
                    title: 'Update Data',
                    'data-placement': 'top',
                    'data-toggle': 'tooltip'
                });

                const button_delete = $('<button>', {
                    class: 'btn btn-danger btn-delete',
                    html: '<i class="bx bx-trash"></i>',
                    'data-id': data,
                    title: 'Delete Data',
                    'data-placement': 'top',
                    'data-toggle': 'tooltip'
                });

                const button_reset_password = $('<button>', {
                    class: 'btn btn-secondary btn-reset-password',
                    html: '<i class="bx bx-key"></i>',
                    'data-id': data,
                    title: 'Reset Password',
                    'data-placement': 'top',
                    'data-toggle': 'tooltip'
                });

                const button_update_role = $('<button>', {
                    class: 'btn btn-success btn-update-role',
                    html: '<i class="bx bx-user"></i>',
                    'data-id': data,
                    title: 'Peran Pengguna',
                    'data-placement': 'top',
                    'data-toggle': 'tooltip'
                });

                return $('<div>', {
                    class: 'btn-group',
                    html: () => {
                        let arr = [];

                        if (permissions.update) {
                            arr.push(button_update_role)
                            arr.push(button_reset_password)
                            arr.push(button_edit)
                        }
                        
                        if (permissions.delete) arr.push(button_delete)

                        return arr;
                    }
                }).prop('outerHTML');
            }
        }, {
            data: 'created_at'
        }]
    })
})