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

        .items, #items-cart {
            font-size: 12px;
        }

        .customer-info td {
            padding: 0.5em;
        }
    </style>
    <div>

        <table border="1">

            <tbody>

                <tr class="items">
                    <td><img src="#" width="80px"></td>
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
                            <h3><b>ORÇAMENTO <br> Nº:</b> {{$budget['number']}}</h3>
                        </div>
                    </td>
                </tr>

            </tbody>

        </table>

        <div style="margin-bottom: -20px;">
            <h5>INFORMAÇÕES DO CLIENTE:</h5>
        </div>
        <table border="1" class="customer-info" style="margin-bottom: 25px;">

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


        <table border="1" class="customer-info" >

            <tbody>

                <tr class="items">
                    <td> <span>TOTAL DO PEDIDO: <b>{{$budget['total']}}</b></span></td>
                    <td><span>TOTAL DE PESO: <b>{{$budget['total_weight']}}</b></span></td>

                </tr>

            </tbody>

        </table>

        <table border="1">

            <thead class="table-head">
                <tr>
                    <th scope="col">Itens</th>
                    <th scope="col">Descritivo</th>
                    <th scope="col">Peso (unit.)</th>
                    <th scope="col">Valor (unit.)</th>
                    <th scope="col">Qntd</th>
                    <th scope="col">Total</th>
                </tr>
            </thead>


            <tbody id="items-cart">
                @foreach($budgetItems as $k => $item)
                <tr>
                    <td>{{$k+1}}</td>
                    <td>{{$item->product_name}}</td>
                    <td>{{$item->weight}} Kg</td>
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
