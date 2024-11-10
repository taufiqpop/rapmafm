<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumentasi AFEL</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }

        .page-break {
            page-break-after: always;
        }

        .image-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin: 20px 0;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
            padding: 5px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 45%;
        }
    </style>
</head>

<body>
    @foreach ($dokumentasi as $index => $image)
        @if ($index > 0 && $index % 4 === 0)
            <div class="page-break"></div>
        @endif
        <div class="image-container">
            <img src="{{ public_path('storage/' . $image->path_file) }}" alt="User Image">
        </div>
    @endforeach
</body>

</html>
