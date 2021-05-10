<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\StockMovement;
use App\Models\TransferBranch;
use App\Models\TransferDetail;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\SettingAjaxController;
use App\Http\Requests\Admin\StoreTransferDetailRequest;

class TransferBranchController extends SettingAjaxController
{
    public function index()
    {
        if(Auth::user()->can('transfer.view')){
            $branch = Branch::whereNotIn('id', [Auth::user()->id_branch])->get();
            $data = [
                'branches' => $branch,
            ];
            return view('admin.content.transfer_branch')->with($data);
        }
        return view('admin.components.403');
    }

    public function detail($id)
    {
        if(Auth::user()->can('transfer.view')){
            $transfer = TransferBranch::findOrFail($id);
            $data = [
                'transfer' => $transfer
            ];
            return view('admin.content.transfer_branch_detail')->with($data);
        }
        return view('admin.components.403');
    }

    public function transfer_no(){
        $tanggal = Carbon::now();
        $format = 'TB/'.Auth::user()->branch->name.'/'.$tanggal->format('y').'/'.$tanggal->format('m');
        $transfer = TransferBranch::where([
            ['transfer_no','like', $format.'%'],
            ['id_branch','=', Auth::user()->id_branch]
        ])->count() + 1;
        return $format.'/'.sprintf("%03d", $transfer);
    }

