<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Atribut harus diterima.',
    'active_url' => ' :attribute bukan URL yang valid.',
    'after' => ' :attribute harus berupa tanggal setelah :date.',
    'after_or_equal' => ' :attribute harus berupa tanggal setelah atau sama dengan :date.',
    'alpha' => ':attribute hanya boleh berisi huruf.',
    'alpha_dash' => ':attribute hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
    'alpha_num' => ':attribute hanya boleh berisi huruf dan angka.',
    'array' => ' :attribute harus berupa array.',
    'before' => ' :attribute harus berupa tanggal sebelum :date.',
    'before_or_equal' => ' :attribute harus tanggal sebelum atau sama dengan :date.',
    'between' => [
        'numeric' => ' :atribut harus antara :min dan :max.',
        'file' => ' :attribute harus antara :min dan :max kilobytes.',
        'string' => ' :attribute harus antara :min dan :max karakter.',
        'array' => 'Item :attribute harus antara :min dan :max item.',
    ],
    'boolean' => 'Bidang :attribute harus benar atau salah.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'date' => ':attribute bukan tanggal yang valid.',
    'date_equals' => ' :attribute harus berupa tanggal yang sama dengan :date.',
    'date_format' => ' :attribute tidak cocok dengan format :format.',
    'different' => ':attribute dan :other harus berbeda.',
    'digits' => ':attribute harus :digits digits.',
    'digits_between' => ' :attribute harus antara :min dan :max digit.',
    'dimensions' => ' :attribute memiliki dimensi gambar yang tidak valid.',
    'distinct' => 'Bidang :attribute memiliki nilai duplikat.',
    'email' => ' :attribute harus berupa alamat email yang valid.',
    'ends_with' => ' :attribute harus diakhiri dengan salah satu dari berikut ini: :values.',
    'exists' => ' :atribut yang dipilih tidak valid.',
    'file' => ':attribute harus berupa file.',
    'filled' => 'Bidang :attribute harus memiliki nilai.',
    'gt' => [
        'numeric' => ':attribute harus lebih besar dari :value.',
        'file' => ' :attribute harus lebih besar dari :value kilobytes.',
        'string' => ' :attribute harus lebih besar dari :value karakter.',
        'array' => ':attribute harus memiliki lebih dari :value item.',
    ],
    'gte' => [
        'numeric' => ' :atribut harus lebih besar dari atau sama dengan :value.',
        'file' => ':attribute harus lebih besar dari atau sama dengan :value kilobytes.',
        'string' => 'Karakter :attribute harus lebih besar dari atau sama dengan :value.',
        'array' => ':attribute harus memiliki :value item atau lebih.',
    ],
    'image' => ':attribute harus berupa gambar.',
    'in' => ' :atribut yang dipilih tidak valid.',
    'in_array' => 'Bidang :attribute tidak ada di :other.',
    'integer' => ' :attribute harus berupa bilangan bulat.',
    'ip' => ' :attribute harus berupa alamat IP yang valid.',
    'ipv4' => ' :attribute harus berupa alamat IPv4 yang valid.',
    'ipv6' => ' :attribute harus berupa alamat IPv6 yang valid.',
    'json' => ' :attribute harus berupa string JSON yang valid.',
    'lt' => [
        'numeric' => ':attribute harus lebih kecil dari :value.',
        'file' => ' :attribute harus kurang dari :value kilobytes.',
        'string' => ':attribute harus kurang dari :value karakter.',
        'array' => ':attribute harus memiliki kurang dari :value item.',
    ],
    'lte' => [
        'numeric' => ' :attribute harus kurang dari atau sama dengan :value.',
        'file' => ' :attribute harus kurang dari atau sama dengan :value kilobytes.',
        'string' => ' :attribute harus kurang dari atau sama dengan :value karakter.',
        'array' => ':attribute tidak boleh memiliki lebih dari :value item.',
    ],
    'max' => [
        'numeric' => ' :atribut tidak boleh lebih besar dari :max.',
        'file' => ' :attribute tidak boleh lebih besar dari :max kilobytes.',
        'string' => ' :attribute tidak boleh lebih besar dari :max karakter.',
        'array' => ':attribute mungkin tidak memiliki lebih dari :max item.',
    ],
    'mimes' => ':attribute harus berupa file dengan tipe: :values.',
    'mimetypes' => ':attribute harus berupa file dengan tipe: :values.',
    'min' => [
        'numeric' => ' :atribut harus minimal :min.',
        'file' => ' :attribute setidaknya harus :min kilobytes.',
        'string' => ' :attribute setidaknya harus :min karakter.',
        'array' => ':attribute harus memiliki setidaknya :min item.',
    ],
    'not_in' => ' :atribut yang dipilih tidak valid.',
    'not_regex' => 'Format :atribut tidak valid.',
    'numeric' => ':attribute harus berupa angka.',
    'password' => 'Kata sandi salah.',
    'present' => 'Bidang :attribute harus ada.',
    'regex' => 'Format :atribut tidak valid.',
    'required' => 'Bidang :attribute wajib diisi.',
    'required_if' => 'Bidang :attribute diperlukan ketika :other adalah :value.',
    'required_unless' => 'Bidang :attribute wajib diisi kecuali :other ada di :values.',
    'required_with' => 'Bidang :attribute diperlukan bila :nilai ada.',
    'required_with_all' => 'Bidang :attribute diperlukan bila :nilai ada.',
    'required_without' => 'Bidang :attribute diperlukan bila :nilai tidak ada.',
    'required_without_all' => 'Bidang :attribute diperlukan bila tidak ada :nilai yang ada.',
    'same' => ':attribute dan :other harus cocok.',
    'size' => [
        'numeric' => ' :atribut harus :size.',
        'file' => ' :attribute harus :size kilobytes.',
        'string' => ' :attribute harus berupa :size karakter.',
        'array' => ':attribute harus berisi :size item.',
    ],
    'starts_with' => ' :attribute harus dimulai dengan salah satu dari berikut ini: :values.',
    'string' => ' :attribute harus berupa string.',
    'timezone' => ' :attribute harus berupa zona yang valid.',
    'unique' => ':attribute sudah diambil.',
    'uploaded' => ' :atribut gagal diunggah.',
    'url' => 'Format :atribut tidak valid.',
    'uuid' => ' :attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
