let table;
$(() => {
    // Delete
    $('#table-data').on('click', '.btn-delete', function () {
        let data = table.row($(this).closest('tr')).data();

        let { id, fullname } = data;

        Swal.fire({
            title: 'Anda yakin?',
            html: `Anda akan menghapus alumni "<b>${fullname}</b>"!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(BASE_URL + 'alumni/delete', {
                    id,
                    _method: 'DELETE'
                }).done((res) => {
                    showSuccessToastr('Sukses', 'Alumni berhasil dihapus');
                    table.ajax.reload();
                }).fail((res) => {
                    let { status, responseJSON } = res;
                    showErrorToastr('oops', responseJSON.message);
                })
            }
        })
    })

    // Update
    $('#form-alumni-update').on('submit', function (e) {
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
                $('#modal-alumni-update').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-alumni-update').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-alumni-update').modal('hide');

                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil disimpan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: ({ status, responseJSON }) => {
                $('#modal-alumni-update').find('.modal-dialog').LoadingOverlay('hide', true);

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
        $('#form-alumni-update')[0].reset();

        $('.images-preview').attr('src', '').hide();
        $('.images').val('');

        $.each(data, (key, value) => {
            $('#update-' + key).val(value);
        })

        $('#modal-alumni-update').modal('show');
    })

    // Create
    $('#form-alumni').on('submit', function (e) {
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
                $('#modal-alumni').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-alumni').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-alumni').modal('hide');

                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil disimpan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: ({ status, responseJSON }) => {
                $('#modal-alumni').find('.modal-dialog').LoadingOverlay('hide', true);

                if (status == 422) {
                    generateErrorMessage(responseJSON);
                    return false;
                }

                showErrorToastr('oops', responseJSON.msg)
            }
        })
    })

    $('.btn-tambah').on('click', function () {
        $('#form-alumni')[0].reset();
        clearErrorMessage();

        $('.images-preview').attr('src', '').hide();
        $('.images').val('');

        $('#modal-alumni').modal('show');
    });

    // List
    table = $('#table-data').DataTable({
        processing: true,
        serverSide: true,
        language: dtLang,
        ajax: {
            url: BASE_URL + 'alumni/data',
            type: 'get',
            dataType: 'json'
        },
        order: [[4, 'desc'], [1, 'asc']],
        columnDefs: [{
            targets: [0, -2],
            searchable: false,
            orderable: false,
            className: 'text-center align-top',
        }, {
            targets: [1, 2, 3],
            className: 'text-left align-top'
        }, {
            targets: [4, 5],
            className: 'text-center align-top'
        }, {
            targets: [-1],
            visible: false,
        }],
        columns: [{
            data: 'DT_RowIndex'
        }, {
            data: 'fullname',
        }, {
            data: 'nickname',
        }, {
            data: 'sub_divisi',
            render: (data, type, row) => {
                return `${row.divisi}<br>${row.sub_divisi}`
            }
        }, {
            data: 'tahun_kepengurusan',
        }, {
            data: 'gender',
            render: (data, type, row) => {
                if (data == 'L') {
                    return 'Laki-Laki'
                }

                if (data == 'P') {
                    return 'Perempuan'
                }
            }
        }, {
            data: 'no_hp',
            render: (data, type, row) => {
                if (data) {
                    return data
                } else {
                    '-'
                }
            }
        }, {
            data: 'prodi',
            render: (data, type, row) => {
                return `${row.fakultas}<br>${row.prodi}`
            }
        }, {
            data: 'id',
            render: (data, type, row) => {
                const button_instagram = $('<a>', {
                    style: 'color: white',
                    class: 'btn btn-danger btn-instagram',
                    html: '<i class="bx bxl-instagram"></i>',
                    'data-id': data,
                    title: 'Link Instagram',
                    'data-placement': 'top',
                    'data-toggle': 'tooltip',
                    href: `https://www.instagram.com/${row.instagram}`,
                    target: '_blank'
                });

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

                        arr.push(button_instagram)

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

    // Switch Status
    $('#table-data').on('change', '.switch-active', function () {
        let id = $(this).data('id');
        let value = $(this).val();

        $.post(BASE_URL + 'alumni/switch', {
            id,
            value,
            _method: 'PATCH'
        }).done((res) => {
            showSuccessToastr('sukses', value == '1' ? 'Alumni berhasil diaktifkan' : 'Alumni berhasil dinonaktifkan');
            table.ajax.reload();
        }).fail((res) => {
            let { status, responseJSON } = res;
            showErrorToastr('oops', responseJSON.message);
        })
    })

    // Export Excel
    $('.btn-export').on('click', function() {
        window.location.href = BASE_URL + 'alumni/exportExcel';
    });
})