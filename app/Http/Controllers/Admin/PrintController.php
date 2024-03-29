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
use App\Models\Pembatalan;
use App\Models\PoInternal;
use App\Models\PoNonStock;
use App\Models\StockMaster;
use Illuminate\Http\Request;
use App\Models\RecStockDetail;
use App\Models\TransferBranch;
use App\Models\TransferReceipt;
use Barryvdh\DomPDF\Facade  as PDF;
use Illuminate\Support\Facades\Auth;
use Riskihajar\Terbilang\Facades\Terbilang;
use App\Http\Controllers\Admin\SettingsController;

class PrintController extends SettingsController
{
    public function print_spbd($id)
    {
        $spbd = Spbd::findOrFail($id);
        $spbd->spbd_print = Carbon::now();
        $spbd->update();
        $data = [
            'spbd' => $spbd
        ];
        if(Auth::user()->id_branch == 1)
        {
            $pdf = PDF::loadView('admin.content.pdf.print_spbd_pekanbaru',$data);
            return $pdf->stream('print_spbd.pdf');
        }
        if(Auth::user()->id_branch == 2)
        {
            $pdf = PDF::loadView('admin.content.pdf.print_spbd_medan',$data);
            return $pdf->stream('print_spbd.pdf');
        }
        if(Auth::user()->id_branch == 3)
        {
            $pdf = PDF::loadView('admin.content.pdf.print_spbd_pnk',$data);
            return $pdf->stream('print_spbd.pdf');
        }
        $pdf = PDF::loadView('admin.content.pdf.print_spbd_default',$data);
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
        if(Auth::user()->id_branch == 1)
        {
            $pdf = PDF::loadView('admin.content.pdf.print_po_stock_pekanbaru',$data);
            return $pdf->stream('print_po_stock.pdf');
        }
        if(Auth::user()->id_branch == 2)
        {
            $pdf = PDF::loadView('admin.content.pdf.print_po_stock_medan',$data);
            return $pdf->stream('print_po_stock.pdf');
        }
        if(Auth::user()->id_branch == 3)
        {
            $pdf = PDF::loadView('admin.content.pdf.print_po_stock_pnk',$data);
            return $pdf->stream('print_po_stock.pdf');
        }
        $pdf = PDF::loadView('admin.content.pdf.print_po_stock_default',$data);
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
        if(Auth::user()->id_branch == 1)
        {
            $pdf = PDF::loadView('admin.content.pdf.print_sppb_pekanbaru',$data);
            return $pdf->stream('print_sppb.pdf');
        }
        if(Auth::user()->id_branch == 2)
        {
            $pdf = PDF::loadView('admin.content.pdf.print_sppb_medan',$data);
            return $pdf->stream('print_sppb.pdf');
        }
        if(Auth::user()->id_branch == 3)
        {
            $pdf = PDF::loadView('admin.content.pdf.print_sppb_pnk',$data);
            return $pdf->stream('print_sppb.pdf');
        }
        $pdf = PDF::loadView('admin.content.pdf.print_sppb',$data);
        return $pdf->setPaper('a4', 'landscape')->stream('print_sppb.pdf');
        // return view('admin.content.pdf.print_spbd')->with($data);
    }

    public function print_inv($id)
    {
        // number_format($inv->inv_detail->sum('total_ppn') ,0, ",", ".")
        $inv = Invoice::findOrFail($id);
        $inv->inv_print = Carbon::now();
        $terbilang = Terbilang::make(number_format($inv->inv_detail->sum('total_ppn') ,0, ".", ""), ' rupiah', '');
        // dd($terbilang);
        $inv->update();
        $data = [
            'inv' => $inv,
            'terbilang' => $terbilang
        ];
        if(Auth::user()->id_branch == 1){
            $pdf = PDF::loadView('admin.content.pdf.print_invoice_pku',$data);
            return $pdf->stream('print_invoice_pku.pdf');
        }
        if(Auth::user()->id_branch == 2){
            $pdf = PDF::loadView('admin.content.pdf.print_invoice_medan',$data);
            return $pdf->stream('print_invoice_medan.pdf');
        }
        if(Auth::user()->id_branch == 3){
            $pdf = PDF::loadView('admin.content.pdf.print_invoice_pnk',$data);
            return $pdf->stream('print_invoice_pnk.pdf');
        }
        $pdf = PDF::loadView('admin.content.pdf.print_invoice_default',$data);
        return $pdf->stream('print_invoice_default.pdf');
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
        return $pdf->setPaper('a4', 'landscape')->stream('print_pelunasan.pdf');
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
        if(Auth::user()->id_branch == 1)
        {
            $pdf = PDF::loadView('admin.content.pdf.print_spb_pekanbaru',$data);
            return $pdf->stream('print_spb.pdf');
        }
        if(Auth::user()->id_branch == 2)
        {
            $pdf = PDF::loadView('admin.content.pdf.print_spb_medan',$data);
            return $pdf->stream('print_spb.pdf');
        }
        if(Auth::user()->id_branch == 3)
        {
            $pdf = PDF::loadView('admin.content.pdf.print_spb_pnk',$data);
            return $pdf->stream('print_spb.pdf');
        }
        $pdf = PDF::loadView('admin.content.pdf.print_spb_default',$data);
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
        if(Auth::user()->id_branch == 1)
        {
            $pdf = PDF::loadView('admin.content.pdf.print_po_non_stock_pekanbaru',$data);
            return $pdf->stream('print_po_non_stock.pdf');
        }
        if(Auth::user()->id_branch == 2)
        {
            $pdf = PDF::loadView('admin.content.pdf.print_po_non_stock_medan',$data);
            return $pdf->stream('print_po_non_stock.pdf');
        }
        if(Auth::user()->id_branch == 3)
        {
            $pdf = PDF::loadView('admin.content.pdf.print_po_non_stock_pnk',$data);
            return $pdf->stream('print_po_non_stock.pdf');
        }
        $pdf = PDF::loadView('admin.content.pdf.print_po_non_stock_default',$data);
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
        return $pdf->stream('print_po_internal.pdf');
    }

