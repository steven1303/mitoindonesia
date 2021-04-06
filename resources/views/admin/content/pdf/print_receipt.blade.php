<!--<!DOCTYPE html>
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
        <br/>

        <table border="2" width="50%" height="500px" cellspacing="0" cellpadding="0">
            <tbody>

                <tr>
                    <td style="text-align: center;"><p>DIPERIKSA OLEH </p>

                        <p>__________________________________ <br/> </p>
                    </td>

                    <td style="text-align: center;"><p>DISETUJUI OLEH </p>

                         <p>__________________________________ <br/></p>
                     </td>
                 </tr>
                 <tr>
                    <td style="text-align: center;">
                        <p>DIPERIKSA OLEH </p>

                        <p>__________________________________ <br/> </p>
                    </td>

                    <td style="text-align: center;"><p>DISETUJUI OLEH </p>

                         <p>__________________________________ <br/></p>
                     </td>
                 </tr>
            </tbody>
        </table>

  </tr>
  <tr>
    <td colspan="3" align="right" valign="top" style="border:1px solid; padding:5px">&nbsp;</td>
  </tr>
        <tr>
    <td colspan="3" align="right" valign="top" style="border:1px solid; padding:5px"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="74%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="2" align="center"><em><strong>Telah diperiksa dan dihitung sesuai
                dengan fisik barang</strong></em><br /></td>
              </tr>
            <tr>
              <td align="center"><p>DIPERIKSA OLEH </p>
                  <p>&nbsp;</p>
                <p>__________________________________ <br />
                </p></td>
              <td align="center"><p>DISETUJUI OLEH </p>
                  <p>&nbsp;</p>
                <p>__________________________________ </p></td>
            </tr>


        </table></td>
        <td valign="top" style="border:solid 1px"><table width="100%" border="0" cellspacing="2" cellpadding="2">


        </table></td>
      </tr>
    </table></td>
  </tr>




        <br/>
        &nbsp;<br/>
        <br/>
        {{-- Medan, {{$po_stock->po_ord_date}} --}}
        <br/>
        &nbsp;
</body>
</html>-->

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
            <tr>
              <td></td>
              <td></td>
              <td colspan="2" style="font-size: 20px; font-weight: bold; text-align: center;">STOCK RECEIPT</td>
              <td colspan="2"> Branch : {{ $rec->branch->city }}</td>
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
                <td colspan="2">Nomor</td>
                <td>: {{ $rec->rec_no }}</td>
                <td >Supplier Name</td>
                <td colspan="2">: {{ $rec->vendor->name }}</td>
            </tr>
            <tr>
                <td colspan="2">Tanggal Terima</td>
                <td>: {{ date("d/m/Y", strtotime($rec->rec_date)) }}</td>
                <td>Alamat</td>
                <td colspan="2">: {{ $rec->vendor->address1 }}</td>
            </tr>
            <tr>
                <td colspan="2">Nomor PO</td>
                <td>: {{ $rec->po_stock->po_no }}</td>
                <td></td>
                <td colspan="2"> @if ($rec->vendor->address2 != "") : {{ $rec->vendor->address2 }}@else : ............................  @endif</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td></td>
                <td >Telepon</td>
                <td colspan="2">: {{ $rec->vendor->telp }}</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td></td>
                <td >phone</td>
                <td colspan="2">: {{ $rec->vendor->phone }}</td>
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
