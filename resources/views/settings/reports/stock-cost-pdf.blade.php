<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$fileName}}</title>
</head>

<body>
    <style>
        table {
            width: 100%;
        }

        .ordernumber p {
            padding-left: 10px;
        }

        .total {
            border: 1px solid #000;
            padding: 5px;
            margin-bottom: 2px;
        }

        .items {
            font-size: 10px;
        }

        .customer-info {
            margin-bottom: 25px;
        }

        .customer-info td {
            padding: 0.5em;
        }

        .title {
            text-align: center;
        }
    </style>
    <div>

        <div class="total title">
            <h3>Relatório: {{$items['title']}} - {{date('d/m/Y')}}</h3>
        </div>
        <div class="total" style="font-size: 12px;">
            <span>TOTAL EM REAIS: <b>R$: {{ number_format((float) $items['totalPrice'], 2, ',', '.') }}</b></span>
        </div>
        <div class="total" style="font-size: 12px;">
            <span>TOTAL DE PRODUTOS EM STOCK: <b>{{$items['totalItems']}}</b> ITENS</span>
        </div>

        <table border="1">

            <thead class="table-head">
                <tr class="items">
                    <th>Descritivo</th>
                    <th>Qntd</th>
                    <th>Valor (unit.)</th>
                    <th>Total</th>
                </tr>
            </thead>


            <tbody>

                @foreach($items['products'] as $k => $item)
                <tr class="items">
                    <td>{{$item['name']}}</td>
                    <td style="text-align: center;">{{$item['qntd']}}</td>
                    <td style="text-align: center;">R$: {{ number_format((float) $item['unit'], 2, ',', '.') }}</td>
                    <td style="text-align: center;">R$: {{ number_format((float) $item['total'], 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>

        </table>


    </div>

</body>

</html>
