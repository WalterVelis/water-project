<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Registro de Mano de Obra</title>
    <style type="text/css">
        body {
            margin: 0px;
        }

        * {
            font-family: Verdana, Arial, sans-serif;
        }

        a {
            color: #fff;
            text-decoration: none;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .invoice table {
            margin: 15px;
        }

        .invoice h3 {
            margin-left: 15px;
        }

        .information {
            background-color: #bacfda;
            color: #FFF;
        }

        .information .logo {
            margin: 5px;
        }

        .information table {
            padding: 10px;
        }

        .table td {
            border: solid 1px #eee;
        }

        table {
            border-collapse: collapse;
            margin-left: 20px;
            margin-right: 20px;
        }

        th,
        td {
            padding: 4px 6px;
        }

    </style>
    <style>
        @page {
            margin: 180px 0px;
        }

        #header {
            position: fixed;
            left: 0px;
            top: -180px;
            right: 0px;
            height: 100px;
            background-color: #0b6696;
            text-align: center;
        }

        #footer {
            position: fixed;
            left: 0px;
            bottom: -180px;
            right: 0px;
            height: 50px;
            background-color: #0b6696;
        }

    </style>
</head>
<body>
    <div id="header">
        <div class="information">
            <table width="100%">
                <tr>
                    <td style="width: 20%;">
                        <img src="{{ public_path() }}/email/logo-bf.png" alt="Cotizador Agua H2O" width="64"
                            class="logo" />

                    </td>
                    <td align="center">
                        <h1 style="color:#0b6696">Registro de Mano de Obra</h1>
                    </td>
                    <td align="right" style="width: 20%;">
                    </td>
                </tr>

            </table>
        </div>
    </div>
    <div id="footer">
        <div class="information" style="position: absolute; bottom: 0;">
            <table width="100%">
                <tr>
                    <td style="width: 50%;">
                        &copy;  2020 Cotizador AguaH2O, Todos los derechos reservados. Desarrollado por ISINET.
                    </td>
                    <td align="right" style="width: 50%;">
                    </td>
                </tr>

            </table>
        </div>
    </div>
    <div class="invoice" style="width: 100%;margin-left:20px;margin-right:20px;margin-top:-40px;">
        <table class="table" width="100%">
            <thead style="background: #bacfda;">
                <tr>
                    <th>
                        {{ __('Nombre') }}
                    </th>
                    <th>
                        {{ __('Precio unitario') }}
                    </th>
                    <th>
                        {{ __('Fecha') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($manoDeObra as $mo)
                    <tr>
                        <td>
                            {{ $mo->name }}
                        </td>
                        <td style="text-align:right;">
                            {{ Helper::formatMoney($mo->unit_cost) }}
                        </td>
                        <td style="white-space: nowrap">
                            {{ $mo->created_at->format('Y-m-d') }}
                        </td>
                    </tr>

                @endforeach
            </tbody>

        </table>
    </div>

    <script type="text/php">
        if ( isset($pdf) ) {
            $font = $fontMetrics->getFont("Lato", "regular");
            $pdf->page_text(530, 770, "Página: {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(255,255,255));
        }
    </script>

</body>
</html>
