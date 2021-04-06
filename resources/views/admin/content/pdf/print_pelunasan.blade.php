<!--<!DOCTYPE html>
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
                    <td>Rp. {{ number_format($pelunasan->invoice->inv_detail->sum('total_ppn'),0, ",", ".") }}</td>
                    <td>Rp. {{ number_format($pelunasan->balance,0, ",", ".") }}</td>
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
      <table width="95%" style="margin: auto; border-collapse: collapse;" >
        <tbody><tr>
                  <td colspan="3">
                      <img src="{{asset('img/PT_Mito_png.png')}}" width="120px" style="float:left">
                  </td>
                  <td style="height: 45px;"></td>
                  <td style="height: 45px;"></td>
                  <td style="height: 45px;"></td>
                  <td style="height: 45px;"></td>
                  <td style="height: 45px;"></td>
                  <td style="height: 45px;"></td>
                  <td style="text-align: right;"></td>
            </tr>
<tr>
<td colspan="8" style="font-size: 20px; font-weight: bold; text-align: center;" >BUKTI PENERIMAAN PEMBAYARAN</td>
<td colspan="2">Branch : Pekanbaru</td>
</tr>
<tr>
<td style="height: 5px;" width="5%"></td>
<td style="height: 5px;" width="10%"></td>
<td style="height: 5px;" width="10%"></td>
<td style="height: 5px;" width="10%"></td>
<td style="height: 5px;" width="10%"></td>
<td style="height: 5px;" width="10%"></td>
<td style="height: 5px;" width="10%"></td>
<td style="height: 5px;" width="10%"></td>
<td style="height: 5px;" width="10%"></td>
<td></td>
</tr>
<tr>
<td colspan="2">Nomor</td>
<td> :................</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<td colspan="2">Telah diterima dari</td>
<td> :................</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<td colspan="2">Alamat</td>
<td> :................</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr>
<td colspan="3">Pembayaran Invoice Berikut :</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<td style="border: 1px solid black;">No.</td>
<td style="border: 1px solid black;">Tgl Bayar</td>
<td style="border: 1px solid black;">No. Invoice</td>
<td style="border: 1px solid black;">No. PO</td>
<td style="border: 1px solid black;">No. SPPB</td>
<td style="border: 1px solid black;">Total Invoice</td>
<td style="border: 1px solid black;">Total Bayar</td>
<td style="border: 1px solid black;">Sisa Tagihan</td>
<td style="border: 1px solid black;">Method</td>
<td style="border: 1px solid black;">Keterangan</td>
</tr>
<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td colspan="2">TOTAL   Pelunasan</td>
<td>: 0</td>
</tr>
<tr>
<td></td>
<td></td>
<td></td>
<td colspan="2">Pekanbaru, 10 Maret 2021</td>
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
<td >Cash</td>
<td >Transfer</td>
<td>Cek</td>
<td></td>
</tr>
<tr>
<td></td>
<td></td>
<td></td>
<td>Di Cetak Oleh :</td>
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
<td>(...........................)</td>
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
</tr>
</tbody>
</table>
