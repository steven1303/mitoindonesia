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
      <table width="95%" style="margin: auto; border-collapse: collapse;">
        <tbody>
            <tr>
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
            <td style="height: 5px;" width="5%"></td>
            <td style="height: 5px;" width="12%"></td>
            <td style="height: 5px;" width="5%"></td>
            <td style="height: 5px;" width="8%"></td>
            <td style="height: 5px;" width="5%"></td>
            <td style="height: 5px;" width="12%"></td>
            <td style="height: 5px;" width="15%"></td>
            <td style="height: 5px;" width="15%"></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="4">Nomor  : {{ $pelunasan->invoice->inv_no }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2">Tanggal Pembayaran : {{ date("d/m/Y", strtotime( $pelunasan->pelunasan_date )) }}</td>
        </tr>
        <tr>
            <td colspan="4">Telah diterima dari : {{ $pelunasan->invoice->customer->name }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2">Metode Pembayaran : @if ($pelunasan->payment_method == 1) Cash @endif @if ($pelunasan->payment_method == 2) Transfer @endif @if ($pelunasan->payment_method == 3) CEK @endif</td>
        </tr>
        <tr>
            <td colspan="4">Alamat : {{ $pelunasan->invoice->customer->address1 }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>

        <tr>
            <td colspan="4">Pembayaran Invoice Berikut :</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="border: 1px solid black; text-align: center;">No.</td>
            <td style="border: 1px solid black; text-align: center;" colspan="2">No. Invoice</td>
            <td style="border: 1px solid black; text-align: center;" colspan="2">No. PO</td>
            <td style="border: 1px solid black; text-align: center;" colspan="2">No. SPPB</td>
            <td style="border: 1px solid black; text-align: center;">Total Invoice</td>
            <td style="border: 1px solid black; text-align: center;">Total Bayar</td>
            <td style="border: 1px solid black; text-align: center;">Sisa Tagihan</td>
        </tr>
        <tr>
            <td style="border: 1px solid black; text-align: center;">1</td>
            <td style="border: 1px solid black; text-align: center;" colspan="2">{{ $pelunasan->invoice->inv_no }}</td>
            <td style="border: 1px solid black; text-align: center;" colspan="2">{{ $pelunasan->invoice->po_cust }}</td>
            <td style="border: 1px solid black; text-align: center;" colspan="2">{{ $pelunasan->invoice->sppb->sppb_no }}</td>
            <td style="border: 1px solid black; text-align: center;">Rp. {{ number_format($pelunasan->invoice->inv_detail->sum('total_ppn'),0, ",", ".") }}</td>
            <td style="border: 1px solid black; text-align: center;">Rp. {{ number_format($pelunasan->balance,0, ",", ".") }}</td>
            <td style="border: 1px solid black; text-align: center;">Rp. {{ number_format( ($pelunasan->invoice->inv_detail->sum('total_ppn') - $pelunasan->balance ),0, ",", ".") }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid black; text-align: center;"></td>
            <td style="border: 1px solid black; text-align: center;" colspan="2"></td>
            <td style="border: 1px solid black; text-align: center;" colspan="2"></td>
            <td style="border: 1px solid black; text-align: center;" colspan="2"></td>
            <td style="border: 1px solid black; text-align: center;">TOTAL Pelunasan : </td>
            <td colspan="2" style="border: 1px solid black; text-align: center;">Rp. {{ number_format( ($pelunasan->balance),0, ",", ".") }}</td>
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
            <td style="height: 20px"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td ></td>
            <td ></td>
            <td></td>
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
            <td style="height: 100px"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td ></td>
            <td ></td>
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
