let table;
$(() => {
    // Delete
    $('#table-data').on('click', '.btn-delete', function () {
        let data = table.row($(this).closest('tr')).data();

        let { id, nomor } = data;

        Swal.fire({
            title: 'Anda yakin?',
            html: `Anda akan menghapus surat "<b>${nomor}</b>"!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(BASE_URL + 'surat/delete', {
                    id,
                    _method: 'DELETE'
                }).done((res) => {
                    showSuccessToastr('Sukses', 'Surat berhasil dihapus');
                    table.ajax.reload();
                }).fail((res) => {
                    let { status, responseJSON } = res;
                    showErrorToastr('oops', responseJSON.message);
                })
            }
        })
    })

    // Update
    $('#form-surat-update').on('submit', function (e) {
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
                $('#modal-surat-update').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-surat-update').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-surat-update').modal('hide');
                
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil disimpan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: ({ status, responseJSON }) => {
                $('#modal-surat-update').find('.modal-dialog').LoadingOverlay('hide', true);

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
        $('#form-surat-update')[0].reset();

        $.each(data, (key, value) => {
            $('#update-' + key).val(value);
        })

        $('#modal-surat-update').modal('show');
    })

    // Create
    $('#form-surat').on('submit', function (e) {
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
                $('#modal-surat').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-surat').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-surat').modal('hide');
                
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil disimpan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: ({ status, responseJSON }) => {
                $('#modal-surat').find('.modal-dialog').LoadingOverlay('hide', true);

                if (status == 422) {
                    generateErrorMessage(responseJSON);
                    return false;
                }

                showErrorToastr('oops', responseJSON.msg)
            }
        })
    })

    $('.btn-tambah').on('click', function () {
        $('#form-surat')[0].reset();
        clearErrorMessage();
        $('#modal-surat').modal('show');
    });

    // List
    table = $('#table-data').DataTable({
        processing: true,
        serverSide: true,
        language: dtLang,
        ajax: {
            url: BASE_URL + 'surat/data',
            type: 'get',
            dataType: 'json',
            data: function (func) {
                func.perihal = $('#filter-perihal').val();
                func.tahun = $('#filter-tahun').val();
            }
        },
        order: [[7, 'desc']],
        columnDefs: [{
            targets: [0, -2],
            searchable: false,
            orderable: false,
            className: 'text-center align-top',
        }, {
            targets: [1, 2, 3, 4, 5],
            className: 'text-left align-top'
        }, {
            targets: [-1],
            visible: false,
        }],
        columns: [{
            data: 'DT_RowIndex'
        }, {
            data: 'perihal',
        }, {
            data: 'tanggal',
            render: (data, type, row) => {
                return formatTanggalIndonesia(data);
            }
        }, {
            data: 'asal_surat',
        }, {
            data: 'nomor',
        }, {
            data: 'keterangan',
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

    $('#filter-perihal').on('change', function () {
        $('#table-data').DataTable().ajax.reload();
    });

    $('#filter-tahun').on('change', function () {
        $('#table-data').DataTable().ajax.reload();
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
    
        return `${tanggal}`;
    }
})