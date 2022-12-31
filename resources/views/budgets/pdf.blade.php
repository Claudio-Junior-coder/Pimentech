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

        .headerpdf {
            text-align: center;
            margin-bottom: 25px;
        }

        .total {
            background-color: rgb(0, 255, 110);
            padding: 10px;
            border-radius: 5px;
            text-align: right;
        }

        .table-head {
            background-color: #0A75D9;
            border-radius: 25%;
            color: #FFFFFF;
        }

        .items {
            font-size: 12px;
        }

    </style>
    <div>
        <div class="headerpdf">
            <div>
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b6/Image_created_with_a_mobile_phone.png/1200px-Image_created_with_a_mobile_phone.png" width="80px">
            </div>
            <br>
            <div>
                <span>RAZÂO SOCIAL: EMPRESA</span>
            </div>
        </div>


        <div>
            <span>CLIENTE: {{$budget['customer_name']}}</span>
        </div>

        <div class="total">
            <span>TOTAL DO PEDIDO: {{$budget['total']}}</span>
        </div>

        <table>

            <thead class="table-head">
                <tr>
                    <th scope="col">Descritivo</th>
                    <th scope="col">Valor (unit.)</th>
                    <th scope="col">Qntd</th>
                    <th scope="col">Total</th>
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
