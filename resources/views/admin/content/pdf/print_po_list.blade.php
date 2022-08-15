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
                    <td colspan="5" style="font-size: 20px; font-weight: bold;">( PO List )</td>
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
                </tr>
            <tr>
                <td style="border: 1px solid black; font-weight: bold;">No</td>
                <td style="border: 1px solid black; font-weight: bold;">Kode PO</td>
                <td style="border: 1px solid black; font-weight: bold;">Vendor</td>
                <td style="border: 1px solid black; font-weight: bold;">Total</td>
                <td style="border: 1px solid black; font-weight: bold;">Status</td>
            </tr>
            @php
            $i = 1;
            @endphp
            @foreach ($po_list as $detail)
            <tr>
                <td style="border: 1px solid black; font-weight: bold;">{{ $i++ }}</td>
                <td style="border: 1px solid black; font-weight: bold;">{{$detail->po_no}}</td>
                <td style="border: 1px solid black; font-weight: bold;">{{$detail->vendor->name}}</td>
                <td style="border: 1px solid black; font-weight: bold;">{{ "Rp. ".number_format($detail->po_stock_detail->sum('total'),0, ",", ".") }}</td>
                <td style="border: 1px solid black; font-weight: bold;">
                    @php
                        $po_status = "";
                        if($detail->po_status == 1){
                            $po_status = "Draft";
                        }elseif ($detail->po_status == 2) {
                            $po_status = "Request";
                        }elseif ($detail->po_status == 3) {
                            $po_status = "Verified 1";
                        }elseif ($detail->po_status == 4) {
                            $po_status = "Verified 2";
                        }elseif ($detail->po_status == 5) {
                            $po_status = "Approved";
                        }elseif ($detail->po_status == 6) {
                            $po_status = "Partial";
                        }elseif ($detail->po_status == 7) {
                            $po_status = "Closed";
                        }else {
                            $po_status = "Reject";
                        }
                    @endphp
                    {{$po_status}}
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </table>
    </body>
</html>
