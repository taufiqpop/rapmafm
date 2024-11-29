let table;
$(() => {
    // Delete
    $('#table-data').on('click', '.btn-delete', function () {
        let data = table.row($(this).closest('tr')).data();

        let { id, nama } = data;

        Swal.fire({
            title: 'Anda yakin?',
            html: `Anda akan menghapus pesan "<b>${nama}</b>"!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(BASE_URL + 'pesan/delete', {
                    id,
                    _method: 'DELETE'
                }).done((res) => {
                    showSuccessToastr('Sukses', 'Pesan berhasil dihapus');
                    table.ajax.reload();
                }).fail((res) => {
                    let { status, responseJSON } = res;
                    showErrorToastr('oops', responseJSON.message);
                })
            }
        })
    })

    // Update
    $('#form-pesan-update').on('submit', function (e) {
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
                $('#modal-pesan-update').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-pesan-update').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-pesan-update').modal('hide');
                
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil disimpan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: ({ status, responseJSON }) => {
                $('#modal-pesan-update').find('.modal-dialog').LoadingOverlay('hide', true);

                if (status == 422) {
                    generateErrorMessage(responseJSON);
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
        $('#form-pesan-update')[0].reset();

        $.each(data, (key, value) => {
            $('#update-' + key).val(value);
        })

        $('#modal-pesan-update').modal('show');
    })

    // Create
    $('#form-pesan').on('submit', function (e) {
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
                $('#modal-pesan').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-pesan').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-pesan').modal('hide');
                
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil disimpan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: ({ status, responseJSON }) => {
                $('#modal-pesan').find('.modal-dialog').LoadingOverlay('hide', true);

                if (status == 422) {
                    generateErrorMessage(responseJSON);
                    return false;
                }

                showErrorToastr('oops', responseJSON.msg)
            }
        })
    })

    $('.btn-tambah').on('click', function () {
        $('#form-pesan')[0].reset();
        clearErrorMessage();
        $('#modal-pesan').modal('show');
    });

    // List
    table = $('#table-data').DataTable({
        processing: true,
        serverSide: true,
        language: dtLang,
        ajax: {
            url: BASE_URL + 'pesan/data',
            type: 'get',
            dataType: 'json'
        },
        order: [[5, 'desc']],
        columnDefs: [{
            targets: [0, -2],
            searchable: false,
            orderable: false,
            className: 'text-center align-top',
        }, {
            targets: [1, 2, 3, 4],
            className: 'text-left align-top'
        }, {
            targets: [-1],
            visible: false,
        }],
        columns: [{
            data: 'DT_RowIndex'
        }, {
            data: 'nama',
        }, {
            data: 'email',
        }, {
            data: 'subject',
        }, {
            data: 'message',
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

                return $('<div>', {
                    class: 'btn-group',
                    html: () => {
                        let arr = [];

                        if (permissions.update) {
                            arr.push(button_edit)
                        }

                        if (permissions.delete) {
                            arr.push(button_delete)
                        }

                        return arr;
                    }
                }).prop('outerHTML');
            }
        }, {
            data: 'created_at'
        }]
    })
})