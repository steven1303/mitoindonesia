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
                  <td style="text-align: right;"></td>
            </tr>
            <tr>
              <td colspan="6" style="font-size: 20px; font-weight: bold; text-align: center;">RECEIPT TRANSFER</td>
            </tr>
            <tr>
            <td colspan="5" style="text-align: right;">Branch : {{ $transfer_receipt->branch->city }}</td>
            </tr>
            <tr>
            <td style="height: 20px;" colspan="5"></td>
            </tr>
            <tr>
              <td colspan="5" >NO Receipt : {{ $transfer_receipt->receipt_transfer_no }}</td>
            </tr>
            <tr>
              <td colspan="5" >NO Transfer : {{ $transfer_receipt->transfer->transfer_no }}</td>
            </tr>
        </tbody>
    </table>
    <table width="95%" style="margin: auto; border-collapse: collapse;">
        </tbody>
            <tr>
                <td style="height: 20px;" width="7%"></td>
                <td style="height: 20px;" width="23%"></td>
                <td style="height: 20px;" width="30%"></td>
                <td style="height: 20px;" width="15%"></td>
                <td style="height: 20px;" width="25%"></td>
                

            </tr>
            <tr style="border: 1px solid black; text-align: center;">
                <td style="border: 1px solid black;">No.</td>
                <td style="border: 1px solid black;">Kode Stock</td>
                <td style="border: 1px solid black;">Deskripsi</td>
                <td style="border: 1px solid black;">Qty</td>
                <td style="border: 1px solid black;">Keterangan</td>
            </tr>
            @foreach ($transfer_receipt->transfer_receipt_detail as $detail)
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black;">{{ $loop->iteration }}</td>
                    <td style="border: 1px solid black;">{{ $detail->stock_master->stock_no }}</td>
                    <td style="border: 1px solid black;">{{ $detail->stock_master->name }}</td>
                    <td style="border: 1px solid black;">{{ $detail->qty }}</td>
                    <td style="border: 1px solid black;">{{ $detail->keterangan }}</td>
                </tr>
            @endforeach
            @for ($i = $transfer_receipt->transfer_receipt_detail->count(); $i < 15; $i++)
            <tr style="border: 1px solid black; height: 20px;">
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
            </tr>
            @endfor
            <tr>
                <td colspan="5" style="height: 20px;"></td>          
            </tr>
        </tbody>
    </table>
    <table width="95%" style="margin: auto; border-collapse: collapse;">
        <tbody>
            <tr>
                <td colspan="3">Note : …..........................................................</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
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
                <td colspan="5" style="height: 50px;"></td>
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
    </body>
</html>
