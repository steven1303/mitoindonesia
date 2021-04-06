<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Spb;
use App\Models\Spbd;
use App\Models\Sppb;
use App\Models\Invoice;
use App\Models\PoStock;
use App\Models\RecStock;
use App\Models\Pelunasan;
use App\Models\Adjustment;
use App\Models\PoInternal;
use App\Models\PoNonStock;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade  as PDF;
use App\Http\Controllers\Controller;

class PrintController extends Controller
{
    public function print_spbd($id)
    {
        $spbd = Spbd::findOrFail($id);
        $spbd->spbd_print = Carbon::now();
        $spbd->update();
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
        $po_stock->po_print = Carbon::now();
        $po_stock->update();
        $data = [
            'po_stock' => $po_stock
        ];
        $pdf = PDF::loadView('admin.content.pdf.print_po_stock',$data);
        // return $pdf->setPaper('a4', 'landscape')->stream('print_po_stock.pdf');
        return $pdf->stream('print_po_stock.pdf');
        // return view('admin.content.pdf.print_spbd')->with($data);
    }

    public function print_receipt($id)
    {
        $rec = RecStock::findOrFail($id);
        $rec->rec_print = Carbon::now();
        $rec->update();
        $data = [
            'rec' => $rec
        ];
        $pdf = PDF::loadView('admin.content.pdf.print_receipt',$data);
        // return $pdf->setPaper('a4', 'landscape')->stream('print_receipt.pdf');
        return $pdf->stream('print_receipt.pdf');
        // return view('admin.content.pdf.print_spbd')->with($data);
    }

    public function print_sppb($id)
    {
        $sppb = Sppb::findOrFail($id);
        $sppb->sppb_print = Carbon::now();
        $sppb->update();
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
        $inv->inv_print = Carbon::now();
        $inv->update();
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
        $pelunasan->pelunasan_print = Carbon::now();
        $pelunasan->update();
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
        $spb->spb_print = Carbon::now();
        $spb->update();
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
        $po_stock->po_print = Carbon::now();
        $po_stock->update();
        $data = [
            'po_stock' => $po_stock
        ];
        $pdf = PDF::loadView('admin.content.pdf.print_po_non_stock',$data);
        return $pdf->stream('print_po_non_stock.pdf');
        // return $pdf->setPaper('a4', 'landscape')->stream('print_po_non_stock.pdf');
    }

    public function print_adj($id)
    {
        $adj = Adjustment::findOrFail($id);
        $adj->adj_print = Carbon::now();
        $adj->update();
        $data = [
            'adj' => $adj
        ];
        $pdf = PDF::loadView('admin.content.pdf.print_adj',$data);
        return $pdf->stream('print_adj.pdf');
    }

    public function print_po_internal($id)
    {
        $po_internal = PoInternal::findOrFail($id);
        $po_internal->po_print = Carbon::now();
        $po_internal->update();
        $data = [
            'po_internal' => $po_internal
        ];
        $pdf = PDF::loadView('admin.content.pdf.print_po_internal',$data);
        return $pdf->stream('print_adj.pdf');
    }
}
