<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3 style="text-align: center;">INVOICE </h3>
    <P style="text-align: center;">Kepada Yth : {{ $inv->customer->name }} </P>
        Tanggal : {{ $inv->date }}<br/>
        No. Invoice : {{ $inv->inv_no }}<br/>
        <br/>
        <br/>
        <br/>
        <table  border="1" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
                <td width="30" height="20" style="text-align: center;">No</td>
                <td height="20" style="text-align: center;">Deskripsi</td>
                <td width="60" height="20" style="text-align: center;">Satuan</td>
                <td width="60" height="20" style="text-align: center;">QTY</td>
                <td height="20" style="text-align: center;">Harga @</td>
                <td height="20" style="text-align: center;">Diskon</td>
                <td height="20" style="text-align: center;">Total</td>
                <td height="20" style="text-align: center;">Setelah Diskon</td>
            </tr>
            @foreach ($inv->inv_detail as $detail)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $detail->stock_master->name }}</td>
                    <td>{{ $detail->stock_master->satuan }}</td>
                    <td>{{ $detail->qty }}</td>
                    <td>{{ $detail->price }}</td>
                    <td>{{ $detail->disc }}</td>
                    <td>{{ $detail->qty * $detail->price }}</td>
                    <td>{{ ($detail->qty * $detail->price) - $detail->disc }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="7"> PPN </td>
                <td> {{ $inv->ppn }} </td>
            </tr>
            <tr>
                <td colspan="7"> Total Invoice </td>
                <td> {{ $inv->inv_detail->sum('total_ppn') }} </td>
            </tr>
            </tbody>
            </table>
        <br/>
        <br/>
        <em>Note : Exclude (Harga Belum Termasuk PPN 10%)</em><br/>
        <br/>
        &nbsp;<br/>
        <br/>
        Medan, {{ $inv->date }}
        <br/>
        &nbsp;
</body>
</html>
-->
<!DOCTYPE html>
  <html lang="en">
    <  <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
          <title>Document</title>
      </head>
      <body style="border-style: groove;" width="1200px" >
      <table width="98%" style="margin: auto; border-collapse: collapse;" >
        <tbody><tr>
                  <td colspan="3">
                      <img src="{{asset('img/PT_Mito_png.png')}}" width="120px" style="float:left">
                  </td>
                  <td style="height: 45px;"></td>
                  <td style="height: 45px;"></td>
                  <td style="height: 45px;"></td>
                  <td style="text-align: right;"></td>
            </tr>
<tr>
<td></td>
<td colspan="4" style="font-size: 20px; font-weight: bold; text-align: center;">INVOICE</td>
<td colspan="2">Branch : Pekanbaru</td>
</tr>
<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<td>Nomor</td>
<td>: .............</td>
<td></td>
<td></td>
<td>Pengiriman</td>
<td colspan="2">: .............</td>
</tr>
<tr>
<td>Tanggal</td>
<td>: .............</td>
<td></td>
<td></td>
<td>Alamat</td>
<td colspan="2">:.............</td>
</tr>
<tr>
<td>Kepada</td>
<td>: .............</td>
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
<td>Mata Uang</td>
<td colspan="2">: .............</td>
</tr>
<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td>Terms</td>
<td colspan="2">: .............</td>
</tr>
<tr>
<td style="border: 1px solid black;">No</td>
<td style="border: 1px solid black;">Deskripsi</td>
<td style="border: 1px solid black;">Jumlah</td>
<td style="border: 1px solid black;">Unit</td>
<td style="border: 1px solid black;">Harga @</td>
<td style="border: 1px solid black;">Disc</td>
<td style="border: 1px solid black;">Sub Total</td>
</tr>
<tr>
<td></td>
<td>PO No : ...............</td>
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
</tr>
<tr>
<td colspan="3">Terbilang :</td>
<td></td>
<td colspan="2">Sub I</td>
<td></td>
</tr>
<tr>
<td colspan="4"> ...............</td>
<td>Tax</td>
<td></td>
<td></td>
</tr>
<tr>
<td colspan="3"></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<td colspan="3"></td>
<td></td>
<td colspan="2">Total</td>
<td></td>
</tr>
<tr>
<td colspan="2">Rekening Tujuan Pembayaran :</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<td colspan="2">Bank Mandiri  Pekanbaru</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<td colspan="2">Atas nama : PT. Mito Energi Indonesia</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<td colspan="2">No                 : 108 0558828 282</td>
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
</tr>
<tr>
<td></td>
<td>Pembeli</td>
<td></td>
<td></td>
<td></td>
<td colspan="2">PT. Mito Energi Indonesia</td>
</tr>
<tr>
<td></td>
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
</tr>
<tr>
<td></td>
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
</tr>
<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td colspan="2">Taufan</td>
</tr>
<tr>
<td></td>
<td>Tanggal :</td>
<td></td>
<td></td>
<td></td>
<td colspan="2"></td>
</tr>
<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
</tbody>
</table>