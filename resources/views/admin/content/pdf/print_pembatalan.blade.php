<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body style="border-style: groove;" width="1200px" >
    <table width="95%" style="margin: auto; border-collapse: collapse;" >
      <tbody>
         <tr colspan="3">
                <td colspan="3">
                    <img src="{{asset('img/PT_Mito_png.png')}}" width="120px" style="float:left">
                </td>
                <td style="height: 45px;"></td>
                <td style="height: 45px;"></td>
                <td style="text-align: right;"> Branch : {{ $pembatalan->branch->city }}</td>
          </tr>
          <tr>
            <td colspan="6" style="font-size: 20px; font-weight: bold; text-align: center;">Pembatalan</td>
          </tr>
          <tr>
              <td style="height: 10px;"></td>
              <td style="height: 10px;"></td>
              <td style="height: 10px;"></td>
              <td style="height: 10px;"></td>
              <td style="height: 10px;"></td>
              <td style="height: 10px;"></td>
          </tr>
          <tr>
              <td colspan="1">Nomor</td>
              <td colspan="5">: {{ $pembatalan->pembatalan_no }}</td>
          </tr>
          <tr>
              <td colspan="1">Tanggal</td>
              <td colspan="5">: {{ date("d/m/Y", strtotime($pembatalan->po_open)) }}</td>
          </tr>
          <tr>
              <td colspan="1">Alasan</td>
              <td colspan="5">: {{ $pembatalan->keterangan }}</td>
          </tr>
          <tr>
              <td style="height: 10px;"></td>
              <td style="height: 10px;"></td>
              <td style="height: 10px;"></td>
              <td style="height: 10px;"></td>
              <td style="height: 10px;"></td>
              <td style="height: 10px;"></td>
          </tr>
          <tr style="border: 1px solid black; text-align: center;">
              <td style="border: 1px solid black;" width="10%">No.</td>
              <td style="border: 1px solid black;">No Document</td>
              <td style="border: 1px solid black;" colspan="2">Deskripsi</td>
              <td style="border: 1px solid black;" width="15%">Qty</td>
              <td style="border: 1px solid black;" width="25%">Dok.Pendukung</td>
          </tr>
          @if ($pembatalan->pembatalan_type == 1)
          @foreach ($pembatalan->po_stock->po_stock_detail as $detail)
                <tr style="border: 1px solid black; text-align: center;">
                    <td style="border: 1px solid black;">{{ $loop->iteration }}</td>
                    <td style="border: 1px solid black;">{{ $detail->po_stock->po_no }}</td>
                    <td style="border: 1px solid black;" colspan="2">{{ $detail->stock_master->name }}</td>
                    <td style="border: 1px solid black;">{{ $detail->qty }}</td>
                    <td style="border: 1px solid black;">{{ $detail->po_stock->spbd->spbd_no }}</td>
                </tr>
            @endforeach
            @for ($i = $pembatalan->po_stock->po_stock_detail->count(); $i < 23; $i++)
            <tr style="border: 1px solid black; height: 20px;">
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;" colspan="2"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
            </tr>
            @endfor
        @endif
        @if ($pembatalan->pembatalan_type == 2)
          @foreach ($pembatalan->po_non_stock->po_non_stock_detail as $detail)
                <tr style="border: 1px solid black; text-align: center;">
                    <td style="border: 1px solid black;">{{ $loop->iteration }}</td>
                    <td style="border: 1px solid black;">{{ $detail->po_non_stock->po_no }}</td>
                    <td style="border: 1px solid black;" colspan="2">{{ $detail->product }}</td>
                    <td style="border: 1px solid black;">{{ $detail->spb_detail->qty }}</td>
                    <td style="border: 1px solid black;">{{ $detail->po_non_stock->spb->spb_no }}</td>
                </tr>
            @endforeach
            @for ($i = $pembatalan->po_non_stock->po_non_stock_detail->count(); $i < 23; $i++)
            <tr style="border: 1px solid black; height: 20px;">
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;" colspan="2"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
            </tr>
            @endfor
        @endif
        @if ($pembatalan->pembatalan_type == 3 || $pembatalan->pembatalan_type == 4)
          @foreach ($pembatalan->invoice->inv_detail as $detail)
                <tr style="border: 1px solid black; text-align: center;">
                    <td style="border: 1px solid black;">{{ $loop->iteration }}</td>
                    <td style="border: 1px solid black;">{{ $detail->invoice->inv_no }}</td>
                    <td style="border: 1px solid black;" colspan="2">{{ $detail->stock_master->name }}</td>
                    <td style="border: 1px solid black;">{{ $detail->qty }}</td>
                    <td style="border: 1px solid black;">{{ $detail->invoice->sppb->sppb_no }}</td>
                </tr>
            @endforeach
            @for ($i = $pembatalan->invoice->inv_detail->count(); $i < 23; $i++)
            <tr style="border: 1px solid black; height: 20px;">
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;" colspan="2"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
            </tr>
            @endfor
        @endif

          <tr>
              <td style="height: 20px;"></td>
              <td style="height: 20px;"></td>
              <td style="height: 20px;"></td>
              <td style="height: 20px;"></td>
              <td style="height: 20px;"></td>
              <td style="height: 20px;"></td>
          </tr>
          <tr>
              <td colspan="3">{{ $pembatalan->branch->city }} : {{ date("d/m/Y", strtotime($pembatalan->po_open)) }}</td>
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
              <td style="height: 20px;"></td>
          </tr>
          <tr>
              <td colspan="2" border="1">Di Buat Oleh :</td>
              <td>Di Setujui Oleh :</td>
              <td colspan="2" ></td>
              <td style="text-align: left"></td>
          </tr>
          <tr>
              <td style="height: 20px;"></td>
              <td style="height: 20px;"></td>
              <td style="height: 20px;"></td>
              <td style="height: 20px;" colspan="2"></td>
              <td style="height: 20px;"></td>
          </tr>
          <tr>
            <td style="height: 20px;"></td>
            <td style="height: 20px;"></td>
            <td style="height: 20px;"></td>
            <td style="height: 20px;" colspan="2"></td>
            <td style="height: 20px;"></td>
          </tr>
          <tr>
              <td colspan="2">….....................</td>
              <td>.....................</td>
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
          </tr>
      </tbody>
  </table>
  <div style="position: absolute; bottom: -13; right: 0;">{{ $pembatalan->po_print->isoFormat('DD / MM / Y, h:m:s') }}</div>
  </body>
</html>
