let table;
$(() => {
    // Delete
    $('#table-data').on('click', '.btn-delete', function () {
        let data = table.row($(this).closest('tr')).data();

        let { id, judul } = data;

        Swal.fire({
            title: 'Anda yakin?',
            html: `Anda akan menghapus rapma news "<b>${judul}</b>"!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(BASE_URL + 'rapma-news/delete', {
                    id,
                    _method: 'DELETE'
                }).done((res) => {
                    showSuccessToastr('Sukses', 'Rapma News berhasil dihapus');
                    table.ajax.reload();
                }).fail((res) => {
                    let { status, responseJSON } = res;
                    showErrorToastr('oops', responseJSON.message);
                })
            }
        })
    })

    // Update
    $('#form-rapma-news-update').on('submit', function (e) {
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
                $('#modal-rapma-news-update').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-rapma-news-update').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-rapma-news-update').modal('hide');

                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil disimpan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: ({ status, responseJSON }) => {
                $('#modal-rapma-news-update').find('.modal-dialog').LoadingOverlay('hide', true);

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
        $('#form-rapma-news-update')[0].reset();

        $('.images-preview').attr('src', '').hide();
        $('.images').val('');

        $.each(data, (key, value) => {
            $('#update-' + key).val(value);
        })

        $('#modal-rapma-news-update').modal('show');
    })

    // Create
    $('#form-rapma-news').on('submit', function (e) {
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
                $('#modal-rapma-news').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-rapma-news').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-rapma-news').modal('hide');

                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil disimpan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: ({ status, responseJSON }) => {
                $('#modal-rapma-news').find('.modal-dialog').LoadingOverlay('hide', true);

                if (status == 422) {
                    generateErrorMessage(responseJSON);
                    return false;
                }

                showErrorToastr('oops', responseJSON.msg)
            }
        })
    })

    $('.btn-tambah').on('click', function () {
        $('#form-rapma-news')[0].reset();
        clearErrorMessage();

        $('.images-preview').attr('src', '').hide();
        $('.images').val('');

        $('#modal-rapma-news').modal('show');
    });

    // List
    table = $('#table-data').DataTable({
        processing: true,
        serverSide: true,
        language: dtLang,
        ajax: {
            url: BASE_URL + 'rapma-news/data',
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
            data: 'deskripsi',
            render: function (data, type, row) {
                return `<button class="btn btn-primary btn-sm deskripsi-btn" data-deskripsi="${data}" data-toggle="modal" data-target="#deskripsiModal"><i class="fa fa-eye"></i> Lihat Deskripsi</button>`;
            }
        }, {
            data: 'tanggal',
            render: function (data, type, row) {
                return formatTanggalIndonesia(data);
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
            data: 'path',
            render: function(data, type, row) {
                if (data) {
                    return `<img src="${data}" alt="Image" style="width: 100px; height: auto;">`;
                } else {
                    return 'No Image';
                }
            }
        }, {
            data: 'encrypted_id',
            render: (data, type, row) => {
                const button_link = $('<a>', {
                    style: 'color: white',
                    class: 'btn btn-info btn-link',
                    html: '<i class="bx bx-link"></i>',
                    'data-id': data,
                    title: 'Link Berita',
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

        $.post(BASE_URL + 'rapma-news/switch', {
            id,
            value,
            _method: 'PATCH'
        }).done((res) => {
            showSuccessToastr('sukses', value == '1' ? 'Rapma News berhasil diaktifkan' : 'Rapma News berhasil dinonaktifkan');
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
    $('#modal-rapma-news').on('hidden.bs.modal', function () {
        $('.images').val('');
        $('.images-preview').attr('src', '').hide();
    });

    // Deskripsi
    $(document).on('click', '.deskripsi-btn', function () {
        const deskripsi = $(this).data('deskripsi');
        $('#deskripsiContent').text(deskripsi);
    });

    // Format Tanggal ID
    function formatTanggalIndonesia(isoDate) {
        const date = new Date(isoDate);
    
        const tanggal = date.toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        });
    
        const waktu = date.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false,
        });
    
        return `${tanggal}<br>(${waktu} WIB)`;
    }
})