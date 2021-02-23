<?php

namespace App\Http\Controllers\Admin;

use App\Models\Spb;
use App\Models\Spbd;
use App\Models\Sppb;
use App\Models\Invoice;
use App\Models\PoStock;
use App\Models\RecStock;
use App\Models\Pelunasan;
use App\Models\PoNonStock;
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

    public function print_receipt($id)
    {
        $rec = RecStock::findOrFail($id);
        $data = [
            'rec' => $rec
        ];
        $pdf = PDF::loadView('admin.content.pdf.print_receipt',$data);
        return $pdf->setPaper('a4', 'landscape')->stream('print_receipt.pdf');
        // return view('admin.content.pdf.print_spbd')->with($data);
    }

    public function print_sppb($id)
    {
        $sppb = Sppb::findOrFail($id);
        $data = [
            'sppb' => $sppb
        ];
        $pdf = PDF::loadView('admin.content.pdf.print_sppb',$data);
        return $pdf->stream('print_sppb.pdf');
        // return view('admin.content.pdf.print_spbd')->with($data);
    }

    public function print_inv($id)
    {
        $inv = Invoice::findOrFail($id);
        $data = [
            'inv' => $inv
        ];
        $pdf = PDF::loadView('admin.content.pdf.print_invoice',$data);
        return $pdf->stream('print_invoice.pdf');
        // return view('admin.content.pdf.print_spbd')->with($data);
    }

    public function print_pelunasan($id)
    {
        $pelunasan = Pelunasan::findOrFail($id);
        $data = [
            'pelunasan' => $pelunasan
        ];
        $pdf = PDF::loadView('admin.content.pdf.print_pelunasan',$data);
        return $pdf->stream('print_invoice.pdf');
        // return view('admin.content.pdf.print_spbd')->with($data);
    }

    public function print_spb($id)
    {
        $spb = Spb::findOrFail($id);
        $data = [
            'spb' => $spb
        ];
        $pdf = PDF::loadView('admin.content.pdf.print_spb',$data);
        return $pdf->stream('print_spb.pdf');
        // return view('admin.content.pdf.print_spbd')->with($data);
    }

    public function print_po_non_stock($id)
    {
        $po_stock = PoNonStock::findOrFail($id);
        $data = [
            'po_stock' => $po_stock
        ];
        $pdf = PDF::loadView('admin.content.pdf.print_po_non_stock',$data);
        return $pdf->setPaper('a4', 'landscape')->stream('print_po_non_stock.pdf');
        // return view('admin.content.pdf.print_spbd')->with($data);
    }
}
