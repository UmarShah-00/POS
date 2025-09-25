<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Modave - POS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            color: #000;
        }

        .receipt {
            width: 80mm;
            margin: auto;
            padding: 5px;
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
        }

        th,
        td {
            padding: 4px 0;
            border-bottom: 1px dotted #000;
        }

        th {
            text-align: left;
        }

        .no-border td {
            border: none !important;
        }

        .footer {
            margin-top: 10px;
            text-align: center;
            font-size: 11px;
        }

        .barcode {
            margin-top: 10px;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        @media print {
            body {
                margin: 0;
            }

            .receipt {
                width: 100%;
                margin: 0;
                padding: 0;
            }

            button {
                display: none;
            }
        }

        .barcode svg,
        .barcode img {
            display: block;
            margin: 0 auto;
            height: 45px;
            width: 125px;
        }
    </style>
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">
</head>

<body>
    <div class="receipt">
        <div style="display: flex; justify-content: space-between;">
            <div><small>{{ $sale->created_at->format('d/m/Y h:i A') }}</small></div>
            <div><small>Receipt #{{ $sale->invoice_no }}</small></div>
        </div>

        <div class="center">
            <h2 style="margin: 5px 0;">MODAVE</h2>
            <p style="margin:0;">PLAZA CHOK MUSTAFABAD DC ROAD<br>
                TOBA TEK SINGH<br>
                Whatsapp: 03000000000</p>
        </div>

        <p><strong>Cashier:</strong> {{ auth()->user()->name ?? 'Purchaser' }}</p>

        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th class="right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sale->items as $item)
                    @php
                        $unit = strtolower($item->product->unit);
                        $priceLabel = number_format($item->price);

                        if ($unit === 'kg') {
                            $priceLabel .= ' / Kg';
                        } elseif ($unit === 'litre') {
                            $priceLabel .= ' / Litre';
                        } elseif ($unit === 'piece' || $unit === 'packet') {
                            $priceLabel .= ' / Piece';
                        }
                    @endphp

                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>
                            @if ($unit === 'kg')
                                {{ $item->quantity }} g
                            @elseif($unit === 'litre')
                                {{ $item->quantity }} ml
                            @else
                                {{ $item->quantity }}
                            @endif
                        </td>
                        <td>{{ $priceLabel }}</td>
                        <td style="display: flex; justify-content: end;">{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach


            </tbody>
        </table>

        <table class="no-border">
            <tr>
                <td class="right bold">Subtotal:</td>
                <td class="right">{{ number_format($sale->total_amount, 0) }}</td>
            </tr>
            <tr>
                <td class="right">Tax:</td>
                <td class="right">0%</td>
            </tr>
            <tr>
                <td class="right bold">TOTAL:</td>
                <td class="right bold">{{ number_format($sale->total_amount, 0) }}</td>
            </tr>
            <tr>
                <td>Cash:</td>
                <td class="right">{{ number_format($sale->total_amount, 0) }}</td>
            </tr>
        </table>

        <div class="footer">
            <p>⭐ Thanks For Shopping With Us ⭐</p>
        </div>

        <div class="barcode">
            <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($sale->invoice_no, 'C128') }}" alt="barcode" />
            <p>{{ $sale->invoice_no }}</p>
        </div>

        <div class="center mt-2">
            <button onclick="window.print()">🖨 Print Receipt</button>
        </div>
    </div>
</body>

</html>
