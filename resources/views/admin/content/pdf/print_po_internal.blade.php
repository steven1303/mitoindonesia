<!DOCTYPE html>
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
</html>
