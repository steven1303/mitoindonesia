<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- <style>
        table, th, td {
          border: 1px solid black;
          border-collapse: collapse;
          text-align: center;
        }
        </style> -->
</head>
    <body>
        <table width="100%" style="margin: auto; text-align: center; border-collapse: collapse;">
            <tbody>
            <tr>
                <td style="border: 1px solid black; font-weight: bold;">No</td>
                <td style="border: 1px solid black; font-weight: bold;">No PO</td>
                <td style="border: 1px solid black; font-weight: bold;">No Receipt</td>
                <td style="border: 1px solid black; font-weight: bold;">Nama Barang</td>
                <td style="border: 1px solid black; font-weight: bold;">Qty PO</td>
                <td style="border: 1px solid black; font-weight: bold;">Qty Receipt</td>
                <td style="border: 1px solid black; font-weight: bold;">Qty BO</td>
                <td style="border: 1px solid black; font-weight: bold;">Tgl Receipt</td>
            </tr>
            @php
                $i = 1;
            @endphp
            @foreach ( $rec_stock as $rec)
                @foreach ($rec->receipt_detail as $detail_item)
                    <tr style="border: 1px solid black;">
                        <td style="font-size: 13px; border: 1px solid black;">{{ $i++ }}</td>
                        <td style="font-size: 13px; border: 1px solid black; text-align: left">{{ $rec->po_stock->po_no }}</td>
                        <td style="font-size: 13px; border: 1px solid black; text-align: left">{{ $rec->rec_no}}</td>
                        <td style="font-size: 13px; border: 1px solid black;">@isset($detail_item->stock_master->name) {{$detail_item->stock_master->name}} @endisset</td>
                        <td style="font-size: 13px; border: 1px solid black;">{{ $detail_item->po_detail->qty}}</td>
                        <td style="font-size: 13px; border: 1px solid black;">{{ $detail_item->terima}}</td>
                        <td style="font-size: 13px; border: 1px solid black;">{{ $detail_item->bo}}</td>
                        <td style="font-size: 13px; border: 1px solid black;">{{ $rec->rec_date}}</td>
                    </tr>
                @endforeach                
            @endforeach
            </tbody>
        </table>
    </table>
    </body>
</html>
