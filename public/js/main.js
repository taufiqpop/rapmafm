getMeta = (meta_name) => {
    var meta = $(`meta[name=${meta_name}]`);

    return meta.attr('content');
}

const dtLang = {
    processing: 'Memuat data',
    paginate: {
        first: '<<',
        previous: '<',
        next: '>',
        last: '>>'
    },
    lengthMenu: 'Menampilkan _MENU_ data',
    search: 'Pencarian: ',
    info: 'Menampilkan _START_ ke _END_ dari _TOTAL_ data',
    infoEmpty: 'Kosong',
    infoFiltered: '(Tersaring dari _MAX_ data)',
    emptyTable: 'Data kosong'
};

const makeId = (length) => {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() *
            charactersLength));
    }
    return result;
}

const number_format = (val) => {
    if (val != null) {
        val = val.toString().replace(/,/g, ''); //remove existing commas first
        var valSplit = val.split('.'); //then separate decimals

        while (/(\d+)(\d{3})/.test(valSplit[0].toString())) {
            valSplit[0] = valSplit[0].toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
        }

        if (valSplit.length == 2) { //if there were decimals
            val = valSplit[0] + "." + valSplit[1]; //add decimals back
        } else {
            val = valSplit[0];
        }

        return val;
    } else {
        return '-';
    }
}

(function ($) {
    $.fn.inputFilter = function (inputFilter) {
        return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function () {
            if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
                this.value = "";
            }
        });
    };
}(jQuery));

toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": 300,
    "hideDuration": 1000,
    "timeOut": 5000,
    "extendedTimeOut": 1000,
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

const showSuccessToastr = (title, mssg = null) => {
    toastr.success(mssg, title);
}

const showErrorToastr = (title, mssg = null) => {
    toastr.error(mssg, title);
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

const checkAccess = (access_name) => {
    let value = parseInt($(`input:hidden[name=${access_name}_access]`).val());

    if (value) return true;

    return false;
}

const generateErrorMessage = (res, is_update = false) => {
    for (const key in res.errors) {
        $('#' + key).addClass('is-invalid');

        if (Object.hasOwnProperty.call(res.errors, key)) {
            const element = res.errors[key];

            let error_container = $('#error-' + key);
            if (is_update) {
                error_container = $('#error-update-' + key);
            }

            error_container.empty();

            for (const item of element) {
                error_container.append($('<li>', {
                    class: 'text-danger',
                    text: item
                }).prop('outerHTML'))
            }
        }
    }
}

const clearErrorMessage = () => {
    $('.is-invalid').removeClass('is-invalid');
}

window.BASE_URL = getMeta('base_url');

const asset_url = getMeta('asset_url');
// const current_route = getMeta('current_url');
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

const getAccessStatus = (name) => {
    return (parseInt($("input[name=" + name + "]").val())) ? true : false;
}

$(() => {
    $('[data-toggle="tooltip"]').tooltip()

    window.permissions = {};
    $('.permission_status').each((i, el) => {
        let name = $(el).attr('name');
        let val = (parseInt($(el).val()) == 1) ? true : false;

        permissions[name] = val;
    })
})