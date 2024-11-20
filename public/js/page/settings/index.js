$(() => {
    function update_custom(ctx) {
        let id = $(ctx).data('id');
        let tabel = $(ctx).data('tabel');
        let kolom = $(ctx).data('kolom');
        let value = null;

        $.ajax({
            type: "POST",
            url: "{{ route('settings.update_custom') }}",
            data: {
                id: id,
                tabel: tabel,
                kolom: kolom ?? $(ctx).prop('name'),
                value: value ?? $(ctx).val(),
            },
            dataType: "JSON",
        }).then(res => {
            if (res.status) {
                toastr.success(res.message, 'Sukses')
                table.ajax.reload();
            }
        })
    }
})
