<?php

namespace App\Http\Controllers\Admin;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\StockMovement;
use App\Models\TransferDetail;
use App\Models\TransferReceipt;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\TransferReceiptDetail;
use App\Http\Controllers\Admin\SettingAjaxController;
use App\Http\Requests\Admin\StoreDetailTransferReceiptRequest;
use App\Http\Requests\Admin\UpdateDetailTransferReceiptRequest;

class TransferReceiptController extends SettingAjaxController
{
    public function index()
    {
        if(Auth::user()->can('transfer.receipt.view')){
            $data = [];
            return view('admin.content.transfer_receipt')->with($data);
        }
        return view('admin.components.403');
    }

    public function detail($id)
    {
        if(Auth::user()->can('transfer.receipt.view')){
            $transfer = TransferReceipt::findOrFail($id);
            $data = [
                'transfer' => $transfer
            ];
            return view('admin.content.transfer_receipt_detail')->with($data);
        }
        return view('admin.components.403');
    }

    public function transfer_receipt_no(){
        $tanggal = Carbon::now();
        $format = 'TR/'.Auth::user()->branch->name.'/'.$tanggal->format('y').'/'.$tanggal->format('m');
        $transfer = TransferReceipt::where([
            ['receipt_transfer_no','like', $format.'%'],
            ['id_branch','=', Auth::user()->id_branch]
        ])->count() + 1;
        return $format.'/'.sprintf("%03d", $transfer);
    }

