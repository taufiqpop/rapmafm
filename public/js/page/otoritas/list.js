let table;
$(() => {
    $('#table-data').on('click', '.btn-delete', function () {
        let data = table.row($(this).closest('tr')).data();

        let { id, name } = data;

        Swal.fire({
            title: 'Anda yakin?',
            html: `Anda akan menghapus otoritas "<b>${name}</b>"!`,
            footer: 'Data yang sudah dihapus tidak bisa dikembalikan kembali!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(BASE_URL + 'otoritas/delete', {
                    id,
                    _method: 'DELETE'
                }).done((res) => {
                    showSuccessToastr('sukses', 'Otoritas berhasil dihapus');
                    table.ajax.reload();
                }).fail((res) => {
                    let { status, responseJSON } = res;
                    showErrorToastr('oops', responseJSON.message);
                })
            }
        })
    })

    $('#form-otoritas-update').on('submit', function (e) {
        e.preventDefault();

        var data = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: data,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: () => {
                clearErrorMessage();
                $('#modal-otoritas-update').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-otoritas-update').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-otoritas-update').modal('hide');
            },
            error: ({ status, responseJSON }) => {
                $('#modal-otoritas-update').find('.modal-dialog').LoadingOverlay('hide', true);

                if (status == 422) {
                    generateErrorMessage(responseJSON);
                    return false;
                }

                showErrorToastr('oops', responseJSON.msg)
            }
        })
    })

    $('#table-data').on('click', '.btn-update', function () {
        var tr = $(this).closest('tr');
        var data = table.row(tr).data();

        clearErrorMessage();
        $('#form-otoritas-update')[0].reset();

        $.each(data, (key, value) => {
            $('#update-' + key).val(value);
        })

        $('#modal-otoritas-update').modal('show');
    })

    $('#form-otoritas').on('submit', function (e) {
        e.preventDefault();

        var data = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: data,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: () => {
                clearErrorMessage();
                $('#modal-otoritas').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-otoritas').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-otoritas').modal('hide');
            },
            error: ({ status, responseJSON }) => {
                $('#modal-otoritas').find('.modal-dialog').LoadingOverlay('hide', true);

                if (status == 422) {
                    generateErrorMessage(responseJSON);
                    return false;
                }

                showErrorToastr('oops', responseJSON.msg)
            }
        })
    })

    $('.btn-tambah').on('click', function () {
        $('#form-otoritas')[0].reset();
        clearErrorMessage();
        $('#modal-otoritas').modal('show');
    });

    table = $('#table-data').DataTable({
        processing: true,
        serverSide: true,
        language: dtLang,
        ajax: {
            url: BASE_URL + 'otoritas/data',
            type: 'get',
            dataType: 'json'
        },
        order: [[3, 'desc']],
        columnDefs: [{
            targets: [0, 2],
            searchable: false,
            orderable: false,
            className: 'text-center align-top',
        }, {
            targets: [1],
            className: 'text-left align-top'
        }, {
            targets: [3],
            visible: false,
        }],
        columns: [{
            data: 'DT_RowIndex'
        }, {
            data: 'name',
        }, {
            data: 'id',
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

                const button_permission = $('<a>', {
                    class: 'btn btn-secondary',
                    html: '<i class="bx bx-shield-quarter"></i>',
                    title: 'Pengaturan Hak Akses',
                    'data-placement': 'top',
                    'data-toggle': 'tooltip',
                    href: BASE_URL + 'otoritas/permission/' + row.slug_name
                })

                return $('<div>', {
                    class: 'btn-group',
                    html: () => {
                        let arr = [];

                        if (permissions.update) {
                            arr.push(button_permission)
                            arr.push(button_edit)
                        }
                        // if (UPDATE) arr.push(button_edit)
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