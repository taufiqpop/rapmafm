let table;
$(() => {
    // Select2
    $('.select2').select2({
        width: '100%'
    });

    // Delete
    $('#table-data').on('click', '.btn-delete', function () {
        let data = table.row($(this).closest('tr')).data();

        let { id, judul } = data;

        Swal.fire({
            title: 'Anda yakin?',
            html: `Anda akan menghapus podcast "<b>${judul}</b>"!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(BASE_URL + 'podcast/delete', {
                    id,
                    _method: 'DELETE'
                }).done((res) => {
                    showSuccessToastr('Sukses', 'Podcast berhasil dihapus');
                    table.ajax.reload();
                }).fail((res) => {
                    let { status, responseJSON } = res;
                    showErrorToastr('oops', responseJSON.message);
                })
            }
        })
    })

    // Update
    $('#form-podcast-update').on('submit', function (e) {
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
                $('#modal-podcast-update').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-podcast-update').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-podcast-update').modal('hide');

                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil disimpan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: ({ status, responseJSON }) => {
                $('#modal-podcast-update').find('.modal-dialog').LoadingOverlay('hide', true);

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
        $('#form-podcast-update')[0].reset();

        $.each(data, (key, value) => {
            $('#update-' + key).val(value);
        })

        $('#modal-podcast-update').modal('show');
    })

    // Create
    $('#form-podcast').on('submit', function (e) {
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
                $('#modal-podcast').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-podcast').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-podcast').modal('hide');

                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil disimpan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: ({ status, responseJSON }) => {
                $('#modal-podcast').find('.modal-dialog').LoadingOverlay('hide', true);

                if (status == 422) {
                    generateErrorMessage(responseJSON);
                    return false;
                }

                showErrorToastr('oops', responseJSON.msg)
            }
        })
    })

    $('.btn-tambah').on('click', function () {
        $('#form-podcast')[0].reset();
        clearErrorMessage();

        $('#modal-podcast').modal('show');
    });

    // List
    table = $('#table-data').DataTable({
        processing: true,
        serverSide: true,
        language: dtLang,
        ajax: {
            url: BASE_URL + 'podcast/data',
            type: 'get',
            dataType: 'json'
        },
        order: [[4, 'desc']],
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
            data: 'program_siar.jenis_program.jenis',
        }, {
            data: 'program_siar.nama',
        }, {
            data: 'judul',
        }, {
            data: 'tanggal',
            render: function (data, type, row) {
                return formatTanggalIndonesia(data);
            }
        }, {
            data: 'encrypted_id',
            render: (data, type, row) => {
                const button_link = $('<a>', {
                    style: 'color: white',
                    class: 'btn btn-success btn-link',
                    html: '<i class="bx bxl-spotify"></i>',
                    'data-id': data,
                    title: 'Link Podcast',
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

    // Get Program Siar
    $('#jenis_program_id').on('change', function () {
        let jenisProgramId = $(this).val();
        if (jenisProgramId) {
            $.ajax({
                url: BASE_URL + 'program-siar/getProgramSiar/' + jenisProgramId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#program_id').empty();
                    $('#program_id').append('<option value="" selected disabled>Pilih Program Siar</option>');
                    $.each(data, function(key, value) {
                        $('#program_id').append('<option value="' + value.id + '">' + value.nama + '</option>');
                    });
                }
            });
        } else {
            $('#program_id').empty();
            $('#program_id').append('<option value="" selected disabled>Pilih Program Siar</option>');
        }
    });

    // Get Program Siar Update
    $('#update-jenis_program_id').on('change', function () {
        let jenisProgramId = $(this).val();
        if (jenisProgramId) {
            $.ajax({
                url: BASE_URL + 'program-siar/getProgramSiar/' + jenisProgramId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#update-program_id').empty();
                    $('#update-program_id').append('<option value="" selected disabled>Pilih Program Siar</option>');
                    $.each(data, function(key, value) {
                        $('#update-program_id').append('<option value="' + value.id + '">' + value.nama + '</option>');
                    });
                }
            });
        } else {
            $('#update-program_id').empty();
            $('#update-program_id').append('<option value="" selected disabled>Pilih Program Siar</option>');
        }
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