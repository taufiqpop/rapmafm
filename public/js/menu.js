$(() => {
    loadMenu();
})
const loadMenu = async () => {
    await new Promise(resolve => setTimeout(resolve, 160)); //beri delay 0,16 detik agar tidak error unauthorized
    $.get(BASE_URL + 'menus').done(({ data }) => {
        let container = $('#side-menu');
        container.empty();

        generateMenu(data, container, true);

        $('#side-menu').metisMenu('dispose');
        $('#side-menu').metisMenu();
    }).fail((res) => {
        showErrorToastr('Oops', 'Terjadi kesalahaan saat mengakses daftar menu!');
    })
}

const generateMenu = (data, container, is_parent = true) => {

    // get the base URL
    var baseURL = window.location.protocol + "//" + window.location.host;
    // remove any parameters
    var cleanURL = baseURL + window.location.pathname;

    const MENU_OPEN = cleanURL.split(BASE_URL)[1];

    for (const menu of data) {

        let { id, name, link: route, icon, child, encode_id } = menu;
        if (is_parent) {
            if (child.length > 0) {
                let label = $('<span>', {
                    key: 't-' + name,
                    text: name
                });

                let menu_icon = $('<i>', {
                    class: icon
                });

                let a = $('<a>', {
                    href: "javascript: void(0);",
                    class: 'has-arrow waves-effect',
                    html: [menu_icon, label]
                });

                let sub = $('<ul>', {
                    class: 'sub-menu sub-' + encode_id,
                    'aria-expanded': false,
                });

                container.append($('<li>', {
                    // class: route.includes(MENU_OPEN) ? 'mm-active' : '',
                    html: [a, sub],
                }).prop('outerHTML'));

                generateMenu(child, $('.sub-' + encode_id), false);
            } else {
                let label = $('<span>', {
                    text: name,
                    key: 't-' + name,
                });

                let menu_icon = $('<i>', {
                    class: icon
                });

                let a = $('<a>', {
                    href: BASE_URL + route,
                    html: [menu_icon, label]
                });

                container.append($('<li>', {
                    class: route == MENU_OPEN ? 'mm-active' : '',
                    html: [a],
                }).prop('outerHTML'));
            }
        } else {
            let li = $('<li>', {
                class: route == MENU_OPEN ? 'mm-active' : '',
                html: $('<a>', {
                    href: BASE_URL + route,
                    text: name
                })
            })

            container.append(li.prop('outerHTML'));
        }

    }
}