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
            <td colspan="2">Branch : {{ $pelunasan->branch->city }}</td>
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
            <td colspan="4">Nomor  : {{ $pelunasan->pelunasan_no }}</td>
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
            <td style="height: 30px"></td>
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
            <td colspan="2">Pekanbaru, ......</td>
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
