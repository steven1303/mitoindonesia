<!-- {{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3 style="text-align: center;">PURCHASE ORDER Non Stock</h3>
    <P style="text-align: center;">Kepada Yth : {{ $po_stock->vendor->name }} </P>
        Tanggal : {{ $po_stock->created_at }}<br/>
        No. PO : {{ $po_stock->po_no }}<br/>
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
            @foreach ($po_stock->po_non_stock_detail as $detail)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $detail->spb_detail->keterangan }}</td>
                    <td>{{ $detail->spb_detail->qty }}</td>
                    <td>{{ $detail->price }}</td>
                    <td>{{ $detail->spb_detail->qty * $detail->price }}</td>
                    <td>{{ $detail->disc }}</td>
                    <td>{{ ($detail->spb_detail->qty * $detail->price) - $detail->disc }}</td>
                </tr>
            @endforeach
            </tbody>
            </table>
        <br/>
        <br/>
        <em>Note : Exclude (Harga Belum Termasuk PPN 10%)</em><br/>
        <br/>
        &nbsp;<br/>
        <br/>
        Medan, {{$po_stock->created_at}}
        <br/>
        &nbsp;
</body>
</html> --}} -->

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
    <table width="95%" style="margin: auto; text-align: center; border-collapse: collapse;">
        <tbody>
            <tr>
                <td colspan="6" style="font-size: 20px; font-weight: bold;">PURCHASE ORDER </td>
            </tr>
            <tr>
                <td style="height: 20px;" width="5%"></td>
                <td style="height: 20px;" width="21%"></td>
                <td style="height: 20px;" width="24%"></td>
                <td style="height: 20px;" width="14%"></td>
                <td style="height: 20px;" width="18%"></td>
                <td style="height: 20px;" width="18%"></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: left;">No. PO : {{ $po_stock->po_no }}</td>
                <td style="text-align: left;" colspan="2" >Kepada Yth : </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: left;">Tanggal: {{ date("d/m/Y", strtotime($po_stock->po_open)) }}</td>
                <td style="text-align: left;" colspan="2" > {{ $po_stock->vendor->name }}</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: left;"> No.SPB:  {{ $po_stock->spb->spb_no }}</td>
                <td style="text-align: left;" colspan="2">{{ $po_stock->vendor->city }}</td>
            </tr>
            <tr>
                <td colspan="6" style="height: 10px"></td>
            </tr>
            <tr style="border: 1px solid black;">
                <td style="border: 1px solid black;">No</td>
                <td style="border: 1px solid black;">Produk</td>
                <td style="border: 1px solid black;">Deskripsi</td>
                <td style="border: 1px solid black;">Qty</td>
                <td style="border: 1px solid black;">Harga @</td>
                <td style="border: 1px solid black;">Total</td>
            </tr>
            @foreach ($po_stock->po_non_stock_detail as $detail)
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black;">{{ $loop->iteration }}</td>
                    <td style="border: 1px solid black; text-align: left">{{ $detail->product }}</td>
                    <td style="border: 1px solid black; text-align: left">{{ $detail->keterangan }}</td>
                    <td style="border: 1px solid black;">{{ $detail->spb_detail->qty }} {{ $detail->spb_detail->satuan }}</td>
                    <td style="border: 1px solid black;">{{ "Rp. ".number_format( ($detail->price),0, ",", ".") }}</td>
                    <td style="border: 1px solid black;">{{ "Rp. ".number_format( ($detail->spb_detail->qty * $detail->price),0, ",", ".") }}</td>
                </tr>
            @endforeach
            @for ($i = $po_stock->po_non_stock_detail->count(); $i < 25; $i++)
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
            <td colspan="2">Dibuat Oleh,</td>
            <td colspan="2">Disetujui Oleh,</td>
            <td colspan="2">Disetujui Oleh,</td>
            <td colspan="2">Total            :</td>
            <td colspan="3">{{ "Rp. ".number_format( ($po_stock->po_non_stock_detail->sum("total")),0, ",", ".") }}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2" rowspan="2">PPN             :</td>
            @if ($po_stock->vendor->status_ppn == 1)
                <td colspan="3" rowspan="2" >{{ "Rp. ".number_format( ($po_stock->po_non_stock_detail->sum("total") * 0.1),0, ",", ".") }}</td>
            @else
            <td colspan="3" rowspan="2">{{ "Rp. ".number_format( (0),0, ",", ".") }}</td>
            @endif

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
            @if ($po_stock->vendor->status_ppn == 1)
                <td colspan="3" rowspan="2">{{ "Rp. ".number_format( ($po_stock->po_non_stock_detail->sum("total") + ($po_stock->po_non_stock_detail->sum("total") * 0.1)),0, ",", ".") }}</td>
            @else
            <td colspan="3" rowspan="2">{{ "Rp. ".number_format( ($po_stock->po_non_stock_detail->sum("total")),0, ",", ".") }}</td>
            @endif
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
            <td colspan="2">(…...............................)</td>
            <td colspan="2">(…...............................)</td>
            <td colspan="2">(…...............................)</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">Purchasing</td>
            <td colspan="2">Branch Manager</td>
            <td colspan="2">GM / Direktur</td>
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


