<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body style="border-style: groove;" width="1200px">
    <table width="98%" style="margin: auto; border-collapse: collapse;">
        <tbody>
            <tr>
                <td colspan="5">
                    <img src="{{ asset('img/PT_Mito_png.png') }}" width="120px" style="float:left">
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="7" style="height: 10px"></td>
            </tr>
            <tr>
                <td colspan="7" style="height: 10px"></td>
            </tr>
            <tr>
                <td colspan="7" Style="text-align: right">Branch : {{ $inv->branch->city }}</td>
            </tr>
            <tr>
                <td colspan="7" style="font-size: 20px; font-weight: bold; text-align: center;">INVOICE</td>
            </tr>
        </tbody>
    </table>

    <table width="98%" style="font-size: 15px; margin: auto; border-collapse: collapse;">
        <tbody>
            <tr>
                <td style="height: 20px;" width="10%"></td>
                <td style="height: 20px;" width="1%"></td>
                <td style="height: 20px;" width="30%"></td>
                <td style="height: 20px;" width="23%"></td>
                <td style="height: 20px;" width="11%"></td>
                <td style="height: 20px;" width="15%"></td>
                <td style="height: 20px;" width="5%"></td>
                <td style="height: 20px;" width="5%"></td>
            </tr>
            <tr>
                <td>Nomor</td>
                <td>:</td>
                <td colspan="2">{{ $inv->inv_no }}</td>
                <td>No PO</td>
                <td colspan="3">: {{ $inv->po_cust }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td colspan="2">{{ date('d/m/Y', strtotime($inv->date)) }}</td>
                <td>Mata Uang</td>
                <td colspan="3">: {{ $inv->mata_uang }}</td>
            </tr>
            <tr>
                <td>Kepada</td>
                <td>:</td>
                <td colspan="2">{{ $inv->customer->name }}</td>
                <td>Terms</td>
                <td colspan="3">: {{ date('d/m/Y', strtotime($inv->top_date)) }}</td>
            </tr>
            <tr>
                <td valign="top">Pengiriman</td>
                <td valign="top">:</td>
                <td colspan="2">{{ $inv->customer->address1 . ' ' . $inv->customer->address2 }}</td>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td colspan="8" style="height: 10px"></td>
            </tr>
        </tbody>
    </table>
    <table width="98%" style="font-size: 15px; margin: auto; border-collapse: collapse;">
        <tbody>
            <tr>
                <td width="5%" style="border: 1px solid black; text-align: center;">No</td>
                <td width="30%" style="border: 1px solid black; text-align: center;">Deskripsi</td>
                <td width="10%" style="border: 1px solid black; text-align: center;">Jumlah</td>
                <td width="10%" style="border: 1px solid black; text-align: center;">Unit</td>
                <td width="15%" style="border: 1px solid black; text-align: center;">Harga @</td>
                <td width="15%" style="border: 1px solid black; text-align: center;">Disc</td>
                <td width="15%" style="border: 1px solid black; text-align: center;">Sub Total</td>
            </tr>
            @if ($inv->id_sppb !== 0)
                @foreach ($inv->inv_detail as $detail)
                    <tr>
                        <td style="border: 1px solid black; text-align: center;">{{ $loop->iteration }}</td>
                        <td style="border: 1px solid black; text-align: left;">{{ $detail->stock_master->name }}</td>
                        <td style="border: 1px solid black; text-align: center;">{{ $detail->qty }}</td>
                        <td style="border: 1px solid black; text-align: center;">{{ $detail->stock_master->satuan }}
                        </td>
                        <td style="border: 1px solid black; text-align: center;">Rp.
                            {{ number_format($detail->price, 0, ',', '.') }}</td>
                        <td style="border: 1px solid black; text-align: center;">Rp.
                            {{ number_format($detail->disc, 0, ',', '.') }}</td>
                        <td style="border: 1px solid black; text-align: center;">Rp.
                            {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            @else
                @php
                    $inv_detail_new = $inv
                        ->inv_detail()
                        ->with('stock_master')
                        ->get();
                    $convert = collect($inv_detail_new)
                        ->groupBy('id_stock_master')
                        ->map(function ($row) {
                            return [
                                'price' => $row->first()->price,
                                'disc' => $row->sum('disc'),
                                'qty' => $row->sum('qty'),
                                'subtotal' => $row->sum('subtotal'),
                                'name' => $row->first()->stock_master->name,
                                'satuan' => $row->first()->stock_master->satuan,
                            ];
                        });
                    // dd($convert);
                @endphp
                @foreach ($convert as $detail)
                    <tr>
                        <td style="border: 1px solid black; text-align: center;">{{ $loop->iteration }}</td>
                        <td style="border: 1px solid black; text-align: left;">{{ $detail['name'] }}</td>
                        <td style="border: 1px solid black; text-align: center;">{{ $detail['qty'] }}</td>
                        <td style="border: 1px solid black; text-align: center;">{{ $detail['satuan'] }}
                        </td>
                        <td style="border: 1px solid black; text-align: center;">Rp.
                            {{ number_format($detail['price'], 0, ',', '.') }}</td>
                        <td style="border: 1px solid black; text-align: center;">Rp.
                            {{ number_format($detail['disc'], 0, ',', '.') }}</td>
                        <td style="border: 1px solid black; text-align: center;">Rp.
                            {{ number_format($detail['subtotal'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            @endif
            @for ($i = $inv->inv_detail->count(); $i < 10; $i++)
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
                <td colspan="4">Terbilang :</td>
                <td>Sub Total</td>
                <td colspan="2">: Rp. {{ number_format($inv->inv_detail->sum('total_befppn'), 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="4"> {{ $terbilang }}</td>
                <td>Tax</td>
                <td colspan="2">: Rp. {{ number_format($inv->ppn, 0, ',', '.') }} </td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td>Grand Total</td>
                <td colspan="2">: Rp. {{ number_format($inv->inv_detail->sum('total_ppn'), 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="7" style="height: 25px"></td>
            </tr>

        </tbody>
    </table>
    <table>
        <tbody>
            <tr>
                <td colspan="2">Rekening Tujuan Pembayaran</td>
            </tr>
            <tr>
                <td>Bank</td>
                <td>: Bank BNI Pekanbaru</td>
            </tr>
            <tr>
                <td>Atas nama</td>
                <td>: PT. Mito Energi Indonesia</td>
            </tr>
            <tr>
                <td>No Rekening </td>
                <td>: 122 819 044 9</td>
            </tr>
            <tr>
                <td style="height: 40px"></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <table width="98%" style="margin: auto; border-collapse: collapse;">
        <tbody>
            <tr>
                <td></td>
                <td style="text-align: center">Pembeli</td>
                <td></td>
                <td></td>
                <td style="text-align: center">PT. Mito Energi Indonesia</td>
            </tr>
            <tr>
                <td style="height: 100px"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: center">Tanggal : </td>
                <td></td>
                <td></td>
                <td style="text-align: center">Taufan</td>
            </tr>
            </tr>
        </tbody>
    </table>
</body>

</html>
