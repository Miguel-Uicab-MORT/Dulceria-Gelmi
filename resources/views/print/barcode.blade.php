<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<head>

    <title>{{ config('app.name', 'Códigos de barras') }}</title>

    <style>
        .grid-container {
            display: grid;
            grid-template-columns: auto auto auto auto;
            gap: 10px;
            padding: 5px;
        }

        .grid-container>div {
            border: 1px solid black;
            text-align: center;
            font-size: 20px;
        }

    </style>
</head>

<body>
    <div class="grid-container">
        @foreach ($productos as $producto)
            <div>
                <h4>
                    {{ $producto->name }}
                </h4>
                <div style="text-align: center;">
                    {!! DNS1D::getBarcodeHTML($producto->barcode, 'EAN8') !!}
                </div>
            </div>
        @endforeach
    </div>
</body>

</html>
