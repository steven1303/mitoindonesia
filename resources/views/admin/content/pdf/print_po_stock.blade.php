<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body style="border-style: groove;" width="1200px">
    <table  width="95%" style="margin: auto; text-align: center; border-collapse: collapse;">
        <tbody>
            <tr>
                <td>
                    <img src="{{asset('img/PT_Mito_png.png')}}" width="120px" style="float:left">
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right;"></td>
            </tr>
            <tr>
                <td style="height: 50px;"></td>
                <td style="height: 50px;"></td>
                <td style="height: 50px;"></td>
                <td style="height: 50px;"></td>
                <td style="height: 50px;"></td>
            </tr>
        </tbody>
    </table>
    <table  width="95%" style="margin: auto; text-align: center; border-collapse: collapse;">
        <tbody>
            <tr>
                <td colspan="6" style="font-size: 20px; font-weight: bold;">PURCHASE ORDER</td>
            </tr>
            <tr>
                <td style="height: 20px;" width="5%"></td>
                <td style="height: 20px;" width="15%"></td>
                <td style="height: 20px;" width="30%"></td>
                <td style="height: 20px;" width="10%"></td>
                <td style="height: 20px;" width="20%"></td>
                <td style="height: 20px;"></td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: left;">No PO : {{ $po_stock->po_no }}</td>
                <td style="text-align: left;" colspan="3" >Kepada Yth : {{ $po_stock->vendor->name }}</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: left;">Tanggal : {{ date("d/m/Y", strtotime($po_stock->po_open)) }}</td>
                <td style="text-align: left;" colspan="3">Kota : {{ $po_stock->vendor->city }}</td>
            </tr>
            <tr>
                <td style="height: 20px;"></td>
                <td style="height: 20px;"></td>
                <td style="height: 20px;"></td>
                <td style="height: 20px;"></td>
                <td style="height: 20px;"></td>
                <td style="height: 20px;"></td>
            </tr>
            <tr style="border: 1px solid black;">
                <td style="border: 1px solid black;">No</td>
                <td style="border: 1px solid black;">Produk</td>
                <td style="border: 1px solid black;">Desc</td>
                <td style="border: 1px solid black;">Qty</td>
                <td style="border: 1px solid black;">Harga @</td>
                <td style="border: 1px solid black;">Total</td>
            </tr>
            @foreach ($po_stock->po_stock_detail as $detail)
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black;">{{ $loop->iteration }}</td>
                    <td style="border: 1px solid black;">{{ $detail->stock_master->stock_no }}</td>
                    <td style="border: 1px solid black;">{{ $detail->stock_master->name }}</td>
                    <td style="border: 1px solid black;">{{ $detail->qty }} {{ $detail->stock_master->satuan }}</td>
                    <td style="border: 1px solid black;">{{ "Rp. ".number_format( ($detail->price),0, ",", ".") }}</td>
                    <td style="border: 1px solid black;">{{ "Rp. ".number_format( ($detail->qty * $detail->price),0, ",", ".") }}</td>
                </tr>
            @endforeach
            @for ($i = $po_stock->po_stock_detail->count(); $i < 25; $i++)
            <tr style="border: 1px solid black; height: 20px;">
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
            </tr>
            @endfor
        </tbody>
    </table>

    &nbsp;
    <table style="margin: auto; text-align: center; border: 1px solid black; border-collapse: collapse;" width="95%" height="10px" >
        <tbody>
        <tr>
            <td colspan="3">Dibuat Oleh,</td>
            <td colspan="3">Disetujui Oleh,</td>
            <td colspan="2">Total            :</td>
            <td colspan="3">{{ "Rp. ".number_format( ($po_stock->po_stock_detail->sum("total")),0, ",", ".") }}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2" rowspan="2">PPN             :</td>
            <td colspan="3" rowspan="2">{{ "Rp. ".number_format( ($po_stock->ppn),0, ",", ".") }}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2" rowspan="2">Grand Total :</td>
            <td colspan="3" rowspan="2">{{ "Rp. ".number_format( ($po_stock->po_stock_detail->sum("total") + $po_stock->ppn),0, ",", ".") }}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3">(…...............................)</td>
            <td colspan="3">(…...............................)</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3">Purchasing</td>
            <td colspan="3">Direktur</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tbody>
    </table>
    <div style="position: absolute; bottom: -13; right: 0;">{{ $po_stock->po_print->isoFormat('DD / MM / Y, h:m:s') }}</div>
</body>
</html>

