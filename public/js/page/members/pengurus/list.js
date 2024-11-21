let table;
$(() => {
    // Delete
    $('#table-data').on('click', '.btn-delete', function () {
        let data = table.row($(this).closest('tr')).data();

        let { id, fullname } = data;

        Swal.fire({
            title: 'Anda yakin?',
            html: `Anda akan menghapus pengurus "<b>${fullname}</b>"!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(BASE_URL + 'pengurus/delete', {
                    id,
                    _method: 'DELETE'
                }).done((res) => {
                    showSuccessToastr('Sukses', 'Pengurus berhasil dihapus');
                    table.ajax.reload();
                }).fail((res) => {
                    let { status, responseJSON } = res;
                    showErrorToastr('oops', responseJSON.message);
                })
            }
        })
    })

    // Update
    $('#form-pengurus-update').on('submit', function (e) {
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
                $('#modal-pengurus-update').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-pengurus-update').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-pengurus-update').modal('hide');

                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil disimpan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: ({ status, responseJSON }) => {
                $('#modal-pengurus-update').find('.modal-dialog').LoadingOverlay('hide', true);

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
        $('#form-pengurus-update')[0].reset();

        $('.images-preview').attr('src', '').hide();
        $('.images').val('');

        $.each(data, (key, value) => {
            $('#update-' + key).val(value);
        })

        $('#modal-pengurus-update').modal('show');
    })

    // Create
    $('#form-pengurus').on('submit', function (e) {
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
                $('#modal-pengurus').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-pengurus').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-pengurus').modal('hide');

                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil disimpan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: ({ status, responseJSON }) => {
                $('#modal-pengurus').find('.modal-dialog').LoadingOverlay('hide', true);

                if (status == 422) {
                    generateErrorMessage(responseJSON);
                    return false;
                }

                showErrorToastr('oops', responseJSON.msg)
            }
        })
    })

    $('.btn-tambah').on('click', function () {
        $('#form-pengurus')[0].reset();
        clearErrorMessage();

        $('.images-preview').attr('src', '').hide();
        $('.images').val('');

        $('#modal-pengurus').modal('show');
    });

    // List
    table = $('#table-data').DataTable({
        processing: true,
        serverSide: true,
        language: dtLang,
        ajax: {
            url: BASE_URL + 'pengurus/data',
            type: 'get',
            dataType: 'json'
        },
        order: [[1, 'asc']],
        columnDefs: [{
            targets: [0, -2],
            searchable: false,
            orderable: false,
            className: 'text-center align-top',
        }, {
            targets: [1, 2, 3, 6],
            className: 'text-left align-top'
        }, {
            targets: [4, 5, 7],
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
        }, {
            data: 'prodi',
            render: (data, type, row) => {
                return `${row.fakultas}<br>${row.prodi}<br>Semester ${row.semester}`
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
                
                const button_twitter = $('<a>', {
                    style: 'color: white',
                    class: 'btn btn-info btn-twitter',
                    html: '<i class="bx bxl-twitter"></i>',
                    'data-id': data,
                    title: 'Link Twitter',
                    'data-placement': 'top',
                    'data-toggle': 'tooltip',
                    href: `https://x.com/${row.twitter}`,
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
                        arr.push(button_twitter)

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

        $.post(BASE_URL + 'pengurus/switch', {
            id,
            value,
            _method: 'PATCH'
        }).done((res) => {
            showSuccessToastr('sukses', value == '1' ? 'Pengurus berhasil diaktifkan' : 'Pengurus berhasil dinonaktifkan');
            table.ajax.reload();
        }).fail((res) => {
            let { status, responseJSON } = res;
            showErrorToastr('oops', responseJSON.message);
        })
    })
})