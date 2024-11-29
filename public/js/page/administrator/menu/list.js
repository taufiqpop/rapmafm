let table;
$(() => {
    $('#table-data').on('click', '.btn-delete', function () {
        let data = table.row($(this).closest('tr')).data();

        let { id, name } = data;

        Swal.fire({
            title: 'Anda yakin?',
            html: `Anda akan menghapus menu "<b>${name}</b>"!`,
            footer: 'Data yang sudah dihapus tidak bisa dikembalikan kembali!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(BASE_URL + 'manajemen-menu/delete', {
                    id,
                    _method: 'DELETE'
                }).done((res) => {
                    showSuccessToastr('sukses', 'Menu berhasil dihapus');
                    table.ajax.reload();
                }).fail((res) => {
                    let { status, responseJSON } = res;
                    showErrorToastr('oops', responseJSON.message);
                })
            }
        })
    })

    $('#form-update-menu').on('submit', function (e) {
        e.preventDefault();

        var data = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: data,
            dataType: 'json',
            contentType: false,
            processData: false,
            beforeSend: () => {
                clearErrorMessage();
                $('#modal-update-menu').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-update-menu').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-update-menu').modal('hide');
            },
            error: ({ status, responseJSON }) => {
                $('#modal-update-menu').find('.modal-dialog').LoadingOverlay('hide', true);

                if (status == 422) {
                    generateErrorMessage(responseJSON, true);
                    return false;
                }

                showErrorToastr('oops', responseJSON.msg)
            }
        })
    })

    $('#table-data').on('click', '.btn-update', function () {
        let data = table.row($(this).closest('tr')).data();

        $('#form-update-menu')[0].reset();
        clearErrorMessage();

        let { id, name, link, menu_type, icon, parent_id } = data;

        $('#update-id').val(id);
        $('#update-name').val(name);
        $('#update-link').val(link);
        switch (menu_type) {
            case 'main':
                $('#type-update-main').prop('checked', true);
                $('input[name=menu_type]').trigger('change');
                break;
            case 'child':
                $('#type-update-child').prop('checked', true);
                $('input[name=menu_type]').trigger('change');
                break;

            default:
                break;
        }
        $('#update-icon').val(icon);
        getMainMenu('#update-parent_id', parent_id);

        $('#modal-update-menu').modal('show');
    })

    $('#form-menu').on('submit', function (e) {
        e.preventDefault();

        var data = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: data,
            dataType: 'json',
            contentType: false,
            processData: false,
            beforeSend: () => {
                clearErrorMessage();
                $('#modal-menu').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-menu').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-menu').modal('hide');
            },
            error: ({ status, responseJSON }) => {
                $('#modal-menu').find('.modal-dialog').LoadingOverlay('hide', true);

                if (status == 422) {
                    generateErrorMessage(responseJSON);
                    return false;
                }

                showErrorToastr('oops', responseJSON.msg)
            }
        })
    })

    $('.pilih-icon').on('click', function () {
        var icon_name = $(this).data('icon_name');

        $('input[name=icon]').val(icon_name);
    })

    $('.table-icons').DataTable({
        language: dtLang,
        info: false,
        pageLength: 5,
    });

    $('input[name=menu_type]').on('change', function () {
        var val = $('input[name=menu_type]:checked').val();

        $('.div-menu-type').hide();
        switch (val) {
            case 'main':
                $('select[name=parent_id]').val('').trigger('change');
                break;

            case 'child':
                $('input[name=icon]').val('');
                break;

            default:
                break;
        }
        $('.div-' + val).fadeIn();
    })

    $('.btn-tambah').on('click', function () {
        $('#form-menu')[0].reset();
        clearErrorMessage();
        getMainMenu('#parent_id');
        $('#modal-menu').modal('show');
    });

    table = $('#table-data').DataTable({
        language: dtLang,
        serverSide: true,
        processing: true,
        ajax: {
            url: BASE_URL + 'manajemen-menu/data',
            type: 'get',
            dataType: 'json'
        },
        order: [[6, 'desc']],
        columnDefs: [{
            targets: [0, 5],
            orderable: false,
            searchable: false,
            className: 'text-center align-top'
        }, {
            targets: [1, 2],
            className: 'text-left align-top',
        }, {
            targets: [3, 4],
            className: 'text-center align-top',
        }, {
            targets: [6],
            visible: false,
        }],
        columns: [{
            data: 'DT_RowIndex'
        }, {
            data: 'name',
            render: (data, type, row) => {
                return data
                    + '<br>'
                    + `<span class="badge badge-primary">Kode RBAC : ${row.slug_name}</span>`;
            }
        }, {
            data: 'parent_id',
            render: (data, type, row) => {
                if (data === null) return 'Menu Utama';

                return row.parent.name;
            }
        }, {
            data: 'icon',
            render: (data) => {
                if (data == null) return '-';
                return $('<i>', {
                    class: data + ' fa-2x text-primary'
                }).prop('outerHTML') + ' ' + data
            }
        }, {
            data: 'link',
            render: (data, type, { full_link }) => {
                return full_link;
            }
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
                        if (permissions.delete) arr.push(button_delete)

                        return arr;
                    }
                }).prop('outerHTML');
            }
        }, {
            data: 'created_at'
        }]
    });
})

const getMainMenu = (selector, selected = null) => {
    $.get(BASE_URL + 'manajemen-menu/get/main-menu').done(({ data }) => {
        let container = $(selector);

        container.empty();
        container.append('<option value="" selected disabled>Pilih Menu Utama</option>')
        for (const item of data) {
            container.append(`<option value="${item.id}">${item.text}</option>`)
        }

        if (selected !== null) {
            container.val(selected).trigger('change');
        }
    }).fail(({ status, responseJSON }) => {
        console.log(responseJSON);
    })
}