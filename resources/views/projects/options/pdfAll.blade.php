<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{$name}}</title>
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
            background-color: #ec407a;
            color: #FFF;
        }
        .information .logo {
            margin: 5px;
        }
        .information table {
            padding: 10px;
        }
    </style>
     <style>
       @page { margin: 180px 0px; }
       #header { position: fixed; left: 0px; top: -180px; right: 0px; height: 100px; background-color: #ec407a; text-align: center; }
       #footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px; background-color: #ec407a; }
     </style>
<body>
     <div id="header">
        <div class="information">
            <table width="100%">
                <tr>
                    <td align="left" style="width: 20%;">
                        <img src="{{ public_path()}}/email/logo-bf.png" alt="Cotizador Agua H2O" width="64" class="logo"/>

                    </td>
                    <td align="center">
                        <h1>{{$name}}</h1>
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
                    <td align="left" style="width: 50%;">
                        &copy; IIASA, {{__('All rights reserved. Developed by')}} ISINET
                    </td>
                    <td align="right" style="width: 50%;">
                    </td>
                </tr>

            </table>
        </div>
     </div>
     <div class="invoice" style="margin-left: 30px">
        <table width="100%">
            <thead>
              <tr>
                <th align="left">
                    {{ __('Code') }}
                </th>
                <th align="left">
                    {{ __('Name') }}
                </th>
                <th align="left">
                  {{ __('Block') }}
                </th>
                <th align="left">
                    {{ __('Creation date') }}
                </th>
              </tr>
            </thead>
            <tbody>
                @foreach($query1 as $account)
                        <tr>
                          <td align="left">
                              {{$account->budgetBlock->code}}{{ $account->code }}
                          </td>
                          <td align="left">
                            {{ $account->name }}
                          </td>
                          <td align="left">
                            {{ $account->budgetBlock->name}}
                          </td>
                          <td>
                            {{ $account->created_at->format('Y-m-d') }}
                          </td>
                        </tr>
                      @endforeach
            </tbody>

        </table>
    </div>



    @if ($idioma == "1")
    <script type="text/php">
      if ( isset($pdf) ) {
          $font = $fontMetrics->getFont("Lato", "regular");
          $pdf->page_text(530, 770, "Página: {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(255,255,255));
      }
    </script>
    @else
    <script type="text/php">
      if ( isset($pdf) ) {
          $font = $fontMetrics->getFont("Lato", "regular");
          $pdf->page_text(530, 770, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(255,255,255));
      }
    </script>
    @endif




</body>
</html>