    public function store(Request $request)
    {
        if(Auth::user()->can('transfer.store')){
            $draf = TransferBranch::where([
                ['transfer_status','=', 1],
                ['id_branch','=', Auth::user()->id_branch]
            ])->count();

            if($draf > 0){
                return response()
                    ->json(['code'=>200,'message' => 'Use the previous Draf Transfer First', 'stat' => 'Warning']);
            }
            $data = [
                'id_branch' => Auth::user()->id_branch,
                'transfer_no' => $this->transfer_no(),
                'to_branch' => $request['branch'],
                'transfer_date' => Carbon::now(),
                'transfer_status' => 1,
                'user_id' => Auth::user()->id,
                'user_name' => Auth::user()->name,
            ];

            $activity = TransferBranch::create($data);

            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new Transfer Success' , 'stat' => 'Success', 'id' => $activity->id, 'process' => 'add']);

            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error Transfer Store', 'stat' => 'Error']);
            }
        }
        return response()->json(['code'=>200,'message' => 'Error Transfer Access Denied', 'stat' => 'Error']);
    }

    public function store_detail(StoreTransferDetailRequest $request, $id)
    {
        if(Auth::user()->can('transfer.store')){
            $data = [
                'id_branch' => Auth::user()->id_branch,
                'id_transfer' => $id,
                'id_stock_master' => $request['stock_master'],
                'qty' => $request['qty'],
                // 'price' => preg_replace('/\D/', '',$request['price']),
                'keterangan' => $request['keterangan'],
                'transfer_detail_status' => 1,
            ];

            $activity = TransferDetail::create($data);

            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new item Transfer Success', 'stat' => 'Success', 'process' => 'update']);

            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error item Transfer Store', 'stat' => 'Error']);
            }
        }
        return response()->json(['code'=>200,'message' => 'Error Transfer Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_detail($id)
    {
        if(Auth::user()->can('transfer.update')){
            $data = TransferDetail::with('stock_master')->findOrFail($id);
            return $data;
        }
        return response()->json(['code'=>200,'message' => 'Error Transfer Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('transfer.update')){
            $data = TransferBranch::with('tujuan')->findOrFail($id);
            return $data;
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Transfer Access Denied', 'stat' => 'Error']);
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
        if(Auth::user()->can('transfer.update')){
            $data = TransferBranch::find($id);
            $data->to_branch    = $request['branch'];
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Edit Transfer Branch Success', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Transfer Branch Access Denied', 'stat' => 'Error']);
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
        if(Auth::user()->can('transfer.update')){
            $data = TransferDetail::find($id);
            $data->id_stock_master    = $request['stock_master'];
            // $data->qty    = $request['qty'];
            // $data->price    = preg_replace('/\D/', '',$request['price']);
            $data->keterangan    = $request['keterangan'];
            $data->update();
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
        if(Auth::user()->can('transfer.delete')){
            TransferBranch::destroy($id);
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
        TransferDetail::destroy($id);
        return response()
            ->json(['code'=>200,'message' => 'Transfer Detail Success Deleted', 'stat' => 'Success']);
    }

    public function recordTransfer(){
        $data = TransferBranch::where([
            ['id_branch','=', Auth::user()->id_branch],
        ])->latest()->get();
        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status_transfer', function($data){
                $status = "";
                if($data->transfer_status == 1){
                    $status = "Draft";
                }elseif ($data->transfer_status == 2) {
                    $status = "Request";
                }elseif ($data->transfer_status == 3) {
                    $status = "Approved";
                }elseif ($data->transfer_status == 4) {
                    $status = "Closed";
                }else {
                    $status = "Reject";
                }
                return $status;
            })
            ->addColumn('branch_name', function($data){
                return $data->tujuan->city;
            })
            ->addColumn('action', function($data) use($access){
                $transfer_detail = "javascript:ajaxLoad('".route('local.transfer.detail.index', $data->id)."')";
                $transfer_approve = "javascript:ajaxLoad('".route('local.transfer.approve', $data->id)."')";
                $action = "";
                $title = "'".$data->transfer_no."'";
                if($data->transfer_status == 1){
                    if($access->can('transfer.view')){
                        $action .= '<a href="'.$transfer_detail.'" class="btn btn-warning btn-xs"> Draft</a> ';
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .','.$title.')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('transfer.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                }
                elseif($data->transfer_status == 2){
                    if($access->can('transfer.view')){
                        $action .= '<a href="'.$transfer_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('transfer.approve')){
                        $action .= '<button id="'. $data->id .'" onclick="approve('. $data->id .')" class="btn btn-info btn-xs"> Approve</button> ';
                    }
                    if($access->can('transfer.print')){
                        $action .= '<button id="'. $data->id .'" onclick="print_transfer('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    }
                }
                else{
                    if($access->can('transfer.view')){
                        $action .= '<a href="'.$transfer_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('transfer.print')){
                        $action .= '<button id="'. $data->id .'" onclick="print_transfer('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    }
                }

                return $action;
            })
            ->rawColumns(['action'])->make(true);
    }

    public function recordTransfer_detail($id, $rec_stat = NULL){

        if($rec_stat == 1){
            $data = TransferDetail::where([
                ['id_transfer','=', $id],
            ])->whereRaw('transfer_details.qty <> transfer_details.rec_qty')->latest()->get();

        }else {
            $data = TransferDetail::where([
                ['id_branch','=', Auth::user()->id_branch],
                ['id_transfer','=', $id],
            ])->latest()->get();
        }
        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data) use($rec_stat, $access){
                $action = "";
                $title = "'".$data->stock_master->name."'";

                if($rec_stat == 1){
                    $action .= '<button id="'. $data->id .'" onclick="addItem('. $data->id .')" class="btn btn-info btn-xs"> Add Item</button> ';
                }
                if($data->transfer->transfer_status == 1){
                    if($access->can('transfer.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('transfer.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                }
                if($data->transfer->transfer_status == 2){
                    if($access->can('transfer.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('transfer.delete')){
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
            ->addColumn('sisa', function($data){
                $action = $data->qty - $data->rec_qty;
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
    public function transfer_open($id)
    {
        if(Auth::user()->can('transfer.open')){
            $data = TransferBranch::findOrFail($id);
            if($data->transfer_detail->count() < 1)
            {
                return response()->json(['code'=>200,'message' => 'Error, Transfer item empty...', 'stat' => 'Error']);
            }
            $data->transfer_status = 2;
            $data->transfer_date = Carbon::now();
            $data->transfer_open = Carbon::now();
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Request Transfer Success', 'stat' => 'Success']);
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
    public function approve($id)
    {
        if(Auth::user()->can('transfer.approve')){
            $data = TransferBranch::findOrFail($id);
            $data->transfer_status = 3;
            $movement = $this->transfer_movement($data->transfer_detail);
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Transfer Approve Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error Approve Access Denied', 'stat' => 'Error']);
    }

    public function transfer_movement($data)
    {
        foreach ($data as $detail ) {
            $data = [
                'id_stock_master' => $detail->id_stock_master,
                'id_branch' => $detail->id_branch,
                'move_date' => $detail->transfer->created_at,
                'type' => 'TB',
                'doc_no' => $detail->transfer->transfer_no,
                'order_qty' => 0,
                'sell_qty' => 0,
                'in_qty' => 0,
                'out_qty' => $detail->qty,
                'harga_modal' => 0,
                'harga_jual' => 0,
                'user' => Auth::user()->name,
                'ket' => 'Transfer Approved at ('.Carbon::now().')',
            ];

            $movement = StockMovement::create($data);
            // $stock_master = StockMaster::find($detail->id_stock_master);
            // $stock_master->harga_modal = $detail->price;
            // $stock_master->update();
        }
    }

    /**
     * Search a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchTransfer(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return response()->json([]);
        }

        $tags = TransferBranch::where([
            ['transfer_no','like','%'.$term.'%'],
            ['to_branch','=', Auth::user()->id_branch],
            ['transfer_status','=', 3],
        ])->get();

        $formatted_tags = [];

        foreach ($tags as $tag) {
            $formatted_tags[] = [
                'id'    => $tag->id,
                'text'  => $tag->transfer_no,
                'branch_id'  => $tag->id_branch,
                'branch_name'  => $tag->branch->city,
            ];
        }

        return response()->json($formatted_tags);
    }
}
