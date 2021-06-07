<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table, th, td {
          border: 1px solid black;
          border-collapse: collapse;
          text-align: center;
        }
        </style>
</head>
    <body>
        <table width="95%">
            <tr>
                <td>No</td>
                <td>Kode Stock</td>
                <td>Stock Name</td>
                <td>Bin</td>
                <td>Satuan</td>
                <td>SOH</td>
            </tr>
            @foreach ($stock_master as $detail)
            @php
                $soh =  $detail->stock_movement()->where([['in_qty','>', 0],['status','=', 0]])->sum('in_qty') - $detail->stock_movement()->where([['out_qty','>', 0],['status','=', 0]])->sum('out_qty');
            @endphp
            @if($soh > 0)
            <tr style="border: 1px solid black;">
                <td style="border: 1px solid black;">{{ $loop->iteration }}</td>
                <td style="border: 1px solid black;">{{ $detail->stock_no }}</td>
                <td style="border: 1px solid black;">{{ $detail->name}}</td>
                <td style="border: 1px solid black;">{{ $detail->bin}}</td>
                <td style="border: 1px solid black;">{{ $detail->satuan}}</td>
                <td style="border: 1px solid black;">{{ $soh }}</td>
            </tr>
            @endif
            @endforeach
        </table>
    </body>
</html>
