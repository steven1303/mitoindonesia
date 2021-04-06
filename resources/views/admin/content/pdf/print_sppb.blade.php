{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3 style="text-align: center;">SURAT PERMINTAAN PENGELUARAN BARANG <br/>
        (SPPB)
    </h3>
        Kepada : <br/>
        Bagian General Affairs<br/>
        <br/>
        Untuk kepentingan ketersediaan stock dan penjualan barang dagang perusahaan dengan ini kami mohon untuk dapat disediakan Barang sebagai berikut:<br/>
        <br/>
        <br/>
        <table  border="1" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
                <td width="30" height="20" style="text-align: center;">No</td>
                <td height="20" style="text-align: center;">Nama Barang</td>
                <td height="20" style="text-align: center;">Vendor</td>
                <td width="60" height="20" style="text-align: center;">QTY</td>
                <td height="20" style="text-align: center;">Keterangan</td>
            </tr>
            @foreach ($sppb->sppb_detail as $detail)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $detail->stock_master->name }}</td>
                    <td>{{ $detail->sppb->customer->name }}</td>
                    <td>{{ $detail->qty }}</td>
                    <td>{{ $detail->keterangan }}</td>
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
        Medan, {{$spbd->spbd_date}}
        <br/>
</body>
</html> --}}

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
                <td style="text-align: right;">Branch : {{ $sppb->branch->city }}</td>
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
                <td colspan="5" style="font-size: 20px; font-weight: bold;">SURAT PERMOHONAN PENGELUARAN BARANG</td>
            </tr>
            <tr>
                <td style="height: 20px;" width="8%"></td>
                <td style="height: 20px;" width="30%"></td>
                <td style="height: 20px;" width="10%"></td>
                <td style="height: 20px;" width="20%"></td>
                <td style="height: 20px;"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;">No Surat &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : {{ $sppb->sppb_no }}</td>
                <td></td>
                <td></td>
                <td style="text-align: left;">Tanggal : {{ date("d/m/Y", strtotime($sppb->sppb_open)) }}</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;">Ditujukan Kepada &nbsp;: {{ $sppb->customer->name }}</td>
                <td></td>
                <td></td>
                <td style="text-align: left;">Po Cust : {{ $sppb->sppb_po_cust }}</td>
            </tr>
            <tr>
                <td style="height: 20px;"></td>
                <td style="height: 20px;"></td>
                <td style="height: 20px;"></td>
                <td style="height: 20px;"></td>
                <td style="height: 20px;"></td>
            </tr>
            <tr style="border: 1px solid black;">
                <td style="border: 1px solid black;">No</td>
                <td style="border: 1px solid black;" colspan="2">Nama Barang</td>
                <td style="border: 1px solid black;">Banyaknya</td>
                <td style="border: 1px solid black;">Keterangan</td>
            </tr>
            @foreach ($sppb->sppb_detail as $detail)
            <tr style="border: 1px solid black;">
                <td style="border: 1px solid black;">{{ $loop->iteration }}</td>
                <td style="border: 1px solid black;" colspan="2">{{ $detail->stock_master->name }}</td>
                <td style="border: 1px solid black;">{{ $detail->qty }} {{ $detail->stock_master->satuan }}</td>
                <td style="border: 1px solid black;">{{ $detail->keterangan }}</td>
            </tr>
            @endforeach
            @for ($i = $sppb->sppb_detail->count(); $i < 10; $i++)
            <tr style="border: 1px solid black; height: 20px;">
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;" colspan="2"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
            </tr>
            @endfor
            <tr>
                <td style="height: 20px;"></td>
                <td style="height: 20px;"></td>
                <td style="height: 20px;"></td>
                <td style="height: 20px;"></td>
                <td style="height: 20px;"></td>
            </tr>
        </tbody>
    </table>

    <table style="margin: auto; text-align: center; border: 1px solid black; border-collapse: collapse;" width="95%" height="10px">
        <tbody>
            <tr style="border: 1px solid black;">
                <td style="border: 1px solid black;">Pemohon,</td>
                <td style="border: 1px solid black;" colspan="2">Verifikasi,</td>
                <td style="border: 1px solid black;">Mengetahui,</td>
                <td style="border: 1px solid black;">Menyetujui,</td>
            </tr>
            <tr style="border: 1px solid black;">
                <td style="height: 100px; border: 1px solid black;"></td>
                <td style="height: 100px; border: 1px solid black;"></td>
                <td style="height: 100px; border: 1px solid black;"></td>
                <td style="height: 100px; border: 1px solid black;"></td>
                <td style="height: 100px; border: 1px solid black;"></td>
            </tr>
            <tr style="border: 1px solid black;">
                <td style="border: 1px solid black;">Admin Sales</td>
                <td style="border: 1px solid black;">Admin Gudang</td>
                <td style="border: 1px solid black;">Staff Accounting</td>
                <td style="border: 1px solid black;">Manager Acc-Finance</td>
                <td style="border: 1px solid black;">Direktur</td>
            </tr>
        </tbody>
    </table>
    <div style="position: absolute; bottom: -13; right: 0;">{{ $sppb->sppb_print->isoFormat('DD / MM / Y, h:m:s') }}</div>
</body>
</html>
