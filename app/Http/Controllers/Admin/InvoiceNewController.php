<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Sppb;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\StockMaster;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
use App\Models\StockMovement;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Traits\InvoiceNew;
use App\Http\Controllers\Admin\SettingAjaxController;

class InvoiceNewController extends SettingAjaxController
{
    use InvoiceNew;
    public function index()
    {
        if(Auth::user()->can('invoice.view')){
            $data = [];
            return view('admin.content.inv_new')->with($data);
        }
        return view('admin.components.403');
    }

    public function detail($id)
    {
        if(Auth::user()->can('invoice.view')){
            $inv = Invoice::findOrFail($id);
            $data = [
                'invoice' => $inv
            ];
            return view('admin.content.inv_detail_new')->with($data);
        }
        return view('admin.components.403');
    }

    public function inv_no(){
        $tanggal = Carbon::now();
        $format = 'INV/'.Auth::user()->branch->name.'/'.$tanggal->format('y').'/'.$tanggal->format('m');
        $inv_no = Invoice::where([
            ['inv_no','like', $format.'%'],
            ['id_branch','=', Auth::user()->id_branch]
        ])->count() + 1;
        return $format.'/'.sprintf("%03d", $inv_no);
    }

    public function store(Request $request)
    {
        if(Auth::user()->can('invoice.store')){
            $draf = Invoice::where([
                ['inv_status','=', 1],
                ['id_branch','=', Auth::user()->id_branch]
            ])->count();

            $sppb = Invoice::where([
                ['id_sppb','=', $request['sppb']],
                ['id_branch','=', Auth::user()->id_branch],
                ['inv_status','<>', 8]
            ])->count();

            if($sppb > 0){
                return response()
                    ->json(['code'=>200,'message' => 'SPPB is already used', 'stat' => 'Error']);
            }

            if($draf > 0){
                return response()
                    ->json(['code'=>200,'message' => 'Use the previous Draf Invoice First', 'stat' => 'Error']);
            }

            $customer = Customer::find($request['customer']);

            $data = [
                'id_branch' => Auth::user()->id_branch,
                'inv_no' => $this->inv_no(),
                'id_sppb' => 0,
                'id_customer' => $request['customer'],
                'po_cust' => 'Null',
                'inv_kirimke' => $customer->address1,
                'inv_alamatkirim' => $customer->address1,
                'mata_uang' => "RUPIAH",
                'date' => Carbon::now(),
                'top_date' => Carbon::now(),
                'inv_status' => 1,
                'user_id' => Auth::user()->id,
                'user_name' => Auth::user()->name,
            ];

            $activity = Invoice::create($data);

            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new Invoice Success' , 'stat' => 'Success', 'inv_id' => $activity->id, 'process' => 'add']);

            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error Invoice Store', 'stat' => 'Error']);
            }
        }
        return response()->json(['code'=>200,'message' => 'Error Invoice Access Denied', 'stat' => 'Error']);
    }

    public function edit_detail($id)
    {
        if(Auth::user()->can('invoice.update')){
            $inv_detail = InvoiceDetail::findOrFail($id);
            $data = array(
                "id" => $inv_detail->id,
                "id_sppb_detail" => $inv_detail->id_sppb_detail,
                "id_stock_master" => $inv_detail->id_stock_master,
                "stock_master" => $inv_detail->stock_master->name,
                "qty" => $inv_detail->qty - 0,
                "satuan" => $inv_detail->stock_master->satuan,
                "keterangan1" => $inv_detail->sppb_detail->keterangan,
                "price" => $inv_detail->price,
                "disc" => $inv_detail->disc - 0,
                "keterangan" => $inv_detail->keterangan,
            );
            return json_encode($data);
        }
        return response()->json(['code'=>200,'message' => 'Error Invoice Access Denied', 'stat' => 'Error']);
    }

    public function update($id, Request $request){
        if(Auth::user()->can('invoice.update')){
            $data = Invoice::find($id);
            $data->top_date    = $request['top_date'];
            $data->po_cust    = $request['po_cust'];
            $data->mata_uang    = $request['mata_uang'];
            $data->inv_alamatkirim    = $request['inv_alamatkirim'];
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Edit Invoice Detail Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error Invoice Access Denied', 'stat' => 'Error']);
    }

    public function update_detail(Request $request, $id)
    {
        if(Auth::user()->can('invoice.update')){
            $data = InvoiceDetail::find($id);
            $price = preg_replace('/\D/', '',$request['price']);
            $disc = preg_replace('/\D/', '',$request['disc']);
            $subtotal = ($request['qty'] * $price) - 0;
            $total_befppn = ($subtotal  - $disc ) - 0;
            $total_ppn = $total_befppn;
            if($data->invoice->customer->status_ppn == 1){
                $total_ppn = ($total_befppn  + ($total_befppn * 0.11)) - 0;
            }
            $data->price    = $price;
            $data->subtotal    = $subtotal;
            $data->total_befppn    = $total_befppn;
            $data->total_ppn    = $total_ppn;
            $data->disc    = $disc;
            $data->keterangan    = $request['keterangan'];
            $data->update();
            if($data->invoice->inv_status != 1){
                if($data->invoice->customer->status_ppn == 1){
                    $data->invoice->ppn = $data->invoice->inv_detail->sum('total') * 0.11;
                    $data->invoice->update();
                }
            }
            return response()
                ->json(['code'=>200,'message' => 'Edit Item Invoice Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error Invoice Access Denied', 'stat' => 'Error']);
    }

    public function destroy($id)
    {
        if(Auth::user()->can('invoice.delete')){
            Invoice::destroy($id);
            return response()
                ->json(['code'=>200,'message' => 'Invoice Success Deleted', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error Invoice Access Denied', 'stat' => 'Error']);
    }

    public function destroy_detail($id){
        $sppb = Sppb::find($id);
        $sppb->invoice_id = 0;        
        foreach ($sppb->sppb_detail as $detail) {
            InvoiceDetail::where('id_sppb_detail', $detail->id)->delete();
        }
        $sppb->update();
    }

    public function recordInv(){
        $data = Invoice::where([
            ['id_sppb','=', 0],
            ['id_branch','=', Auth::user()->id_branch],
        ])->latest()->get();
        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status_inv', function($data){
                $action = "";
                if($data->inv_status == 1){
                    $action = "Draf";
                }elseif($data->inv_status == 2){
                    $action = "Request";
                }elseif($data->inv_status == 3){
                    $action = "Verified 1";
                }elseif($data->inv_status == 4){
                    $action = "Verified 2";
                }elseif($data->inv_status == 5){
                    $action = "Approved";
                }elseif($data->inv_status == 6){
                    $action = "Partial";
                }elseif($data->inv_status == 7){
                    $action = "Closed";
                }
                else{
                    $action = "Batal";
                }
                return $action;
            })
            ->addColumn('action', function($data) use($access){
                return $this->button_list($data, $access);
            })
            ->addColumn('total_inv', function($data){
                // return $data->inv_detail->sum('total_ppn');
                return "Rp. ".number_format($data->inv_detail->sum('total_ppn'),0, ",", ".");
            })
            ->rawColumns(['action'])->make(true);
    }

    public function recordListSppb($invoice, $customer){
        if($invoice == 0){
            $data = Sppb::where([
                ['id_branch','=', Auth::user()->id_branch],
                ['id_customer','=', $customer],
                ['sppb_status','=', 5],
                ['invoice_id','=', 0],
            ])->latest()->get();
        }else{
            $data = Sppb::where([
                ['id_branch','=', Auth::user()->id_branch],
                ['id_customer','=', $customer],
                ['sppb_status','=', 5],
                ['invoice_id','=', $invoice],
            ])->latest()->get();
        }
        
        $access =  Auth::user();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data) use($access){
                return $this->button_sppb_list_add($data, $access);
            })
            ->rawColumns(['action'])->make(true);
    }

    public function recordInv_detail($id, $inv_stat = NULL){
        $data = InvoiceDetail::where([
            ['id_branch','=', Auth::user()->id_branch],
            ['id_inv','=', $id],
        ])->latest()->get();
        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data)  use($inv_stat, $access){
                return $this->button_edit_invoice_detail($data, $inv_stat, $access);
            })
            ->addColumn('nama_stock', function($data){
                $action = $data->stock_master->name;
                return $action;
            })
            ->addColumn('satuan', function($data){
                $action = $data->stock_master->satuan;
                return $action;
            })
            ->addColumn('sppb_no', function($data){
                $action = $data->sppb_detail->sppb->sppb_no;
                return $action;
            })
            ->addColumn('format_balance', function($data){
                return "Rp. ".number_format($data->price,0, ",", ".");
            })
            ->rawColumns(['action'])->make(true);
    }

    public function addInvoiceSppb($invoice, $sppb){
        $sppb = Sppb::find($sppb);
        if($sppb->invoice_id != 0){
            return response()
                ->json(['code'=>200,'message' => 'Error SPPB already used for invoice '.$sppb->invoice_id, 'stat' => 'Error']); 
        }
        $sppb->invoice_id = $invoice;
        $sppb->update();

        foreach ($sppb->sppb_detail as $item_sppb) {
            $data = [
                'id_branch' => Auth::user()->id_branch,
                'id_inv' => $invoice,
                'id_sppb_detail' => $item_sppb->id,
                'id_stock_master' => $item_sppb->id_stock_master,
                'qty' => $item_sppb->qty,
                'price' => 0,
                'disc' => 0,
                'subtotal' => 0,
                'total_befppn' => 0,
                'total_ppn' => 0,
                'keterangan' => '-',
                'inv_detail_status' => 1,
            ];
            $activity = InvoiceDetail::create($data);            
        }

        return response()
            ->json(['code'=>200,'message' => 'Add new SPPB Success' , 'stat' => 'Success', 'process' => 'add']);
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function inv_open($id)
    {
        if(Auth::user()->can('invoice.open')){
            $data = Invoice::findOrFail($id);
            if($data->sppb->sppb_detail->count() != $data->inv_detail->count())
            {
                return response()->json(['code'=>200,'message' => 'SPBD Invoice still have detail not added.', 'stat' => 'Error']);
            }
            $data->inv_status = 2;
            $data->ppn = 0;
            $data->inv_open = Carbon::now();
            if($data->customer->status_ppn == 1){
                $data->ppn = $data->inv_detail->sum('total') * 0.11;
            }
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Request Invoice Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error Invoice Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verify1($id)
    {
        if(Auth::user()->can('invoice.verify1')){
            $data = Invoice::findOrFail($id);
            $data->inv_status = 3;
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Invoice Verified 1 Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error Invoice Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verify2($id)
    {
        if(Auth::user()->can('invoice.verify2')){
            $data = Invoice::findOrFail($id);
            $data->inv_status = 4;
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Invoice Verified 2 Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error Invoice Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        if(Auth::user()->can('invoice.approve')){
            $data = Invoice::findOrFail($id);
            $data->inv_status = 5;
            $this->inv_movement($data->inv_detail);
            $data->update();
            $sppd = Sppb::findOrFail($data->id_sppb);
            $sppd->sppb_status = 5;
            $sppd->update();
            return response()
                ->json(['code'=>200,'message' => 'SPBD Approve Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error Invoice Access Denied', 'stat' => 'Error']);
    }

    public function inv_movement($data)
    {
        foreach ($data as $detail ) {
            $data = [
                'id_stock_master' => $detail->id_stock_master,
                'id_branch' => $detail->id_branch,
                'move_date' => $detail->invoice->date,
                'type' => 'INV',
                'doc_no' => $detail->invoice->inv_no,
                'order_qty' => 0,
                'sell_qty' => $detail->qty,
                'in_qty' => 0,
                'out_qty' => 0,
                'harga_modal' => 0,
                'harga_jual' => $detail->price,
                'user' => Auth::user()->name,
                'ket' => 'SPPB ('.$detail->sppb_detail->sppb->sppb_no.')',
            ];

            $movement = StockMovement::create($data);
            $stock_master = StockMaster::find($detail->id_stock_master);
            $stock_master->harga_jual = $detail->price;
            $stock_master->update();
        }
    }

    public function pembatalan($id)
    {
        if(Auth::user()->can('invoice.reject')){
            $data = Invoice::findOrFail($id);
            // status verify 1 & 2
            if($data->inv_status == 3 ||  $data->inv_status == 4 )
            {
                $data->inv_status = 2;
                $data->update();
                return response()
                    ->json(['code'=>200,'message' => 'Invoice Reject Success', 'stat' => 'Success']);
            }
            return response()
                    ->json(['code'=>200,'message' => 'Invoice Sudah ada / SPPB tidak bisa di revisi', 'stat' => 'Error']);
        }
        return response()->json(['code'=>200,'message' => 'Error Invoice Access Denied', 'stat' => 'Error']);
    }
}
