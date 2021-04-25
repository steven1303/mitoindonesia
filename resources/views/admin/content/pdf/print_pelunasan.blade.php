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
                      <img src="{{asset('img/PT_Mito_png.png')}}" width="120px" style="float:left"></td>
                  <td style="height: 45px;"></td>
                  <td style="height: 45px;"></td>
                  <td style="height: 45px;"></td>
                  <td style="height: 45px;"></td>
                  <td style="height: 45px;"></td>
                  <td style="height: 45px;"></td>
                  <td style="height: 45px;"></td>
            </tr>
            <tr>
                 <td colspan="10" style="text-align: right">Branch : {{ $pelunasan->branch->city }}</td>
            </tr>
            <tr>
            <td colspan="10" style="font-size: 20px; font-weight: bold; text-align: center;" >BUKTI PENERIMAAN PEMBAYARAN</td>
            </tr>
            <tr>
            <td style="height: 5px;" width="5%"></td>
            <td style="height: 5px;" width="10%"></td>
            <td style="height: 5px;" width="10%"></td>
            <td style="height: 5px;" width="5%"></td>
            <td style="height: 5px;" width="8%"></td>
            <td style="height: 5px;" width="5%"></td>
            <td style="height: 5px;" width="12%"></td>
            <td style="height: 5px;" width="15%"></td>
            <td style="height: 5px;" width="15%"></td>
            <td style="height: 5px;" width="15%"></td>
            </tr>
        <tr>
            <td colspan="2">Nomor  </td>
            <td colspan="3">: {{ $pelunasan->pelunasan_no }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td >Tanggal Jatuh Tempo </td>
            <td>: {{ date("d/m/Y", strtotime( $pelunasan->pelunasan_date )) }}</td>
        </tr>
        <tr>
            <td colspan="2">Telah Diterima Dari </td>
            <td colspan="3">: {{ $pelunasan->invoice->customer->name }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td >Metode Pembayaran </td>
            <td>: @if ($pelunasan->payment_method == 1) Cash @endif @if ($pelunasan->payment_method == 2) Transfer @endif @if ($pelunasan->payment_method == 3) CEK @endif</td>
        </tr>
        <tr>
            <td colspan="2">Alamat </td>
            <td colspan="5" rowspan="2">: {{ $pelunasan->invoice->customer->address1 }}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="10" style="height: 20px"></td>
        </tr>
        <tr>
            <td colspan="10" style="height: 10px"></td>
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
        </tbody>
        </table>
    <table  width="95%" style="margin: auto; border-collapse: collapse;">
        <tbody>
        <tr>
            <td style="height: 5px;" width="4%"></td>
            <td style="height: 5px;" width="8%"></td>
            <td style="height: 5px;" width="8%"></td>
            <td style="height: 5px;" width="8%"></td>
            <td style="height: 5px;" width="8%"></td>
            <td style="height: 5px;" width="8%"></td>
            <td style="height: 5px;" width="8%"></td>
            <td style="height: 5px;" width="16%"></td>
            <td style="height: 5px;" width="16%"></td>
            <td style="height: 5px;" width="16%"></td>
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
            <td style="border: 1px solid black; text-align: center; height: 150px; vertical-align: text-top;">1</td>
            <td style="border: 1px solid black; text-align: center; height: 150px; vertical-align: text-top;" colspan="2">{{ $pelunasan->invoice->inv_no }}</td>
            <td style="border: 1px solid black; text-align: center; height: 150px; vertical-align: text-top;" colspan="2">{{ $pelunasan->invoice->po_cust }}</td>
            <td style="border: 1px solid black; text-align: center; height: 150px; vertical-align: text-top;" colspan="2">{{ $pelunasan->invoice->sppb->sppb_no }}</td>
            <td style="border: 1px solid black; text-align: center; height: 150px; vertical-align: text-top;">Rp. {{ number_format($pelunasan->invoice->inv_detail->sum('total_ppn'),0, ",", ".") }}</td>
            <td style="border: 1px solid black; text-align: center; height: 150px; vertical-align: text-top;">Rp. {{ number_format($pelunasan->balance,0, ",", ".") }}</td>
            <td style="border: 1px solid black; text-align: center; height: 150px; vertical-align: text-top;">Rp. {{ number_format( ($pelunasan->invoice->inv_detail->sum('total_ppn') - $pelunasan->balance ),0, ",", ".") }}</td>
        </tr>
        
        <!-- <tr>
            <td style="border: 1px solid black; text-align: center;"></td>
            <td style="border: 1px solid black; text-align: center;" colspan="2"></td>
            <td style="border: 1px solid black; text-align: center;" colspan="2"></td>
            <td style="border: 1px solid black; text-align: center;" colspan="2"></td>
            <td style="border: 1px solid black; text-align: center;"></td>
            <td style="border: 1px solid black; text-align: center;"></td>
            <td style="border: 1px solid black; text-align: center;"></td>
        </tr> -->
        <tr>
            <td colspan="10" style="height: 30px"></td>
        </tr>
        </tbody>
        </table>
        <table width="95%" style="margin: auto; border-collapse: collapse;">
        </tbody>
            <tr>
                <td colspan="8" style="text-align: right;">TOTAL Pelunasan : </td>
                <td colspan="2" style="text-align: left;">Rp. {{ number_format( ($pelunasan->balance),0, ",", ".") }}</td>
            </tr>
            <tr>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2">Pekanbaru, {{ date("d/m/Y", strtotime($pelunasan->pelunasan_open)) }}</td>
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
            <td colspan="2">Di Cetak Oleh :</td>
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
        <td colspan="2">(...........................)</td>
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