    public function print_pembatalan($id)
    {
        $pembatalan = Pembatalan::findOrFail($id);
        $pembatalan->po_print = Carbon::now();
        $pembatalan->update();
        $data = [
            'pembatalan' => $pembatalan
        ];
        $pdf = PDF::loadView('admin.content.pdf.print_pembatalan',$data);
        return $pdf->stream('print_pembatalan.pdf');
    }

    public function print_transfer($id)
    {
        // $transfer = TransferBranch::with('branch')->findOrFail($id);
        $transfer = TransferBranch::findOrFail($id);
        $transfer->transfer_print = Carbon::now();
        $transfer->update();
        // dd($transfer);
        $data = [
            'transfer' => $transfer
        ];
        $pdf = PDF::loadView('admin.content.pdf.print_transfer',$data);
        return $pdf->stream('print_transfer.pdf');
    }

    public function print_transfer_receipt($id)
    {
        $transfer = TransferReceipt::findOrFail($id);
        $transfer->receipt_transfer_print = Carbon::now();
        $transfer->update();
        $data = [
            'transfer_receipt' => $transfer
        ];
        $pdf = PDF::loadView('admin.content.pdf.print_transfer_receipt',$data);
        return $pdf->stream('print_transfer_receipt.pdf');
    }

    public function print_stock_soh()
    {
        
        $stock_master = StockMaster::where('id_branch','=', Auth::user()->id_branch)->latest()->get();
        $data = [
            'stock_master' => $stock_master
        ];

        if(Auth::user()->id_branch == 1)
        {
            $pdf = PDF::loadView('admin.content.pdf.print_stock_soh_pekanbaru',$data);
            return $pdf->setPaper('a4', 'landscape')->stream('print_stock_soh.pdf');
        }
        if(Auth::user()->id_branch == 2)
        {
            $pdf = PDF::loadView('admin.content.pdf.print_stock_soh_medan',$data);
            return $pdf->setPaper('a4', 'landscape')->stream('print_stock_soh.pdf');
        }
        if(Auth::user()->id_branch == 3)
        {
            $pdf = PDF::loadView('admin.content.pdf.print_stock_soh_pnk',$data);
            return $pdf->setPaper('a4', 'landscape')->stream('print_stock_soh.pdf');
        }
        $pdf = PDF::loadView('admin.content.pdf.print_stock_soh',$data);
        return $pdf->setPaper('a4', 'landscape')->stream('print_stock_soh.pdf');
    }

    public function print_po_list(){
        $po_list = PoStock::where('id_branch','=', Auth::user()->id_branch)->orderBy('po_no', 'desc')->get();
        $data = [
            'po_list' => $po_list
        ];
        $pdf = PDF::loadView('admin.content.pdf.print_po_list',$data);
        return $pdf->stream('print_po_list.pdf');
    }

    public function print_po_receipt_report(){
        $po_receipt = RecStock::where('id_branch','=', Auth::user()->id_branch)->orderBy('rec_no', 'desc')->get();
        $data = [
            'rec_stock' => $po_receipt
        ];
        $pdf = PDF::loadView('admin.content.pdf.print_rec_custom_list',$data);
        return $pdf->stream('print_rec_custom_list.pdf');
    }
}
