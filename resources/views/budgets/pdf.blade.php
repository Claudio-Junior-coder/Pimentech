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

        .ordernumber h3 {
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
        }

        .total {
            border: 1px solid #000;
            padding: 10px;
            text-align: right;
        }

        .items {
            font-size: 12px;
        }

        .customer-info {
            margin-bottom: 25px;
        }

        .customer-info td {
            padding: 0.5em;
        }
    </style>
    <div>

        <table border="1">

            <tbody>

                <tr class="items">
                    <td><img src="{{ asset('images/jr.png') }}" width="80px"></td>
                    <td style="padding: 0 0 10px 15px;">
                        <h3>JRsystem - sistema para gestão interna LTDA</h3> <br>
                        <span>Fausto Rizatti nº160, B. Jardim Nova Aparecida,</span><br>
                        <span>Tambaú - SP - 13710-000</span><br>
                        <span>Fone: (19) 99130-1755</span><br>
                        <span>www.claudiopimentel.com</span><br>
                        <span>contato@claudiopimentel.com</span>
                    </td>
                    <td>
                        <div class="ordernumber">
                            <h3><b>ORÇAMENTO <br> Nº:</b> 355129</h3>
                        </div>
                    </td>
                </tr>

            </tbody>

        </table>

        <div style="margin-bottom: -20px;">
            <h5>INFORMAÇÕES DO CLIENTE:</h5>
        </div>
        <table border="1" class="customer-info">

            <tbody>

                <tr class="items">
                    <td><b>NOME/RAZÃO SOCIAL:</b> {{$budget['customer_name']}}</td>
                    <td><b>CNPJ/CPF:</b> 000.000.000.00</td>
                    <td><b>DATA EMISSÃO:</b> {{date('d/m/Y')}}</td>
                </tr>
                <tr class="items">
                    <td><b>ENDEREÇO:</b> RUA JOAQUIM BARBOSA FERROZO, 570</td>
                    <td><b>BAIRRO:</b> FRAMBOEZA</td>
                    <td><b>CEP:</b> 13710-000</td>
                </tr>
                <tr class="items">
                    <td><b>MUNICIPIO:</b> TAMBAU</td>
                    <td><b>UF:</b> SP</td>
                    <td><b>FONE/FAX:</b> 987465151</td>
                </tr>

            </tbody>

        </table>

        <div class="total">
            <span>TOTAL DO PEDIDO: <b>{{$budget['total']}}</b></span>
        </div>

        <table border="1">

            <thead class="table-head">
                <tr>
                    <th>Descritivo</th>
                    <th>Valor (unit.)</th>
                    <th>Qntd</th>
                    <th>Total</th>
                </tr>
            </thead>


            <tbody>
                @foreach($budgetItems as $item)
                <tr class="items">
                    <td>{{$item->product_name}}</td>
                    <td>{{$item->price}}</td>
                    <td>{{$item->quantity}}</td>
                    <td>{{$item->total_price}}</td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</body>

</html>
