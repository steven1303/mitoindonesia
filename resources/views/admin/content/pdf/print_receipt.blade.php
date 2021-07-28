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
                  <td style="text-align: right;"></td>
            </tr>
            <td colspan="6" style="text-align: right;" > Branch : {{ $rec->branch->city }}</td>
            <tr>
            </tr>
            <tr>
              <td colspan="6" style="font-size: 20px; font-weight: bold; text-align: center;">STOCK RECEIPT</td>
            </tr>
        </tbody>
    </table>
    <table width="95%" style="font-size: 10px; margin: auto; border-collapse: collapse;">
        <tbody>
             <tr>
                <td style="height: 20px;" width="17%"></td>
                <td style="height: 20px;" width="23%"></td>
                <td style="height: 20px;" width="5%"></td>
                <td style="height: 20px;" width="20%"></td>
                <td style="height: 20px;" width="35%"></td>
            </tr>
            <tr>
                <td>Nomor Receipt</td>
                <td >: {{ $rec->rec_no }}</td>
                <td></td>
                <td style="text-align: right;">Alamat : </td>
                <td rowspan="4">{{ $rec->vendor->address1 }} @if ($rec->vendor->address2 != "") {{ $rec->vendor->address2 }}@else : ...  @endif</td>
            </tr>
            <tr>
                <td>Tanggal Terima</td>
                <td >: {{ date("d/m/Y", strtotime($rec->rec_date)) }}</td>
                <td></td>
                <td></td>
                <td ></td>
            </tr>
            <tr>
                <td >Nomor PO</td>
                <td >: {{ $rec->po_stock->po_no }}</td>
                <td></td>
                <td></td>
                <td > </td>
            </tr>
            <tr>
                <td>Supplier Name</td>
                <td colspan="3">: {{ $rec->vendor->name }}</td>
                <td ></td>
            </tr>
            <tr>
                <td >Telepon</td>
                <td colspan="3">: {{ $rec->vendor->telp }} {{ $rec->vendor->phone }}</td>
                <td ></td>
            </tr>
        </tbody>
    </table>
    <table width="95%" style="margin: auto; border-collapse: collapse;">
        </tbody>
            <tr>
                <td style="height: 20px;" width="5%"></td>
                <td style="height: 20px;" width="25%"></td>
                <td style="height: 20px;" width="34%"></td>
                <td style="height: 20px;" width="12%"></td>
                <td style="height: 20px;" width="12%"></td>
                <td style="height: 20px;" width="12%"></td>
            </tr>
            <tr style="border: 1px solid black; text-align: center;">
                <td style="border: 1px solid black;">No.</td>
                <td style="border: 1px solid black;">Kode Stock</td>
                <td style="border: 1px solid black;">Deskripsi</td>
                <td style="border: 1px solid black;">Qty Order</td>
                <td style="border: 1px solid black;">Qty Terima</td>
                <td style="border: 1px solid black;">Qty BO</td>
            </tr>
            @foreach ($rec->receipt_detail as $detail)
                <tr style="border: 1px solid black; text-align: center;">
                    <td style="border: 1px solid black;">{{ $loop->iteration }}</td>
                    <td style="border: 1px solid black;">{{ $detail->stock_master->stock_no }}</td>
                    <td style="border: 1px solid black;">{{ $detail->stock_master->name }}</td>
                    <td style="border: 1px solid black;">{{ $detail->order }}</td>
                    <td style="border: 1px solid black;">{{ $detail->terima }}</td>
                    <td style="border: 1px solid black;">{{ $detail->bo }}</td>
                </tr>
            @endforeach
            @for ($i = $rec->receipt_detail->count(); $i < 23; $i++)
            <tr style="border: 1px solid black; height: 20px;">
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
                <td style="border: 1px solid black; height: 20px;"></td>
            </tr>
            @endfor
            <tr>
                <td style="height: 20px;"></td>
                <td style="height: 20px;"></td>
                <td style="height: 20px;"></td>
                <td style="height: 20px;"></td>
                <td style="height: 20px;"></td>
                <td style="height: 20px;"></td>
            </tr>
            <tr>
                <td colspan="3">Note : …..........................................................</td>
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
                <td colspan="2" >Total Qty Order        :</td>
                <td style="text-align: left">{{ $rec->receipt_detail->sum('order') }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2">Total Qty Terima      :</td>
                <td style="text-align: left">{{ $rec->receipt_detail->sum('terima') }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2">Total Qty BO            :</td>
                <td style="text-align: left">{{ $rec->receipt_detail->sum('bo') }}</td>
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
    <div style="position: absolute; bottom: -13; right: 0;">{{ $rec->rec_print->isoFormat('DD / MM / Y, h:m:s') }}</div>
    </body>
</html>
