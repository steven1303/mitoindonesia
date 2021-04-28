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
                <td style="text-align: right;">Branch : {{ $spbd->branch->city }}</td>
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
                <td colspan="5" style="font-size: 20px; font-weight: bold;">SURAT PERMINTAAN BARANG DAGANG</td>
            </tr>
            <tr>
                <td colspan="5" style="font-size: 20px; font-weight: bold;">(SPBD)</td>
            </tr>
            <tr>
                <td style="height: 20px;" width="5%"></td>
                <td style="height: 20px;" width="25%"></td>
                <td style="height: 20px;" width="20%"></td>
                <td style="height: 20px;" width="25%"></td>
                <td style="height: 20px;" width="25%"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;">Kepada :</td>
                <td></td>
                <td></td>
                <td style="text-align: left;">Nomor : {{ $spbd->spbd_no }}</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;">Bagian General Affairs</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="height: 20px;"></td>
                <td style="height: 20px;"></td>
                <td style="height: 20px;"></td>
                <td style="height: 20px;"></td>
                <td style="height: 20px;"></td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: left;">Untuk kepentingan ketersediaan stock dan penjualan barang dagang perusahaan dengan ini kami mohon untuk dapat disediakan BARANG sebagai berikut:</td>
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
                <td style="border: 1px solid black;">Nama Barang</td>
                <td style="border: 1px solid black;">Qty</td>
                <td style="border: 1px solid black;">Vendor</td>
                <td style="border: 1px solid black;">Keterangan</td>
            </tr>
            @foreach ($spbd->spbd_detail as $detail)
            <tr style="border: 1px solid black;">
                <td style="border: 1px solid black;">{{ $loop->iteration }}</td>
                <td style="border: 1px solid black;">{{ $detail->stock_master->name }}</td>
                <td style="border: 1px solid black;">{{ $detail->qty }} {{ $detail->stock_master->satuan }}</td>
                <td style="border: 1px solid black;">{{ $detail->spbd->vendor->name }}</td>
                <td style="border: 1px solid black;">{{ $detail->keterangan }}</td>
            </tr>
            @endforeach
            @for ($i = $spbd->spbd_detail->count(); $i < 16; $i++)
            <tr style="border: 1px solid black; height: 20px;">
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
            </tr>
            @endfor
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <table  width="95%" style="margin: auto; ">
        <tbody>
            <tr>
                <td style="width: 50px;">Notes:</td>
                <td>...............................................................</td>
            </tr>
            <tr>
                <td></td>
                <td>...............................................................</td>
            </tr>
            <tr>
                <td style="height: 25px;"></td>
                <td style="height: 25px;"></td>
            </tr>
            <tr>
                <td colspan="2">{{ $spbd->branch->city }},  {{ date("d/m/Y", strtotime($spbd->spbd_open)) }}</td>
            </tr>
            <tr>
                <td></td>
            </tr>
        </tbody>
    </table>

    <table style="margin: auto; text-align: center; border: 1px solid black; border-collapse: collapse;" width="95%" height="10px">
        <tbody>
            <tr style="border: 1px solid black;">
                <td style="border: 1px solid black;">Pemohon,</td>
                <td style="border: 1px solid black;">Diketahui oleh,</td>
                <td style="border: 1px solid black;">Disetujui oleh,</td>
            </tr>
            <tr style="border: 1px solid black;">
                <td style="height: 100px; border: 1px solid black;"></td>
                <td style="height: 100px; border: 1px solid black;"></td>
                <td style="height: 100px; border: 1px solid black;"></td>
            </tr>
            <tr style="border: 1px solid black;">
                <td style="border: 1px solid black;">(…..................................)</td>
                <td style="border: 1px solid black;">(..................................)</td>
                <td style="border: 1px solid black;">(…................................)</td>
            </tr>
            <tr style="border: 1px solid black;">
                <td style="border: 1px solid black;">Admin Sales/Gudang</td>
                <td style="border: 1px solid black;">Kepala Gudang</td>
                <td style="border: 1px solid black;">Branch Manager</td>
            </tr>
        </tbody>
    </table>
    <div style="position: absolute; bottom: -13; right: 0;">{{ $spbd->spbd_print->isoFormat('DD / MM / Y, h:m:s') }}</div>
</body>
</html>
