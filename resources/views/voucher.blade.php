<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Voucher</title>
    <style>
        .container {
            padding: 20px;
            margin: 20px 100px;
        }

        .heading {
            text-align: center;
            margin-bottom: 30px;
        }

        .body {
            border: 1px solid black;
            text-align: center;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="heading">
            <h2>Laravel POS Company Ltd.</h2>
            <h4>No.45 Shan Street. Insein. Yangon Region.</h4>
            <p>Phone : 09-123456789 , 09-987654321</p>
        </div>
        <h3>Invoice</h3>
        <div class="body">
            <table>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
                @php
                    // $carts = session()->get('cart');
                    $total = 0;
                @endphp
                @foreach (json_decode($order->order_items) as $k => $c)
                @php
                    $total += $c->quantity * $c->price;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->quantity }}</td>
                    <td>{{ $c->price }}</td>
                    <td>{{ $c->quantity * $c->price }}</td>
                </tr>
                @endforeach
                <tr>
                    <th colspan="3"></th>
                    <th>Total</th>
                    <th>{{ $total }}</th>
                </tr>
            </table>
        </div>
        <p style="margin-top: 40px">
            <h4 style="margin: 0">Sale Person</h4>
            <span>{{ $order->user->name }}</span>
        </p>
        <h5 style="text-align: center">Thanks You...</h5>
    </div>
</body>

</html>
