let table;
$(() => {
    // Delete
    $('#table-data').on('click', '.btn-delete', function () {
        let data = table.row($(this).closest('tr')).data();

        let { id, barang } = data;

        Swal.fire({
            title: 'Anda yakin?',
            html: `Anda akan menghapus peminjaman "<b>${barang}</b>"!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(BASE_URL + 'peminjaman/delete', {
                    id,
                    _method: 'DELETE'
                }).done((res) => {
                    showSuccessToastr('Sukses', 'Peminjaman berhasil dihapus');
                    table.ajax.reload();
                }).fail((res) => {
                    let { status, responseJSON } = res;
                    showErrorToastr('oops', responseJSON.message);
                })
            }
        })
    })

    // Update
    $('#form-peminjaman-update').on('submit', function (e) {
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
                $('#modal-peminjaman-update').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-peminjaman-update').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-peminjaman-update').modal('hide');
                
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil disimpan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: ({ status, responseJSON }) => {
                $('#modal-peminjaman-update').find('.modal-dialog').LoadingOverlay('hide', true);

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
        $('#form-peminjaman-update')[0].reset();

        $.each(data, (key, value) => {
            $('#update-' + key).val(value);
        })

        const feeValue = data.fee;
        if (feeValue) {
            const formattedFee = formatToRupiah(feeValue);
            $('#update-fee').val(formattedFee);
            $('#update-fee-hidden').val(feeValue);
        }

        $('#modal-peminjaman-update').modal('show');
    })

    // Create
    $('#form-peminjaman').on('submit', function (e) {
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
                $('#modal-peminjaman').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-peminjaman').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-peminjaman').modal('hide');
                
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil disimpan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: ({ status, responseJSON }) => {
                $('#modal-peminjaman').find('.modal-dialog').LoadingOverlay('hide', true);

                if (status == 422) {
                    generateErrorMessage(responseJSON);
                    return false;
                }

                showErrorToastr('oops', responseJSON.msg)
            }
        })
    })

    $('.btn-tambah').on('click', function () {
        $('#form-peminjaman')[0].reset();
        clearErrorMessage();
        $('#modal-peminjaman').modal('show');
    });

    // List
    table = $('#table-data').DataTable({
        processing: true,
        serverSide: true,
        language: dtLang,
        ajax: {
            url: BASE_URL + 'peminjaman/data',
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
            targets: [1, 2, 3, 4, 5],
            className: 'text-left align-top'
        }, {
            targets: [-1],
            visible: false,
        }],
        columns: [{
            data: 'DT_RowIndex'
        }, {
            data: 'barang',
            render: function(data, type, row) {
                return `Nama : ${data}<br>Jumlah : ${row.jumlah}`
            }
        }, {
            data: 'nama_peminjam',
            render: function(data, type, row) {
                return `Nama : ${data}<br>Asal : ${row.asal_peminjam}`
            }
        }, {
            data: 'tgl_pinjam',
            render: function(data, type, row) {
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const locale = 'id-ID';
                
                const tglPinjam = row.tgl_pinjam 
                    ? new Date(row.tgl_pinjam).toLocaleDateString(locale, options) 
                    : '-';
        
                const tglKembali = row.tgl_kembali 
                    ? new Date(row.tgl_kembali).toLocaleDateString(locale, options) 
                    : '-';
        
                return `Pinjam : ${tglPinjam}<br>Kembali : ${tglKembali}`;
            }
        }, {
            data: 'fee',
            render: function(data, type, row) {
                if (data == null) return '-';
                
                return new Intl.NumberFormat('id-ID', { 
                    style: 'currency', 
                    currency: 'IDR' 
                }).format(data);
            }
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

    // Fee Format
    const feeInput = $('#fee');
    const hiddenInput = $('#fee-hidden');
    const feeInputUpdate = $('#update-fee');
    const hiddenInputUpdate = $('#update-fee-hidden');

    function formatToRupiah(value) {
        if (!value) return '';
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(value);
    }

    function removeRupiahFormat(value) {
        return parseInt(value.replace(/[Rp,.]/g, '') || 0);
    }

    feeInputUpdate.on('input', function () {
        const rawValue = removeRupiahFormat($(this).val());
        $(this).val(formatToRupiah(rawValue));
        hiddenInputUpdate.val(rawValue);
    });

    feeInput.on('input', function () {
        const rawValue = removeRupiahFormat($(this).val());
        $(this).val(formatToRupiah(rawValue));
        hiddenInput.val(rawValue);
    });
})