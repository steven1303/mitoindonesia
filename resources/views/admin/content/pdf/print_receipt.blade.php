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
      <table width="100%" border = "1">
        <tbody>
           <tr>
                  <td colspan="3">
                      <img src="{{asset('img/PT_Mito_png.png')}}" width="120px" style="float:left">
                  </td>
                  <td></td>
                  <td></td>
                  <td style="text-align: right;"></td>
            </tr>
  
<tr>
<td></td>
<td>
<table>
<tbody>
<tr>
<td width="31"></td>
</tr>
</tbody>
</table>
</td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<td></td>
<td></td>
<td colspan="2" style="font-size: 20px; font-weight: bold; text-align: center;">STOCK RECEIPT</td>
<td colspan="2"> Branch : Pekanbaru</td>
</tr>
<tr>
<td ></td>
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
</tr>
<tr>
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
</tr>
<tr>
<td colspan="2">Nomor</td>
<td>: …...........................</td>
<td >Supplier Name</td>
<td colspan="2">: …...........................</td>
</tr>
<tr>
<td colspan="2">Tanggal Terima</td>
<td>: …...........................</td>
<td>Alamat</td>
<td colspan="2">: …...........................</td>
</tr>
<tr>
<td colspan="2">Nomor PO</td>
<td>: …...........................</td>
<td >Telepon</td>
<td colspan="2">: …...........................</td>
</tr>
<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<td>No.</td>
<td>Kode Stock</td>
<td>Deskripsi</td>
<td>Qty Order</td>
<td>Qty Terima</td>
<td>Qty BO</td>
</tr>
<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<td></td>
<td colspan="3">Note : …..........................................................</td>
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
<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<td colspan="2" border="1">Di Buat Oleh :</td>
<td>Di Setujui Oleh :</td>
<td colspan="2" >Total Stock Terima   :</td>
<td></td>
</tr>
<tr>
<td></td>
<td></td>
<td></td>
<td colspan="2">Total Qty Terima      :</td>
<td></td>
</tr>
<tr>
<td></td>
<td></td>
<td></td>
<td colspan="2">Total Qty BO            :</td>
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
      <div style="position: absolute; bottom: -13; right: 0;"></div>
  </body>
</html>