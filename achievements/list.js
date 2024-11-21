let table;
$(() => {
    // Delete
    $('#table-data').on('click', '.btn-delete', function () {
        let data = table.row($(this).closest('tr')).data();

        let { id, judul } = data;

        Swal.fire({
            title: 'Anda yakin?',
            html: `Anda akan menghapus achievements "<b>${judul}</b>"!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(BASE_URL + 'achievements/delete', {
                    id,
                    _method: 'DELETE'
                }).done((res) => {
                    showSuccessToastr('Sukses', 'Achievements berhasil dihapus');
                    table.ajax.reload();
                }).fail((res) => {
                    let { status, responseJSON } = res;
                    showErrorToastr('oops', responseJSON.message);
                })
            }
        })
    })

    // Update
    $('#form-achievements-update').on('submit', function (e) {
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
                $('#modal-achievements-update').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-achievements-update').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-achievements-update').modal('hide');

                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil disimpan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: ({ status, responseJSON }) => {
                $('#modal-achievements-update').find('.modal-dialog').LoadingOverlay('hide', true);

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
        $('#form-achievements-update')[0].reset();

        $('.images-preview').attr('src', '').hide();
        $('.images').val('');

        $.each(data, (key, value) => {
            $('#update-' + key).val(value);
        })

        $('#modal-achievements-update').modal('show');
    })

    // Create
    $('#form-achievements').on('submit', function (e) {
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
                $('#modal-achievements').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-achievements').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-achievements').modal('hide');

                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil disimpan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: ({ status, responseJSON }) => {
                $('#modal-achievements').find('.modal-dialog').LoadingOverlay('hide', true);

                if (status == 422) {
                    generateErrorMessage(responseJSON);
                    return false;
                }

                showErrorToastr('oops', responseJSON.msg)
            }
        })
    })

    $('.btn-tambah').on('click', function () {
        $('#form-achievements')[0].reset();
        clearErrorMessage();

        $('.images-preview').attr('src', '').hide();
        $('.images').val('');

        $('#modal-achievements').modal('show');
    });

    // List
    table = $('#table-data').DataTable({
        processing: true,
        serverSide: true,
        language: dtLang,
        ajax: {
            url: BASE_URL + 'achievements/data',
            type: 'get',
            dataType: 'json'
        },
        order: [[7, 'desc']],
        columnDefs: [{
            targets: [0, -2],
            searchable: false,
            orderable: false,
            className: 'text-center align-top',
        }, {
            targets: [1],
            className: 'text-left align-top'
        }, {
            targets: [2, 3, 4, 5],
            className: 'text-center align-top'
        }, {
            targets: [-1],
            visible: false,
        }],
        columns: [{
            data: 'DT_RowIndex'
        }, {
            data: 'judul',
        }, {
            data: 'tahun',
        }, {
            data: 'order',
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
            data: 'path',
            render: function(data, type, row) {
                if (data) {
                    return `<img src="${data}" alt="Image" style="width: 100px; height: auto;">`;
                } else {
                    return 'No Image';
                }
            }
        }, {
            data: 'id',
            render: (data, type, row) => {
                const button_link = $('<a>', {
                    style: 'color: white',
                    class: 'btn btn-info btn-link',
                    html: '<i class="bx bx-link"></i>',
                    'data-id': data,
                    title: 'Link Event',
                    'data-placement': 'top',
                    'data-toggle': 'tooltip',
                    href: row.link,
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

                        arr.push(button_link)

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

        $.post(BASE_URL + 'achievements/switch', {
            id,
            value,
            _method: 'PATCH'
        }).done((res) => {
            showSuccessToastr('sukses', value == '1' ? 'Achievements berhasil diaktifkan' : 'Achievements berhasil dinonaktifkan');
            table.ajax.reload();
        }).fail((res) => {
            let { status, responseJSON } = res;
            showErrorToastr('oops', responseJSON.message);
        })
    })

    // Image Preview
    $('.images').on('change', function() {
        let reader = new FileReader();
        let preview = $('.images-preview');

        reader.onload = function(e) {
            preview.attr('src', e.target.result);
            preview.show();
        }

        if (this.files && this.files[0]) {
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Images Clear
    $('#modal-achievements').on('hidden.bs.modal', function () {
        $('.images').val('');
        $('.images-preview').attr('src', '').hide();
    });
})