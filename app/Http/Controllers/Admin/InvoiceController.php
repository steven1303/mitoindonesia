<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Sppb;
use App\Models\Invoice;
use App\Models\SppbDetail;
use App\Models\StockMaster;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
use App\Models\StockMovement;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\SettingAjaxController;

class InvoiceController extends SettingAjaxController
{
    public function index()
    {
        if(Auth::user()->can('invoice.view')){
            $data = [];
            return view('admin.content.inv')->with($data);
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
            return view('admin.content.inv_detail')->with($data);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('invoice.update')){
            $inv = Invoice::findOrFail($id);
            $data = array(
                "id" => $inv->id,
                "datemask2" => $inv->top_date,
                "sppb" => $inv->id_sppb,
                "sppb_no" => $inv->sppb->sppb_no,
                "customer_name" => $inv->sppb->customer->name,
                "customer" => $inv->id_customer,
                "po_cust" => $inv->po_cust,
                "inv_kirimke" => $inv->inv_kirimke,
                "inv_alamatkirim" => $inv->inv_alamatkirim,
                "mata_uang" => $inv->mata_uang,
            );
            return json_encode($data);
        }
        return response()->json(['code'=>200,'message' => 'Error Invoice Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

            $data = [
                'id_branch' => Auth::user()->id_branch,
                'inv_no' => $this->inv_no(),
                'id_sppb' => $request['sppb'],
                'id_customer' => $request['customer'],
                'po_cust' => $request['po_cust'],
                'inv_kirimke' => $request['inv_kirimke'],
                'inv_alamatkirim' => $request['inv_alamatkirim'],
                'mata_uang' => $request['mata_uang'],
                'date' => Carbon::now(),
                'top_date' => $request['top_date'],
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

    public function store_detail(Request $request, $id)
    {
        if(Auth::user()->can('invoice.store')){
            $inv = Invoice::findOrFail($id);
            $price = preg_replace('/\D/', '',$request['price']);
            $disc = preg_replace('/\D/', '',$request['disc']);
            $subtotal = ($request['qty'] * $price) - 0;
            $total_befppn = ($subtotal  - $disc ) - 0;
            $total_ppn = $total_befppn;
            if($inv->customer->status_ppn == 1){
                $total_ppn = ($total_befppn  + ($total_befppn * 0.1)) - 0;
            }
            $data = [
                'id_branch' => Auth::user()->id_branch,
                'id_inv' => $id,
                'id_sppb_detail' => $request['id_sppb_detail'],
                'id_stock_master' => $request['id_stock_master'],
                'qty' => $request['qty'],
                'price' => $price,
                'disc' => $disc,
                'subtotal' => $subtotal,
                'total_befppn' => $total_befppn,
                'total_ppn' => $total_ppn,
                'keterangan' => $request['keterangan'],
                'inv_detail_status' => 1,
            ];

            $activity = InvoiceDetail::create($data);

            $spbd_detail = SppbDetail::find($request['id_sppb_detail']);
            $spbd_detail->inv_qty = $request['qty'];
            $spbd_detail->update();


            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new item PO Stock Success', 'stat' => 'Success', 'process' => 'update']);

            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error item PO Stock Store', 'stat' => 'Error']);
            }
        }
        return response()->json(['code'=>200,'message' => 'Error Invoice Access Denied', 'stat' => 'Error']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::user()->can('invoice.update')){
            $data = Invoice::find($id);
            $data->id_sppb    = $request['sppb'];
            $data->id_customer    = $request['customer'];
            $data->po_cust    = $request['po_cust'];
            $data->inv_kirimke    = $request['inv_kirimke'];
            $data->inv_alamatkirim    = $request['inv_alamatkirim'];
            $data->mata_uang    = $request['mata_uang'];
            $data->top_date    = $request['top_date'];
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Edit Invoice Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error Invoice Access Denied', 'stat' => 'Error']);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
                $total_ppn = ($total_befppn  + ($total_befppn * 0.1)) - 0;
            }
            $data->price    = $price;
            $data->disc    = $disc;
            $data->keterangan    = $request['keterangan'];
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Edit Item Invoice Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error Invoice Access Denied', 'stat' => 'Error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('invoice.delete')){
            Invoice::destroy($id);
            return response()
                ->json(['code'=>200,'message' => 'Invoice Success Deleted', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error Invoice Access Denied', 'stat' => 'Error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_detail($id)
    {
        $inv_detail = InvoiceDetail::find($id);
        InvoiceDetail::destroy($id);
        $sppb_detail = SppbDetail::find($inv_detail->id_sppb_detail);
        $sppb_detail->inv_qty = $sppb_detail->inv_qty - $inv_detail->qty;
        $sppb_detail->update();
        return response()
            ->json(['code'=>200,'message' => 'Invoice item Success Deleted', 'stat' => 'Success']);
    }

    public function recordInv(){
        $data = Invoice::where([
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
                $invoice_detail = "javascript:ajaxLoad('".route('local.inv.detail.index', $data->id)."')";
                $action = "";
                $title = "'".$data->inv_no."'";
                if($data->inv_status == 1){
                    if($access->can('invoice.view')){
                        $action .= '<a href="'.$invoice_detail.'" class="btn btn-warning btn-xs"> Draf</a> ';
                    }
                    if($access->can('invoice.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('invoice.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                }
                if($data->inv_status == 2){
                    if($access->can('invoice.view')){
                        $action .= '<a href="'.$invoice_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('invoice.verify1')){
                        $action .= '<button id="'. $data->id .'" onclick="verify1('. $data->id .')" class="btn btn-info btn-xs"> Verify 1</button> ';
                    }
                    // fungsi untuk hilangkan print sebelum approval
                    // if($access->can('invoice.print')){
                    //     $action .= '<button id="'. $data->id .'" onclick="print_inv('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    // }
                    // fungsi untuk hilangkan print sebelum approval
                }
                if($data->inv_status == 3){
                    if($access->can('invoice.view')){
                        $action .= '<a href="'.$invoice_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('invoice.verify2')){
                        $action .= '<button id="'. $data->id .'" onclick="verify2('. $data->id .')" class="btn btn-info btn-xs"> Verify 2</button> ';
                    }
                    // fungsi untuk hilangkan print sebelum approval
                    // if($access->can('invoice.print')){
                    //     $action .= '<button id="'. $data->id .'" onclick="print_inv('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    // }
                    // fungsi untuk hilangkan print sebelum approval
                }
                if($data->inv_status == 4){
                    if($access->can('invoice.view')){
                        $action .= '<a href="'.$invoice_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('invoice.approve')){
                        $action .= '<button id="'. $data->id .'" onclick="approve('. $data->id .')" class="btn btn-info btn-xs"> Approve</button> ';
                    }
                    // fungsi untuk hilangkan print sebelum approval
                    // if($access->can('invoice.print')){
                    //     $action .= '<button id="'. $data->id .'" onclick="print_inv('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    // }
                    // fungsi untuk hilangkan print sebelum approval
                }
                if($data->inv_status == 5 || $data->inv_status == 6 || $data->inv_status == 7 || $data->inv_status == 8){
                    if($access->can('invoice.view')){
                        $action .= '<a href="'.$invoice_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('invoice.print')){
                        $action .= '<button id="'. $data->id .'" onclick="print_inv('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    }
                }
                return $action;
            })
            ->addColumn('sppb_no', function($data){
                return $data->sppb->sppb_no;
            })
            ->addColumn('total_inv', function($data){
                return "Rp. ".number_format($data->inv_detail->sum('total_ppn'),0, ",", ".");
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
                $action = "";
                $title = "'".$data->stock_master->name."'";
                if($data->invoice->inv_status == 1){
                    if($access->can('invoice.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('invoice.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                }
                if($data->invoice->inv_status == 2){
                    if($access->can('invoice.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                }
                if($inv_stat == 1){
                    $action .= '<button id="'. $data->id .'" onclick="addItem('. $data->id .')" class="btn btn-info btn-xs"> Add Item</button> ';
                }
                return $action;
            })
            ->addColumn('nama_stock', function($data){
                $action = $data->stock_master->name;
                return $action;
            })
            ->addColumn('satuan', function($data){
                $action = $data->stock_master->satuan;
                return $action;
            })
            ->addColumn('format_balance', function($data){
                return "Rp. ".number_format($data->price,0, ",", ".");
            })
            ->rawColumns(['action'])->make(true);
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
                $data->ppn = $data->inv_detail->sum('total') * 0.1;
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
