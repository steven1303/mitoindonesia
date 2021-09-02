
<!DOCTYPE html>
  <html lang="en">
     <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
          <title>Document</title>
      </head>
      <body style="border-style: groove;" width="1200px" >
        <table width="98%" style="margin: auto; border-collapse: collapse;">
            <tbody>
                <tr>
                    <td colspan="5">
                        <img src="{{asset('img/PT_Mito_png.png')}}" width="120px" style="float:left">
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="6" style="height: 10px"></td>
                </tr>
                <tr>
                    <td colspan="6" style="height: 10px"></td>
                </tr>
                <tr>
                <td colspan="6" Style="text-align: right" >Branch : {{ $adj->branch->city }}</td>
                </tr>
                <tr>
                <td colspan="6" style="font-size: 20px; font-weight: bold; text-align: center;">ADJUSTMENT</td>
                </tr>
            </tbody>
        </table>

        <table width="98%" style="margin: auto; border-collapse: collapse;">
            <tbody>
                <tr>
                    <td colspan="2" style="height: 20px"></td>
                </tr>
                <tr>
                    <td width=100px>Nomor</td>
                    <td>: {{ $adj->adj_no }}</td>
                </tr>
                <tr>
                    <td>Tanggal </td>
                    <td>: {{ $adj->created_at}}</td>
                </tr>
                <tr>
                    <td colspan="2" style="height: 20px"></td>
                </tr>
            </tbody>
        </table>
        <table width="98%" style="margin: auto; border-collapse: collapse;">
            <tbody>
                <tr>
                    <td width="5%" style="border: 1px solid black; text-align: center;">No</td>
                    <td width="15%" style="border: 1px solid black; text-align: center;">Kode Produk</td>
                    <td width="30%" style="border: 1px solid black; text-align: center;">Nama Produk</td>
                    <td width="10%" style="border: 1px solid black; text-align: center;">Satuan</td>
                    <td width="10%" style="border: 1px solid black; text-align: center;">In</td>
                    <td width="10%" style="border: 1px solid black; text-align: center;">Out</td>
                    <td width="20%" style="border: 1px solid black; text-align: center;">Keterangan</td>
                </tr>
                @foreach ($adj->adj_detail as $detail)
                    <tr>
                        <td style="border: 1px solid black; text-align: center;">{{ $loop->iteration }}</td>
                        <td style="border: 1px solid black; text-align: center;">{{ $detail->stock_master->stock_no }}</td>
                        <td style="border: 1px solid black; text-align: center;">{{ $detail->stock_master->name }}</td>
                        <td style="border: 1px solid black; text-align: center;">{{ $detail->stock_master->satuan }}</td>
                        <td style="border: 1px solid black; text-align: center;">{{ $detail->in_qty }}</td>
                        <td style="border: 1px solid black; text-align: center;">{{ $detail->out_qty }}</td>
                        <td style="border: 1px solid black; text-align: center;">{{ $detail->keterangan }}</td>
                    </tr>
                @endforeach
                @for ($i = $adj->adj_detail->count(); $i < 10; $i++)
                <tr style="border: 1px solid black; height: 20px;">
                    <td style="border: 1px solid black; height: 20px;"></td>
                    <td style="border: 1px solid black; height: 20px;"></td>
                    <td style="border: 1px solid black; height: 20px;"></td>
                    <td style="border: 1px solid black; height: 20px;"></td>
                    <td style="border: 1px solid black; height: 20px;"></td>
                    <td style="border: 1px solid black; height: 20px;"></td>
                    <td style="border: 1px solid black; height: 20px;"></td>
                </tr>
                @endfor
                <tr>
                    <td colspan="7" style="height: 25px"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3" style="text-align: center;" >Dibuat Oleh</td>
                    <td colspan="2" style="text-align: right;">Total Qty In</td>
                    <td>: {{ $adj->adj_detail->sum('in_qty') }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3" rowspan="2" style="text-align: center;"> <img src="{{asset('img/ttd_abas_png.png')}}" width="120px" > </td>
                    <td colspan="2" style="text-align: right;">Total Qty Out</td>
                    <td>: {{ $adj->adj_detail->sum('out_qty') }}</td>
                </tr>
                <tr>
                    <td colspan="7" style="height: 50px">  </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3" style="text-align: center;">( ABAS SUSILO )</td>
                    <td colspan="3"></td>
                </tr>
            </tbody>
        </table>
    
</body>
</html>