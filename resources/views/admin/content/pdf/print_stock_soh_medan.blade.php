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
                    <td style="height: 20px; text-align: right;" width="35%" >Branch : Medan</td>
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
                    <td style="height: 20px;" width="3%"></td>
                    <td style="height: 20px;" width="12%"></td>
                    <td style="height: 20px;" width="20%"></td>
                    <td style="height: 20px;" width="8%"></td>
                    <td style="height: 20px;" width="8%"></td>
                    <td style="height: 20px;" width="5%"></td>
                    <td style="height: 20px;" width="10%"></td>
                    <td style="height: 20px;" width="10%"></td>
                    <td style="height: 20px;" width="12%"></td>
                    <td style="height: 20px;" width="12%"></td>
                </tr>
            <tr>
                <td style="border: 1px solid black; font-weight: bold;">No</td>
                <td style="border: 1px solid black; font-weight: bold;">Kode Stock</td>
                <td style="border: 1px solid black; font-weight: bold;">Stock Name</td>
                <td style="border: 1px solid black; font-weight: bold;">Bin</td>
                <td style="border: 1px solid black; font-weight: bold;">Satuan</td>
                <td style="border: 1px solid black; font-weight: bold;">SOH</td>
                <td style="border: 1px solid black; font-weight: bold;">Harga Modal</td>
                <td style="border: 1px solid black; font-weight: bold;">Harga Jual</td>
                <td style="border: 1px solid black; font-weight: bold;">Jumlah Harga Modal</td>
                <td style="border: 1px solid black; font-weight: bold;">Jumlah Harga Jual</td>
            </tr>
            @php
            $i = 1;
            $total_harga_modal = 0;
            $total_harga_jual = 0;
            @endphp
            @foreach ($stock_master as $detail)
            @php
                $soh =  $detail->stock_movement()->where([['in_qty','>', 0],['status','=', 0]])->sum('in_qty') - $detail->stock_movement()->where([['out_qty','>', 0],['status','=', 0]])->sum('out_qty'); 
                if($detail->stock_no != "JSA 01 CCB"){
                    $total_harga_modal = $total_harga_modal + ($detail->harga_modal * $soh);
                    $total_harga_jual = $total_harga_jual + ($detail->harga_jual * $soh);
                }
            @endphp
            @if($soh > 0 && $detail->stock_no != "JSA 01 CCB" )
            <tr style="border: 1px solid black;">
                <td style="font-size: 13px; border: 1px solid black;">{{ $i++ }}</td>
                <td style="font-size: 13px; border: 1px solid black; text-align: left">{{ $detail->stock_no }}</td>
                <td style="font-size: 13px; border: 1px solid black; text-align: left">{{ $detail->name}}</td>
                <td style="font-size: 13px; border: 1px solid black;">{{ $detail->bin}}</td>
                <td style="font-size: 13px; border: 1px solid black; text-align: right">{{ $detail->satuan}}</td>
                <td style="font-size: 13px; border: 1px solid black; text-align: right">{{ "".number_format(($soh),0, ",", ".") }}</td>
                <td style="font-size: 13px; border: 1px solid black; text-align: right">{{ "Rp. ".number_format($detail->harga_modal,0, ",", ".") }}</td>
                <td style="font-size: 13px; border: 1px solid black; text-align: right">{{ "Rp. ".number_format($detail->harga_jual,0, ",", ".") }}</td>
                <td style="font-size: 13px; border: 1px solid black; text-align: right">{{ "Rp. ".number_format( ( $detail->harga_modal * $soh),0, ",", ".")  }}</td>
                <td style="font-size: 13px; border: 1px solid black; text-align: right">{{ "Rp. ".number_format( ( $detail->harga_jual * $soh),0, ",", ".")  }}</td>
            @endif
            @endforeach
            </tr>
            <tr>
                <td colspan="8" style="font-weight: bold; text-align: right"> TOTAL : </td>
                <td style="font-weight: bold;">{{ "Rp. ".number_format($total_harga_modal,0, ",", ".") }}</td>
                <td style="font-weight: bold;">{{ "Rp. ".number_format($total_harga_jual,0, ",", ".") }}</td>
            </tr>
            <tr>
                <td colspan="8" style="font-weight: bold; text-align: right">Margin :  </td>
                <td colspan="2" style="font-weight: bold;">{{ "Rp. ".number_format( ($total_harga_jual - $total_harga_modal),0, ",", ".") }}</td>
            </tr>
            </tbody>
        </table>
    </table>
    </body>
</html>
