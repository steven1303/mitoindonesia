<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3 style="text-align: center;">RECEIPT ORDER </h3>
    <P style="text-align: center;">Kepada Yth : {{ $rec->vendor->name }} </P>
        Tanggal : {{ $rec->rec_date }}<br/>
        No. PO : {{ $rec->rec_no }}<br/>
        <br/>
        <br/>
        <br/>
        <table  border="1" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
                <td width="30" height="20" style="text-align: center;">No</td>
                <td height="20" style="text-align: center;">Deskripsi</td>
                <td width="60" height="20" style="text-align: center;">Order</td>
                <td width="60" height="20" style="text-align: center;">Terima</td>
                <td width="60" height="20" style="text-align: center;">BO</td>
                <td height="20" style="text-align: center;">Harga @</td>
                <td height="20" style="text-align: center;">Total</td>
                <td height="20" style="text-align: center;">Diskon</td>
                <td height="20" style="text-align: center;">Setelah Diskon</td>
            </tr>
            @foreach ($rec->receipt_detail as $detail)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $detail->stock_master->name }}</td>
                    <td>{{ $detail->order }}</td>
                    <td>{{ $detail->terima }}</td>
                    <td>{{ $detail->bo }}</td>
                    <td>{{ $detail->price }}</td>
                    <td>{{ $detail->order * $detail->price }}</td>
                    <td>{{ $detail->disc }}</td>
                    <td>{{ ($detail->order * $detail->price) - $detail->disc }}</td>
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
        {{-- Medan, {{$po_stock->po_ord_date}} --}}
        <br/>
        &nbsp;
</body>
</html>
