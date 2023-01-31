<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }

        th {
            background-color: #1269BA;
            color: white;
        }
    </style>
</head>

<body>
    <h4>Olá, esperamos que esteja tudo bem com você.</h4>
    <p>Segue os produtos que atingiram stock minimo essa semana.</p>
    <br>
    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>Stock mínimo</th>
                <th>Stock atual</th>
                <th>Detalhes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{$product->name}}</td>
                <td>{{$product->min_stock}}</td>
                <td>{{$product->quantity}}</td>
                <td><a href="{{ $url . '/products/update/' . $product->id}}">Acessar</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
