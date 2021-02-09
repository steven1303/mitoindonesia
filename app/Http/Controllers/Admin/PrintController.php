<?php

namespace App\Http\Controllers\Admin;

use App\Models\Spbd;
use App\Models\PoStock;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade  as PDF;
use App\Http\Controllers\Controller;

class PrintController extends Controller
{
    public function print_spbd($id)
    {
        $spbd = Spbd::findOrFail($id);
        $data = [
            'spbd' => $spbd
        ];
        $pdf = PDF::loadView('admin.content.pdf.print_spbd',$data);
        return $pdf->stream('print_spbd.pdf');
        // return view('admin.content.pdf.print_spbd')->with($data);
    }

    public function print_po_stock($id)
    {
        $po_stock = PoStock::findOrFail($id);
        $data = [
            'po_stock' => $po_stock
        ];
        $pdf = PDF::loadView('admin.content.pdf.print_po_stock',$data);
        return $pdf->setPaper('a4', 'landscape')->stream('print_po_stock.pdf');
        // return view('admin.content.pdf.print_spbd')->with($data);
    }
}
