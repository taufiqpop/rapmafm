@extends('layouts.app')

@php
    $plugins = ['datatable', 'swal', 'select2'];
@endphp

@section('contents')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="mb-4">Data Penyiar Saat Ini</h3>
                    <div class="row">
                        {{-- Jenis Program --}}
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="jenis_program_id" class="form-label">Jenis Program</label>
                                <select name="jenis_program_id" id="jenis_program_id" class="form-control select2"
                                    data-tabel="settings" data-id="{{ $penyiar->id }}" data-kolom="jenis_program_id"
                                    onchange="update_custom(this)">
                                    <option value="" selected disabled>Pilih Jenis Program</option>
                                    @foreach ($jenisProgram as $jenis)
                                        <option value="{{ $jenis->id }}"
                                            {{ $jenis->id == $penyiar->jenis_program_id ? 'selected' : '' }}>
                                            {{ $jenis->jenis }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Program Siar --}}
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="program_id" class="form-label">Program Siar</label>
                                <select name="program_id" id="program_id" class="form-control select2" data-tabel="settings"
                                    data-id="{{ $penyiar->id }}" data-kolom="program_id" onchange="update_custom(this)">
                                    <option value="" selected disabled>Pilih Program Siar</option>
                                    @foreach ($programSiar as $program)
                                        <option value="{{ $program->id }}"
                                            {{ $program->id == $penyiar->program_id ? 'selected' : '' }}>
                                            {{ $program->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Penyiar 1 --}}
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="penyiar1" class="form-label">Penyiar 1</label>
                                <input type="text" class="form-control" name="penyiar1" data-tabel="settings"
                                    data-id="{{ $penyiar->id }}" data-kolom="penyiar1" placeholder="Masukkan Penyiar 1"
                                    onchange="update_custom(this)" value="{{ $penyiar->penyiar1 }}">
                                <small style="color: red">*Jika Hanya Satu Penyiar, Isi Penyiar 1 Saja</small>
                            </div>
                        </div>

                        {{-- Penyiar 2 --}}
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="penyiar2" class="form-label">Penyiar 2</label>
                                <input type="text" class="form-control" name="penyiar2" data-tabel="settings"
                                    data-id="{{ $penyiar->id }}" data-kolom="penyiar2" placeholder="Masukkan Penyiar 2"
                                    onchange="update_custom(this)" value="{{ $penyiar->penyiar2 }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(() => {
            $('.select2').select2({
                width: '100%'
            });
        });

        function update_custom(ctx) {
            let id = $(ctx).data('id');
            let tabel = $(ctx).data('tabel');
            let kolom = $(ctx).data('kolom');
            let value = null;

            $.ajax({
                type: "POST",
                url: "{{ route('penyiar.update_custom') }}",
                data: {
                    id: id ?? '{{ $penyiar->id }}',
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

        // Get Program Siar
        $('#jenis_program_id').on('change', function() {
            let jenisProgramId = $(this).val();
            if (jenisProgramId) {
                $.ajax({
                    url: BASE_URL + 'penyiar/getProgramSiar/' + jenisProgramId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#program_id').empty();
                        $('#program_id').append(
                            '<option value="" selected disabled>Pilih Program Siar</option>');
                        $.each(data, function(key, value) {
                            $('#program_id').append('<option value="' + value.id + '">' + value
                                .nama + '</option>');
                        });
                    }
                });
            } else {
                $('#program_id').empty();
                $('#program_id').append('<option value="" selected disabled>Pilih Program Siar</option>');
            }
        });
    </script>
@endpush
