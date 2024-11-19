let table;
$(() => {
    // Select2
    $('.select2').select2({
        width: '100%'
    });
    
    // Delete
    $('#table-data').on('click', '.btn-delete', function () {
        let data = table.row($(this).closest('tr')).data();

        let { id } = data;

        Swal.fire({
            title: 'Anda yakin?',
            html: `Anda akan menghapus program siar "<b>${data.program_siar.nama}</b>"!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(BASE_URL + 'program-siar/delete', {
                    id,
                    _method: 'DELETE'
                }).done((res) => {
                    showSuccessToastr('Sukses', 'Program Siar berhasil dihapus');
                    table.ajax.reload();
                }).fail((res) => {
                    let { status, responseJSON } = res;
                    showErrorToastr('oops', responseJSON.message);
                })
            }
        })
    })

    // Update
    $('#form-program-siar-update').on('submit', function (e) {
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
                $('#modal-program-siar-update').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-program-siar-update').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-program-siar-update').modal('hide');

                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil disimpan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: ({ status, responseJSON }) => {
                $('#modal-program-siar-update').find('.modal-dialog').LoadingOverlay('hide', true);

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
        $('#form-program-siar-update')[0].reset();

        $('.images-preview').attr('src', '').hide();
        $('.images').val('');

        $.each(data, (key, value) => {
            $('#update-' + key).val(value).trigger('change');
        })

        if (data.jenis_program_id) {
            $.ajax({
                url: BASE_URL + 'program-siar/getProgramSiar/' + data.jenis_program_id,
                type: 'GET',
                dataType: 'json',
                success: function (programs) {
                    $('#update-program_id').empty();
                    $('#update-program_id').append('<option value="" selected disabled>Pilih Program Siar</option>');
                    $.each(programs, function (key, program) {
                        let selected = program.id == data.program_id ? 'selected' : '';
                        $('#update-program_id').append(`<option value="${program.id}" ${selected}>${program.nama}</option>`);
                    });
                }
            });
        }
        
        $('#modal-program-siar-update').modal('show');
    })

    // Create
    $('#form-program-siar').on('submit', function (e) {
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
                $('#modal-program-siar').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-program-siar').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-program-siar').modal('hide');

                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil disimpan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: ({ status, responseJSON }) => {
                $('#modal-program-siar').find('.modal-dialog').LoadingOverlay('hide', true);

                if (status == 422) {
                    generateErrorMessage(responseJSON);
                    return false;
                }

                showErrorToastr('oops', responseJSON.msg)
            }
        })
    })

    $('.btn-tambah').on('click', function () {
        $('#form-program-siar')[0].reset();
        clearErrorMessage();

        $('.images-preview').attr('src', '').hide();
        $('.images').val('');

        $('#modal-program-siar').modal('show');
    });

    // List
    table = $('#table-data').DataTable({
        processing: true,
        serverSide: true,
        language: dtLang,
        ajax: {
            url: BASE_URL + 'program-siar/data',
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
            targets: [1, 2, 3],
            className: 'text-left align-top'
        }, {
            targets: [4, 5, 6],
            className: 'text-center align-top'
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
                    class: 'btn btn-success btn-link',
                    html: '<i class="fab fa-spotify"></i>',
                    'data-id': data,
                    title: 'Link Spotify',
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

        $.post(BASE_URL + 'program-siar/switch', {
            id,
            value,
            _method: 'PATCH'
        }).done((res) => {
            showSuccessToastr('sukses', value == '1' ? 'Program Siar berhasil diaktifkan' : 'Program Siar berhasil dinonaktifkan');
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
    $('#modal-program-siar').on('hidden.bs.modal', function () {
        $('.images').val('');
        $('.images-preview').attr('src', '').hide();
    });

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
})