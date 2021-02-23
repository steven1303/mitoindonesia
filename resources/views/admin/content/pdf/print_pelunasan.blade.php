<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3 style="text-align: center;">Pelunasan </h3>
    <P style="text-align: center;">Kepada Yth : {{ $pelunasan->invoice->customer->name }} </P>
        Tanggal : {{ $pelunasan->created_at }}<br/>
        No. Invoice : {{ $pelunasan->invoice->inv_no }}<br/>
        No. Pelunasan : {{ $pelunasan->pelunasan_no }}<br/>
        <br/>
        <br/>
        <br/>
        <table  border="1" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
                <td height="20" style="text-align: center;">Invoice No</td>
                <td width="60" height="20" style="text-align: center;">Total Invoive</td>
                <td width="60" height="20" style="text-align: center;">Pembayaran</td>
                <td height="20" style="text-align: center;">Method</td>
                <td height="20" style="text-align: center;">Note</td>
            </tr>
                <tr>
                    <td>{{ $pelunasan->invoice->inv_no }}</td>
                    <td>{{ $pelunasan->invoice->inv_detail->sum('total_ppn') }}</td>
                    <td>{{ $pelunasan->balance }}</td>
                    <td>
                        @if($pelunasan->payment_method == 1) Cash @endif
                        @if($pelunasan->payment_method == 2) Transfer @endif
                        @if($pelunasan->payment_method == 3) Cek @endif
                        {{-- {{ $pelunasan->payment_method }} --}}
                    </td>
                    <td>{{ $pelunasan->notes }}</td>
                </tr>
            </tbody>
            </table>
        <br/>
        <br/>
        <em>Note : Exclude (Harga Belum Termasuk PPN 10%)</em><br/>
        <br/>
        &nbsp;<br/>
        <br/>
        Medan, {{ $pelunasan->created_at }}
        <br/>
        &nbsp;
</body>
</html>
