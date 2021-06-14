<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- <style>
        table, th, td {
          border: 1px solid black;
          border-collapse: collapse;
          text-align: center;
        }
        </style> -->
</head>
    <body>
       
    <table width="100%" style="margin: auto; text-align: center; border-collapse: collapse;">
            <tbody>
                <tr>
                    <td style="height: 20px;" width="35%" ><img src="{{asset('img/PT_Mito_png.png')}}" width="120px" style="float:left"></td>
                    <td style="height: 20px; font-size: 30px; font-weight: bold;" width="35%">Stock Master</td>
                    <td style="height: 20px; text-align: right;" width="35%" ></td>
                </tr>
                <tr>
                    <td colspan="5" style="font-size: 20px; font-weight: bold;">( SOH )</td>
                </tr>
            </tbody>
        </table>
        <table  width="100%" style="margin: auto; text-align: center; border-collapse: collapse;">
            <tbody>
                
                <tr>
                    <td style="height: 20px;" width="7%"></td>
                    <td style="height: 20px;" width="30%"></td>
                    <td style="height: 20px;" width="18%"></td>
                    <td style="height: 20px;" width="15%"></td>
                    <td style="height: 20px;" width="30%"></td>
                </tr>
            <tbody>
        </table>

        <table width="100%" style="margin: auto; text-align: center; border-collapse: collapse;">
            <tbody>
            <tr>
                <td style="border: 1px solid black; font-weight: bold;">No</td>
                <td style="border: 1px solid black; font-weight: bold;">Kode Stock</td>
                <td style="border: 1px solid black; font-weight: bold;">Stock Name</td>
                <td style="border: 1px solid black; font-weight: bold;">Bin</td>
                <td style="border: 1px solid black; font-weight: bold;">Satuan</td>
                <td style="border: 1px solid black; font-weight: bold;">SOH</td>
                <td style="border: 1px solid black; font-weight: bold;">Harga Modal</td>
                <td style="border: 1px solid black; font-weight: bold;">Harga Jual</td>
            </tr>
            @php
            $i = 1;
            @endphp
            @foreach ($stock_master as $detail)
            @php
                $soh =  $detail->stock_movement()->where([['in_qty','>', 0],['status','=', 0]])->sum('in_qty') - $detail->stock_movement()->where([['out_qty','>', 0],['status','=', 0]])->sum('out_qty');                
            @endphp
            @if($soh > 0)
            <tr style="border: 1px solid black;">
                <td style="border: 1px solid black;">{{ $i++ }}</td>
                <td style="border: 1px solid black; text-align: left">{{ $detail->stock_no }}</td>
                <td style="border: 1px solid black; text-align: left">{{ $detail->name}}</td>
                <td style="border: 1px solid black;">{{ $detail->bin}}</td>
                <td style="border: 1px solid black; text-align: right">{{ $detail->satuan}}</td>
                <td style="border: 1px solid black; text-align: right">{{ $soh }}</td>
                <td style="border: 1px solid black; text-align: right">{{ "Rp. ".number_format($detail->harga_modal,0, ",", ".") }}</td>
                <td style="border: 1px solid black; text-align: right">{{ "Rp. ".number_format($detail->harga_jual,0, ",", ".") }}</td>
            </tr>
            @endif
            @endforeach
            </tbody>
        </table>
    </body>
</html>