    public function store(Request $request)
    {
        if(Auth::user()->can('transfer.receipt.store')){
            $draf = TransferReceipt::where([
                ['receipt_transfer_status','=', 1],
                ['id_branch','=', Auth::user()->id_branch]
            ])->count();

            if($draf > 0){
                return response()
                    ->json(['code'=>200,'message' => 'Use the previous Draf Transfer Receipt First', 'stat' => 'Warning']);
            }
            $data = [
                'id_branch' => Auth::user()->id_branch,
                'id_transfer' => $request['id_transfer'],
                'receipt_transfer_no' => $this->transfer_receipt_no(),
                'from_branch' => $request['id_branch'],
                'receipt_transfer_date' => Carbon::now(),
                'receipt_transfer_status' => 1,
                'keterangan' => $request['keterangan'],
                'user_id' => Auth::user()->id,
                'user_name' => Auth::user()->name,
            ];

            $activity = TransferReceipt::create($data);

            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new Transfer Receipt Success' , 'stat' => 'Success', 'id' => $activity->id, 'process' => 'add']);

            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error Transfer Receipt Store', 'stat' => 'Error']);
            }
        }
        return response()->json(['code'=>200,'message' => 'Error Transfer Receipt Access Denied', 'stat' => 'Error']);
    }

    public function store_detail(StoreDetailTransferReceiptRequest $request, $id)
    {
        if(Auth::user()->can('transfer.receipt.update')){
            $data = [
                'id_branch' => Auth::user()->id_branch,
                'id_receipt_transfer' => $id,
                'id_transfer_detail' => $request['id_transfer_detail'],
                'id_stock_master_from' => $request['id_stock_master_from'],
                'id_stock_master' => $request['stock_master'],
                'qty' => $request['terima'],
                // 'price' => preg_replace('/\D/', '',$request['price']),
                'keterangan' => $request['keterangan'],
                'transfer_receipt_detail_status' => 1,
            ];
            $activity = TransferReceiptDetail::create($data);
            $transfer_detail = TransferDetail::find($request['id_transfer_detail']);
            $transfer_detail->rec_qty = $transfer_detail->rec_detail->sum('qty');
            $transfer_detail->update();
            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new item Transfer Receipt Success', 'stat' => 'Success', 'process' => 'update']);

            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error item Transfer Receipt Store', 'stat' => 'Error']);
            }
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Receipt Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('transfer.receipt.update')){
            $data = TransferReceipt::with('from')->findOrFail($id);
            return $data;
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Transfer Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_detail($id)
    {
        if(Auth::user()->can('transfer.receipt.update')){
            $data = TransferReceiptDetail::with(['stock_master_from','stock_master','transfer_detail'])->findOrFail($id);
            return $data;
        }
        return response()->json(['code'=>200,'message' => 'Error Transfer Access Denied', 'stat' => 'Error']);
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
        if(Auth::user()->can('transfer.receipt.update')){
            $data = TransferReceipt::find($id);
            $data->keterangan    = $request['keterangan'];
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Edit Transfer Receipt Success', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Transfer Receipt Access Denied', 'stat' => 'Error']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_detail(UpdateDetailTransferReceiptRequest $request, $id)
    {
        if(Auth::user()->can('transfer.receipt.update')){
            $data = TransferReceiptDetail::find($id);
            $data->id_stock_master    = $request['stock_master'];
            // $data->qty    = $request['terima'];
            $data->keterangan    = $request['keterangan'];
            $data->update();

            $transfer_detail = TransferDetail::find($data->id_transfer_detail);
            $transfer_detail->rec_qty = $transfer_detail->rec_detail->sum('qty');
            $transfer_detail->update();

            return response()
                ->json(['code'=>200,'message' => 'Edit Item Transfer Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error Transfer Access Denied', 'stat' => 'Error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('transfer.receipt.delete')){
            $data = TransferReceipt::find($id);
            foreach ($data->transfer_receipt_detail as $detail ) {
                $transfer_detail = TransferDetail::find($detail->id_transfer_detail);
                $transfer_detail->rec_qty = $transfer_detail->rec_qty - $detail->qty;
                $transfer_detail->update();
            }
            TransferReceipt::destroy($id);
            return response()
                ->json(['code'=>200,'message' => 'Transfer Success Deleted', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error Transfer Access Denied', 'stat' => 'Error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_detail($id)
    {
        $transfer_receipt = TransferReceiptDetail::find($id);
        TransferReceiptDetail::destroy($id);
        $transfer_detail = TransferDetail::find($transfer_receipt->id_transfer_detail);
        $transfer_detail->rec_qty = $transfer_detail->rec_qty - $transfer_receipt->qty;
        $transfer_detail->update();
        return response()
            ->json(['code'=>200,'message' => 'Transfer Detail Success Deleted', 'stat' => 'Success']);
    }

    public function recordTransferReceipt(){
        $data = TransferReceipt::where([
            ['id_branch','=', Auth::user()->id_branch],
        ])->latest()->get();
        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status_transfer', function($data){
                $status = "";
                if($data->receipt_transfer_status == 1){
                    $status = "Draft";
                }elseif ($data->receipt_transfer_status == 2) {
                    $status = "Request";
                }elseif ($data->receipt_transfer_status == 3) {
                    $status = "Approved";
                }elseif ($data->receipt_transfer_status == 4) {
                    $status = "Closed";
                }else {
                    $status = "Reject";
                }
                return $status;
            })
            ->addColumn('branch_name', function($data){
                return $data->from->city;
            })
            ->addColumn('transfer_no', function($data){
                $action = $data->transfer->transfer_no;
                return $action;
            })
            ->addColumn('action', function($data) use($access){
                $transfer_detail = "javascript:ajaxLoad('".route('local.transfer_receipt.detail.index', $data->id)."')";
                $transfer_approve = "javascript:ajaxLoad('".route('local.transfer.approve', $data->id)."')";
                $action = "";
                $title = "'".$data->transfer_no."'";
                if($data->receipt_transfer_status == 1){
                    if($access->can('transfer.receipt.view')){
                        $action .= '<a href="'.$transfer_detail.'" class="btn btn-warning btn-xs"> Draft</a> ';
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .','.$title.')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('transfer.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                }
                elseif($data->receipt_transfer_status == 2){
                    if($access->can('transfer.receipt.view')){
                        $action .= '<a href="'.$transfer_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('transfer.receipt.approve')){
                        $action .= '<button id="'. $data->id .'" onclick="approve('. $data->id .')" class="btn btn-info btn-xs"> Approve</button> ';
                    }
                    if($access->can('transfer.receipt.print')){
                        $action .= '<button id="'. $data->id .'" onclick="print_transfer('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    }
                }
                else{
                    if($access->can('transfer.receipt.view')){
                        $action .= '<a href="'.$transfer_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('transfer.receipt.print')){
                        $action .= '<button id="'. $data->id .'" onclick="print_transfer('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    }
                }

                return $action;
            })
            ->rawColumns(['action'])->make(true);
    }

    public function recordTransfer_detail($id){


        $data = TransferReceiptDetail::where([
            ['id_branch','=', Auth::user()->id_branch],
            ['id_receipt_transfer','=', $id],
        ])->latest()->get();

        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data) use($access){
                $action = "";
                $title = "'".$data->stock_master->name."'";

                if($data->transfer_receipt->receipt_transfer_status == 1){
                    if($access->can('transfer.receipt.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('transfer.receipt.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                }
                if($data->transfer_receipt->receipt_transfer_status == 2){
                    if($access->can('transfer.receipt.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('transfer.receipt.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                }
                return $action;
            })
            ->addColumn('nama_stock', function($data){
                $action = $data->stock_master->name;
                return $action;
            })
            ->addColumn('format_harga', function($data){
                return "Rp. ".number_format($data->price,0, ",", ".");
            })
            ->addColumn('format_total', function($data){
                return "Rp. ".number_format($data->total,0, ",", ".");
            })
            ->addColumn('satuan', function($data){
                $action = $data->stock_master->satuan;
                return $action;
            })
            ->rawColumns(['action'])->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function transfer_receipt_open($id)
    {
        if(Auth::user()->can('transfer.receipt.open')){
            $data = TransferReceipt::findOrFail($id);
            if($data->transfer_receipt_detail->count() < 1)
            {
                return response()->json(['code'=>200,'message' => 'Error, Transfer Receipt item empty...', 'stat' => 'Error']);
            }
            $data->receipt_transfer_status = 2;
            $data->receipt_transfer_open = Carbon::now();
            $data->receipt_transfer_print = Carbon::now();
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Request Transfer Receipt Success', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Transfer Receipt Access Denied', 'stat' => 'Error']);
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        if(Auth::user()->can('transfer.receipt.approve')){
            $data = TransferReceipt::findOrFail($id);
            $data->receipt_transfer_status = 3;
            $data->transfer->transfer_status = 4;
            $data->transfer->update();
            $movement = $this->stock_movement($data->transfer_receipt_detail);
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Transfer Receipt Approve Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error Approve Access Denied', 'stat' => 'Error']);
    }

    public function stock_movement($data)
    {
        foreach ($data as $detail ) {
            $data = [
                'id_stock_master' => $detail->id_stock_master,
                'id_branch' => $detail->id_branch,
                'move_date' => $detail->transfer_receipt->created_at,
                'type' => 'TR',
                'doc_no' => $detail->transfer_receipt->receipt_transfer_no,
                'order_qty' => 0,
                'sell_qty' => 0,
                'in_qty' => $detail->qty,
                'out_qty' => 0,
                'harga_modal' =>0,
                'harga_jual' => 0,
                'user' => Auth::user()->name,
                'ket' => 'Transfer Receipt Approved at ('.Carbon::now().')',
            ];

            $movement = StockMovement::create($data);
            // $stock_master = StockMaster::find($detail->id_stock_master);
            // $stock_master->harga_modal = $detail->price;
            // $stock_master->update();
        }
    }
}
