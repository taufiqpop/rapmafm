$(() => {
    // Delete
    $('#table-data').on('click', '.btn-delete', function () {
        let data = table.row($(this).closest('tr')).data();

        let { id, keterangan } = data;

        Swal.fire({
            title: 'Anda yakin?',
            html: `Anda akan menghapus kas "<b>${keterangan}</b>"!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(BASE_URL + 'arus-kas/delete', {
                    id,
                    _method: 'DELETE'
                }).done((res) => {
                    showSuccessToastr('Sukses', 'Arus Kas berhasil dihapus');
                    table.ajax.reload();
                }).fail((res) => {
                    let { status, responseJSON } = res;
                    showErrorToastr('oops', responseJSON.message);
                })
            }
        })
    })

    // Update
    $('#form-arus-kas-update').on('submit', function (e) {
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
                $('#modal-arus-kas-update').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-arus-kas-update').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-arus-kas-update').modal('hide');
                
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil disimpan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: ({ status, responseJSON }) => {
                $('#modal-arus-kas-update').find('.modal-dialog').LoadingOverlay('hide', true);

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
        $('#form-arus-kas-update')[0].reset();

        $.each(data, (key, value) => {
            $('#update-' + key).val(value);
        })

        $('#modal-arus-kas-update').modal('show');
    })

    // Create
    $('#form-arus-kas').on('submit', function (e) {
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
                $('#modal-arus-kas').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-arus-kas').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-arus-kas').modal('hide');
                
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil disimpan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: ({ status, responseJSON }) => {
                $('#modal-arus-kas').find('.modal-dialog').LoadingOverlay('hide', true);

                if (status == 422) {
                    generateErrorMessage(responseJSON);
                    return false;
                }

                showErrorToastr('oops', responseJSON.msg)
            }
        })
    })

    $('.btn-tambah').on('click', function () {
        $('#form-arus-kas')[0].reset();
        clearErrorMessage();
        $('#modal-arus-kas').modal('show');
    });

    // List
    let saldoBerjalan = 0;
    table = $('#table-data').DataTable({
        processing: true,
        serverSide: true,
        language: dtLang,
        ajax: {
            url: BASE_URL + 'arus-kas/data',
            type: 'get',
            dataType: 'json'
        },
        order: [[2, 'asc']],
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
            data: 'tanggal',
            render: function(data, type, row) {
                const date = new Date(data);
                return date.toLocaleDateString('id-ID', { month: 'long' });
            }
        }, {
            data: 'tanggal',
            render: function(data, type, row) {
                const date = new Date(data);
                return date.toLocaleDateString('id-ID', { day: 'numeric' });
            }
        }, {
            data: 'keterangan',
        }, {
            data: 'pemasukan',
            render: (data, type, row) => {
                if (row.pemasukan) {
                    return `Rp. ${parseInt(row.pemasukan).toLocaleString('id-ID')}`;
                } else {
                    return ''
                }
            }
        }, {
            data: 'pengeluaran',
            render: (data, type, row) => {
                if (row.pengeluaran) {
                    return `Rp. ${parseInt(row.pengeluaran).toLocaleString('id-ID')}`;
                } else {
                    return ''
                }
            }
        }, {
            data: 'id',
            render: (data, type, row) => {
                let pemasukan = parseInt(row.pemasukan) || 0;
                let pengeluaran = parseInt(row.pengeluaran) || 0;

                saldoBerjalan += pemasukan - pengeluaran;
        
                return `Rp. ${saldoBerjalan.toLocaleString('id-ID')}`;
            },
            className: 'text-right align-top'
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