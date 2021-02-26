<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3 style="text-align: center;">SURAT Adjustment<br/>
        {{ $adj->adj_no }}
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
                <td height="20" style="text-align: center;">In</td>
                <td height="20" style="text-align: center;">Out</td>
                <td width="60" height="20" style="text-align: center;">Harga Modal</td>
                <td width="60" height="20" style="text-align: center;">Harga Jual</td>
                <td height="20" style="text-align: center;">Keterangan</td>
            </tr>
            @foreach ($adj->adj_detail as $detail)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $detail->stock_master->name }}</td>
                    <td>{{ $detail->in_qty }}</td>
                    <td>{{ $detail->out_qty }}</td>
                    <td>{{ $detail->harga_modal }}</td>
                    <td>{{ $detail->harga_jual }}</td>
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
        Medan, {{$adj->created_at}}
        <br/>
        &nbsp;
</body>
</html>
