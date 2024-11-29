let table;
let updateMap;
let createMap;
let drawnItemsUpdate;
let drawnItemsCreate;

$(() => {
    // Delete
    $('#table-data').on('click', '.btn-delete', function () {
        let data = table.row($(this).closest('tr')).data();

        let { id, tanggal } = data;
        let tglFormatted = formatTanggalIndonesia(tanggal)

        Swal.fire({
            title: 'Anda yakin?',
            html: `Anda akan menghapus data hari "<b>${tglFormatted}</b>"!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(BASE_URL + 'pemancar/delete', {
                    id,
                    _method: 'DELETE'
                }).done((res) => {
                    showSuccessToastr('Sukses', 'Pemancar berhasil dihapus');
                    table.ajax.reload();
                }).fail((res) => {
                    let { status, responseJSON } = res;
                    showErrorToastr('oops', responseJSON.message);
                })
            }
        })
    })

    // Create
    $('#form-pemancar').on('submit', function (e) {
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
                $('#modal-pemancar').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-pemancar').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-pemancar').modal('hide');
                
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil disimpan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: ({ status, responseJSON }) => {
                $('#modal-pemancar').find('.modal-dialog').LoadingOverlay('hide', true);

                if (status == 422) {
                    generateErrorMessage(responseJSON);
                    return false;
                }

                showErrorToastr('oops', responseJSON.msg)
            }
        })
    })

    $('.btn-tambah').on('click', function () {
        $('#form-pemancar')[0].reset();
        clearErrorMessage();
        $('#modal-pemancar').modal('show');
    });

    $('#modal-pemancar').on('shown.bs.modal', function () {
        initializeMapCreate();
    });

    // Update
    $('#form-pemancar-update').on('submit', function (e) {
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
                $('#modal-pemancar-update').find('.modal-dialog').LoadingOverlay('show');
            },
            success: (res) => {
                $('#modal-pemancar-update').find('.modal-dialog').LoadingOverlay('hide', true);
                $(this)[0].reset();
                clearErrorMessage();
                table.ajax.reload();
                $('#modal-pemancar-update').modal('hide');
                
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil disimpan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: ({ status, responseJSON }) => {
                $('#modal-pemancar-update').find('.modal-dialog').LoadingOverlay('hide', true);

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
        $('#form-pemancar-update')[0].reset();

        $.each(data, (key, value) => {
            $('#update-' + key).val(value);
        })

        $('#modal-pemancar-update').modal('show');
    })

    $('#modal-pemancar-update').on('shown.bs.modal', function () {
        initializeMapUpdate();
    });

    // List
    table = $('#table-data').DataTable({
        processing: true,
        serverSide: true,
        language: dtLang,
        ajax: {
            url: BASE_URL + 'pemancar/data',
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
            targets: [1, 2],
            className: 'text-left align-top'
        }, {
            targets: [-1],
            visible: false,
        }],
        columns: [{
            data: 'DT_RowIndex'
        }, {
            data: 'tanggal',
            render: (data, type, row) => {
                return formatTanggalIndonesia(data);
            }
        }, {
            data: 'coordinate_type',
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

// Get Array Depth
function getArrayDepth(array) {
    if (Array.isArray(array)) {
        return 1 + Math.max(0, ...array.map(getArrayDepth));
    } else {
        return 0;
    }
}

// Clear Coordinates
function clearCoordinates() {
    $("[name=coordinates]").val('');

    if (drawnItemsUpdate) {
        drawnItemsUpdate.clearLayers();
    }
}

// Coordinates Create
function initializeMapCreate() {
    if (createMap) {
        createMap.remove();
    }

    let initialLatLng = [-7.577, 110.825];
    createMap = L.map('create-map').setView(initialLatLng, 15);

    L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(createMap);

    drawnItemsCreate = new L.FeatureGroup();
    createMap.addLayer(drawnItemsCreate);

    let drawControl = new L.Control.Draw({
        draw: {
            polyline: false,
            rectangle: false,
            circle: false,
            marker: false,
            circlemarker: false,
        },
        edit: {
            featureGroup: drawnItemsCreate
        }
    });

    createMap.addControl(drawControl);

    createMap.on(L.Draw.Event.CREATED, function (event) {
        let layer = event.layer;
        drawnItemsCreate.addLayer(layer);
        savePolygonCoordinates();
    });

    createMap.on(L.Draw.Event.EDITED, function () {
        savePolygonCoordinates();
    });

    function savePolygonCoordinates() {
        let coordinatesToSave = [];
        drawnItemsCreate.eachLayer(function (layer) {
            if (layer instanceof L.Polygon) {
                let latLngs = layer.getLatLngs()[0].map(latLng => [latLng.lng, latLng.lat]);
                coordinatesToSave.push(latLngs);
            }
        });

        $("[name=coordinates]").val(JSON.stringify(coordinatesToSave));
    }
}

// Coordinates Update
function initializeMapUpdate() {
    if (updateMap) {
        updateMap.remove();
    }

    let coordinates = $("[name=coordinates]").val();
    let initialLatLng = [-7.577, 110.825];
    let bounds;

    try {
        if (coordinates) {
            let parsedCoordinates = JSON.parse(coordinates);
            if(getArrayDepth(parsedCoordinates)==4) parsedCoordinates = parsedCoordinates[0];
            if (parsedCoordinates.length > 0) {
                let latLngList = parsedCoordinates.flat().map(coords => [coords[1], coords[0]]);
                bounds = L.latLngBounds(latLngList);
                initialLatLng = bounds.getCenter();
            }
        }
    } catch (error) {
        console.error("Failed to parse coordinates:", error);
    }

    updateMap = L.map('update-map').setView(initialLatLng, 15);

    L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(updateMap);

    drawnItemsUpdate = new L.FeatureGroup();
    updateMap.addLayer(drawnItemsUpdate);

    if (bounds) {
        updateMap.fitBounds(bounds);
    }

    if (coordinates) {
        try {
            drawnItemsUpdate.clearLayers();
            let parsedPolygons = JSON.parse(coordinates);
            if(getArrayDepth(parsedPolygons)==4) parsedPolygons = parsedPolygons[0];
            parsedPolygons.forEach(polygonCoords => {
                let latLngList = polygonCoords.map(coords => [coords[1], coords[0]]);
                L.polygon(latLngList, { color: 'red' }).addTo(drawnItemsUpdate);
            });
        } catch (error) {
            console.error("Failed to parse coordinates for polygons:", error);
        }
    }

    let drawControl = new L.Control.Draw({
        draw: {
            polyline: false,
            rectangle: false,
            circle: false,
            marker: false,
            circlemarker: false,
        },
        edit: {
            featureGroup: drawnItemsUpdate
        }
    });

    updateMap.addControl(drawControl);

    updateMap.on(L.Draw.Event.CREATED, function (event) {
        let layer = event.layer;
        drawnItemsUpdate.addLayer(layer);
        savePolygonCoordinates(drawnItemsUpdate);
    });

    updateMap.on(L.Draw.Event.EDITED, function () {
        savePolygonCoordinates(drawnItemsUpdate);
    });

    updateMap.on(L.Draw.Event.DELETED, function () {
        savePolygonCoordinates(drawnItemsUpdate);
    });
}

function savePolygonCoordinates(drawnItemsCreate) {
    let coordinatesToSave = [];
    drawnItemsCreate.eachLayer(function (layer) {
        if (layer instanceof L.Polygon) {
            let latLngs = layer.getLatLngs()[0].map(latLng => [latLng.lng, latLng.lat]);
            coordinatesToSave.push(latLngs);
        }
    });
    $("[name=coordinates]").val(JSON.stringify(coordinatesToSave));
}