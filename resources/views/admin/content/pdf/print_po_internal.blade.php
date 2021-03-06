<!-- {{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3 style="text-align: center;">PURCHASE ORDER INTERNAL</h3>
    <P style="text-align: center;">Kepada Yth : {{ $po_internal->customer->name }} </P>
        Tanggal : {{ $po_internal->po_open }}<br/>
        No. PO : {{ $po_internal->po_no }}<br/>
        <br/>
        <br/>
        <br/>
        <table  border="1" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
                <td width="30" height="20" style="text-align: center;">No</td>
                <td height="20" style="text-align: center;">Deskripsi</td>
                <td width="60" height="20" style="text-align: center;">QTY</td>
                <td height="20" style="text-align: center;">Harga @</td>
                <td height="20" style="text-align: center;">Total</td>
                <td height="20" style="text-align: center;">Diskon</td>
                <td height="20" style="text-align: center;">Setelah Diskon</td>
            </tr>
            @foreach ($po_internal->po_internal_detail as $detail)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $detail->stock_master->name }}</td>
                    <td>{{ $detail->qty }}</td>
                    <td>{{ $detail->price }}</td>
                    <td>{{ $detail->qty * $detail->price }}</td>
                    <td>{{ $detail->disc }}</td>
                    <td>{{ ($detail->qty * $detail->price) - $detail->disc }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="6">PPN</td>
                <td> {{$po_internal->ppn}}</td>
            </tr>
            </tbody>
            </table>
        <br/>
        <br/>
        <em>Note : Exclude (Harga Belum Termasuk PPN 10%)</em><br/>
        <br/>
        &nbsp;<br/>
        <br/>
        Medan, {{$po_internal->po_ord_date}}<br/>
        Tanggal: {{ $po_internal->po_print }}
        <br/>
        &nbsp;
</body>
</html> --}}
-->

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
                <td></td>
                <td></td>
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
                <td style="height: 20px;" width="25%"></td>
                <td style="height: 20px;" width="30%"></td>
                <td style="height: 20px;" width="10%"></td>
                <td style="height: 20px;" width="15%"></td>
                <td style="height: 20px;" width="15%"></td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: left;" >Dari : {{ $po_internal->customer->name }}</td>
                <td colspan="3" style="text-align: left;"  >Kepada Yth : PT. Mito Energi Indonesia</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: left;">Tanggal : {{ date("d/m/Y", strtotime($po_internal->po_open)) }}</td>
                <td style="text-align: left;" colspan="3" rowspan="2" >Alamat : {{ $po_internal->branch->address }}</td>
            </tr>
            <tr>
                <td colspan="6" style="text-align: left;">Nomor : {{ $po_internal->po_no }}</td>
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
                <td style="border: 1px solid black;">Deskripsi</td>
                <td style="border: 1px solid black;">Qty</td>
                <td style="border: 1px solid black;">Harga @</td>
                <td style="border: 1px solid black;">Total</td>
            </tr>
            @foreach ($po_internal->po_internal_detail as $detail)
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black;">{{ $loop->iteration }}</td>
                    <td style="border: 1px solid black; text-align: left">{{ $detail->stock_master->stock_no }}</td>
                    <td style="border: 1px solid black; text-align: left">{{ $detail->stock_master->name }}</td>
                    <td style="border: 1px solid black;">{{ $detail->qty }} {{ $detail->satuan }}</td>
                    <td style="border: 1px solid black;">{{ "Rp. ".number_format( ($detail->price),0, ",", ".") }}</td>
                    <td style="border: 1px solid black;">{{ "Rp. ".number_format( ($detail->qty * $detail->price),0, ",", ".") }}</td>
                </tr>
            @endforeach
            @for ($i = $po_internal->po_internal_detail->count(); $i < 25; $i++)
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
            <td colspan="3"></td>
            <td colspan="2">Total            :</td>
            <td colspan="3">{{ "Rp. ".number_format( ($po_internal->po_internal_detail->sum("total")),0, ",", ".") }}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2" rowspan="2">PPN             :</td>
            <td colspan="3" rowspan="2">{{ "Rp. ".number_format( ($po_internal->ppn),0, ",", ".") }}</td>
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
            <td colspan="3" rowspan="2">{{ "Rp. ".number_format( ($po_internal->po_internal_detail->sum("total") + $po_internal->ppn),0, ",", ".") }}</td>
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
            <td colspan="3"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3">Purchasing</td>
            <td colspan="3"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tbody>
    </table>
    <div style="position: absolute; bottom: -13; right: 0;">{{ $po_internal->po_print->isoFormat('DD / MM / Y, h:m:s') }}</div>
</body>
</html>
