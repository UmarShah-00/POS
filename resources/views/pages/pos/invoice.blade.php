<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 20px;
            color: #000;
        }
        .receipt {
            width: 350px;
            margin: auto;
        }
        .center {
            text-align: center;
        }
        .right {
            text-align: right;
        }
        .bold {
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        th, td {
            padding: 4px;
            border-bottom: 1px dotted #000;
        }
        th {
            text-align: left;
        }
        .no-border td {
            border: none !important;
        }
        .footer {
            margin-top: 15px;
            text-align: center;
        }
        .barcode {
            margin-top: 15px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 3px;
        }
        @media print {
            body {
                margin: 0;
            }
            .receipt {
                width: 100%;
            }
            button {
                display: none;
            }
        }
    </style>
</head>
<body>
<div class="receipt">
    <div class="right">
        <small>{{ $sale->created_at->format('m/d/Y h:i A') }}</small><br>
        <small>Sales Receipt #{{ $sale->invoice_no }}</small>
    </div>

    <div class="center">
        <h2 style="margin: 5px 0;">SAWA</h2>
        <p style="margin:0;">PLAZA CHOK MUSTAFABAD DC ROAD<br>
            TOBA TEK SINGH<br>
            Whatsapp: 03328890328</p>
    </div>

    <p><strong>Cashier:</strong> {{ auth()->user()->name ?? 'Purchaser' }}</p>

    <table>
        <thead>
        <tr>
            <th>Item Name</th>
            <th>Qty</th>
            <th>Price</th>
            <th class="right">Ext Price</th>
        </tr>
        </thead>
        <tbody>
        @foreach($sale->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rs. {{ number_format($item->price, 2) }}</td>
                <td class="right">Rs. {{ number_format($item->subtotal, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <table class="no-border">
        <tr>
            <td class="right bold">Subtotal:</td>
            <td class="right">Rs. {{ number_format($sale->total_amount, 2) }}</td>
        </tr>
        <tr>
            <td class="right">Local Sales Tax</td>
            <td class="right">0% + Rs 0.00</td>
        </tr>
        <tr>
            <td class="right bold">RECEIPT TOTAL:</td>
            <td class="right bold">Rs. {{ number_format($sale->total_amount, 2) }}</td>
        </tr>
        <tr>
            <td>Cash:</td>
            <td class="right">Rs. {{ number_format($sale->total_amount, 2) }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>Thanks For Shopping With Us !</p>
    </div>

    <div class="barcode">
        {{ $sale->invoice_no }}
    </div>

    <div class="center mt-3">
        <button onclick="window.print()">🖨 Print Receipt</button>
    </div>
</div>
</body>
</html>
