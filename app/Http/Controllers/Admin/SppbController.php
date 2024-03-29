<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Spbd;

use App\Models\Sppb;
use App\Models\Invoice;
use App\Models\PoInternal;
use App\Models\SpbdDetail;
use App\Models\SppbDetail;
use App\Models\StockMaster;
use Illuminate\Http\Request;
use App\Models\StockMovement;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\StoreSppbRequest;
use App\Http\Requests\Admin\UpdateSppbRequest;
use App\Http\Requests\Admin\StoreDetailSppbRequest;
use App\Http\Requests\Admin\UpdateDetailSppbRequest;
use App\Http\Controllers\Admin\SettingAjaxController;

class SppbController extends SettingAjaxController
{
    public function index()
    {
        if(Auth::user()->can('sppb.view')){
            $data = [];
            return view('admin.content.sppb')->with($data);
        }
        return view('admin.components.403');
    }

    public function detail($id)
    {
        if(Auth::user()->can('sppb.view')){
            $sppb = Sppb::findOrFail($id);
            $data = [
                'sppb' => $sppb
            ];
            return view('admin.content.sppb_detail')->with($data);
        }
        return view('admin.components.403');
    }

    public function sppb_no(){
        $tanggal = Carbon::now();
        $format = 'SPPB/'.Auth::user()->branch->name.'/'.$tanggal->format('y').'/'.$tanggal->format('m');
        $sppb_no = Sppb::where([
            ['sppb_no','like', $format.'%'],
            ['id_branch','=', Auth::user()->id_branch]
        ])->count() + 1;
        return $format.'/'.sprintf("%03d", $sppb_no);
    }

    public function store(StoreSppbRequest $request)
    {
        if(Auth::user()->can('sppb.store')){
            $draf = Sppb::where([
                ['sppb_status','=', 1],
                ['id_branch','=', Auth::user()->id_branch]
            ])->count();

            if($draf > 0){
                return response()
                    ->json(['code'=>200,'message' => 'Use the previous Draf SPPB First', 'stat' => 'Warning']);
            }

            $status_po_internal = 0;
            if($request->has('status_po_internal')){
                $status_po_internal = 1;
            }

            $data = [
                'id_branch' => Auth::user()->id_branch,
                'sppb_no' => $this->sppb_no(),
                'sppb_date' => Carbon::now(),
                'id_customer' => $request['customer'],
                'sppb_po_cust' => $request['sppb_po_cust'],
                'sppb_status' => 1,
                'po_cust_status' => $status_po_internal,
                'sppb_user_name' => Auth::user()->name,
                'sppb_user_id' => Auth::user()->id,
            ];

            $activity = Sppb::create($data);

            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new SPPB Success' , 'stat' => 'Success', 'sppb_id' => $activity->id, 'process' => 'add']);

            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error SPPB Store', 'stat' => 'Error']);
            }
        }
        return response()->json(['code'=>200,'message' => 'Error SPPB Access Denied', 'stat' => 'Error']);
    }

    public function store_detail(StoreDetailSppbRequest $request, $id)
    {
        if(Auth::user()->can('sppb.store')){
            $data = [
                'id_branch' => Auth::user()->id_branch,
                'sppb_id' => $id,
                'id_stock_master' => $request['stock_master'],
                'qty' => $request['qty'],
                // 'price' => intval(preg_replace('/,.*|[^0-9]/', '',$request['price'])),
                'keterangan' => $request['keterangan'],
                'sppb_detail_status' => 1,
            ];

            $activity = SppbDetail::create($data);

            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new item SPPB Success', 'stat' => 'Success', 'process' => 'update']);

            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error item SPPB Store', 'stat' => 'Error']);
            }
        }
        return response()->json(['code'=>200,'message' => 'Error SPPB Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('sppb.update')){
            $data = Sppb::with('customer')->findOrFail($id);
            return $data;
        }
        return response()->json(['code'=>200,'message' => 'Error SPPB Access Denied', 'stat' => 'Error']);
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_detail($id)
    {
        if(Auth::user()->can('sppb.update') || Auth::user()->can('invoice.store')){
            $data = SppbDetail::with('stock_master')->findOrFail($id);
            return $data;
        }
        return response()->json(['code'=>200,'message' => 'Error SPPB Access Denied', 'stat' => 'Error']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSppbRequest $request, $id)
    {
        if(Auth::user()->can('sppb.update')){
            $status_po_internal = 0;
            if($request->has('status_po_internal')){
                $status_po_internal = 1;
            }
            $data = Sppb::find($id);
            $data->sppb_date    = Carbon::now();
            $data->id_customer    = $request['customer'];
            $data->sppb_po_cust    = $request['sppb_po_cust'];
            $data->po_cust_status    = $status_po_internal;
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Edit SPPB Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error SPPB Access Denied', 'stat' => 'Error']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_detail(UpdateDetailSppbRequest $request, $id)
    {
        if(Auth::user()->can('sppb.update')){
            $data = SppbDetail::find($id);
            $data->id_stock_master    = $request['stock_master'];
            $data->qty    = $request['qty'];
            // $data->price    = preg_replace('/\D/', '',$request['price']);
            $data->keterangan    = $request['keterangan'];
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Edit Item SPPB Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error SPPB Access Denied', 'stat' => 'Error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('sppb.delete')){
            Sppb::destroy($id);
            return response()
                ->json(['code'=>200,'message' => 'SPPB Success Deleted', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error SPPB Access Denied', 'stat' => 'Error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_detail($id)
    {
        SppbDetail::destroy($id);
        return response()
            ->json(['code'=>200,'message' => 'SPPB Detail Success Deleted', 'stat' => 'Success']);
    }

    public function recordSppb(){
        $data = Sppb::where([
            ['id_branch','=', Auth::user()->id_branch],
        ])->latest()->get();
        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function($data){
                $sppb_status = "";
                if($data->sppb_status == 1){
                    $sppb_status = "Draft";
                }elseif ($data->sppb_status == 2) {
                    $sppb_status = "Request";
                }elseif ($data->sppb_status == 3) {
                    $sppb_status = "Verified 1";
                }elseif ($data->sppb_status == 4) {
                    $sppb_status = "Verified 2";
                }elseif ($data->sppb_status == 5) {
                    $sppb_status = "Approved";
                }elseif ($data->sppb_status == 6) {
                    $sppb_status = "Closed";
                }else {
                    $sppb_status = "Batal";
                }
                return $sppb_status;
            })
            ->addColumn('action', function($data) use($access){
                $sppb_detail = "javascript:ajaxLoad('".route('local.sppb.detail.index', $data->id)."')";
                $action = "";
                $title = "'".$data->sppb_no."'";
                if($data->sppb_status == 1){
                    if($access->can('sppb.view')){
                        $action .= '<a href="'.$sppb_detail.'" class="btn btn-warning btn-xs"> Draf</a> ';
                    }
                    if($access->can('sppb.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('sppb.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                }
                elseif($data->sppb_status == 2){
                    if($access->can('sppb.view')){
                        $action .= '<a href="'.$sppb_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('sppb.verify1')){
                        $action .= '<button id="'. $data->id .'" onclick="verify1('. $data->id .')" class="btn btn-info btn-xs"> Verify 1</button> ';
                    }
                    // fungsi untuk hilangkan print sebelum approval
                    // if($access->can('sppb.print')){
                    //     $action .= '<button id="'. $data->id .'" onclick="print_sppb('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    // } 
                    
                }
                elseif($data->sppb_status == 3){
                    if($access->can('sppb.view')){
                        $action .= '<a href="'.$sppb_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('sppb.verify2')){
                        $action .= '<button id="'. $data->id .'" onclick="verify2('. $data->id .')" class="btn btn-info btn-xs"> Verify 2</button> ';
                    }
                    // fungsi untuk hilangkan print sebelum approval
                    // if($access->can('sppb.print')){
                    //     $action .= '<button id="'. $data->id .'" onclick="print_sppb('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    // } 
                    
                }
                elseif($data->sppb_status == 4){
                    if($access->can('sppb.view')){
                        $action .= '<a href="'.$sppb_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('sppb.approve')){
                        $action .= '<button id="approve'. $data->id .'" onclick="approve('. $data->id .')" class="btn btn-info btn-xs"> Approve</button> ';
                    }
                    // fungsi untuk hilangkan print sebelum approval
                    // if($access->can('sppb.print')){
                    //     $action .= '<button id="'. $data->id .'" onclick="print_sppb('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    // } 
                    
                }
                elseif($data->sppb_status == 5){
                    if($access->can('sppb.view')){
                        $action .= '<a href="'.$sppb_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('sppb.print')){
                        $action .= '<button id="'. $data->id .'" onclick="print_sppb('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    }
                }else {
                    if($access->can('sppb.view')){
                        $action .= '<a href="'.$sppb_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('sppb.print')){
                        $action .= '<button id="'. $data->id .'" onclick="print_sppb('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    }
                }

                return $action;
            })
            ->rawColumns(['action'])->make(true);
    }

    public function recordSppb_detail($id, $inv_stat = NULL){
        if($inv_stat == 1){
            $data = SppbDetail::where([
                ['id_branch','=', Auth::user()->id_branch],
                ['sppb_id','=', $id],
            ])->whereRaw('sppb_details.qty <> sppb_details.inv_qty')->latest()->get();
        }else{
            $data = SppbDetail::where([
                ['id_branch','=', Auth::user()->id_branch],
                ['sppb_id','=', $id],
            ])->latest()->get();
        }
        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data)  use($inv_stat, $access){
                $action = "";
                $title = "'".$data->stock_master->name."'";
                if($data->sppb->sppb_status == 1){
                    if($access->can('sppb.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('sppb.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                }
                if($data->sppb->sppb_status == 2){
                    if($access->can('sppb.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('sppb.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
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
            ->addColumn('format_price', function($data){
                $action = $data->stock_master->name;
                return "Rp. ".number_format($data->stock_master->harga_jual,0, ",", ".");
            })
            ->addColumn('satuan', function($data){
                $action = $data->stock_master->satuan;
                return $action;
            })
            ->rawColumns(['action'])->make(true);
    }

    /**
     * Search a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchSppb(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return response()->json([]);
        }

        $tags = Sppb::where([
            ['sppb_no','like','%'.$term.'%'],
            ['id_branch','=', Auth::user()->id_branch],
            ['sppb_status','=', 5],
        ])->get();

        $formatted_tags = [];

        foreach ($tags as $tag) {
            $formatted_tags[] = [
                'id'    => $tag->id,
                'text'  => $tag->sppb_no,
                'customer'  => $tag->id_customer,
                'customer_name'  => $tag->customer->name,
                'customer_address' => $tag->customer->address1.' , '.$tag->customer->address2,
                'customer_po'  => $tag->sppb_po_cust,
            ];
        }

        return response()->json($formatted_tags);
    }


     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sppb_open($id)
    {
        if(Auth::user()->can('sppb.open')){
            $data = Sppb::findOrFail($id);
            if($data->sppb_detail->count() < 1)
            {
                return response()->json(['code'=>200,'message' => 'Error, SPPB item empty...', 'stat' => 'Error']);
            }
            $data->sppb_status = 2;
            $data->sppb_open = Carbon::now();
            if($data->po_cust_status == 1){
                $po_internal = PoInternal::where('po_no',$data->sppb_po_cust)
                    ->update([
                        'po_status' => 4,
                        'doc_no' => $data->sppb_no,
                        ]);
            }
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Open SPPB Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error SPPB Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verify1($id)
    {
        if(Auth::user()->can('sppb.verify1')){
            $data = Sppb::findOrFail($id);
            $data->sppb_status = 3;
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'SPPB Verify1 Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error SPPB Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verify2($id)
    {
        if(Auth::user()->can('sppb.verify2')){
            $data = Sppb::findOrFail($id);
            $data->sppb_status = 4;
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'SPPB Verify2 Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error SPPB Access Denied', 'stat' => 'Error']);
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        if(Auth::user()->can('sppb.approve')){
            $data = Sppb::findOrFail($id);
            $data->sppb_status = 5;
            $this->sppb_movement($data->sppb_detail);
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'SPPB Approve Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error SPPB Access Denied', 'stat' => 'Error']);
    }

    public function sppb_movement($data)
    {
        foreach ($data as $detail ) {
            $data = [
                'id_stock_master' => $detail->id_stock_master,
                'id_branch' => $detail->id_branch,
                'move_date' => $detail->sppb->sppb_date,
                // 'bin' => "-",
                'type' => 'SPPB',
                'doc_no' => $detail->sppb->sppb_no,
                'order_qty' => 0,
                'sell_qty' => 0,
                'in_qty' => 0,
                'out_qty' => $detail->qty,
                'harga_modal' => 0,
                'harga_jual' => $detail->price,
                'user' => Auth::user()->name,
                'ket' => 'SPPB Approved at ('.Carbon::now().')',
            ];

            $movement = StockMovement::create($data);
            $stock_master = StockMaster::find($detail->id_stock_master);
            // $stock_master->harga_jual = $detail->price;
            $stock_master->update();
        }
    }

    public function pembatalan($id)
    {
        if(Auth::user()->can('sppb.pembatalan')){
            $data = Sppb::findOrFail($id);
            // status verify 1 & 2
            if($data->sppb_status == 3 ||  $data->sppb_status == 4 )
            {
                $data->sppb_status = 2;
                $data->update();
                return response()
                    ->json(['code'=>200,'message' => 'SPPB Reject Success', 'stat' => 'Success']);
            }
            if($this->pembatalan_check($data))
            {
                $data->sppb_status = 7;
                $data->update();
                $this->pembatalan_movement($data->sppb_no);
                return response()
                    ->json(['code'=>200,'message' => 'SPPB Reject Success', 'stat' => 'Success']);
            }
            return response()
                    ->json(['code'=>200,'message' => 'Invoice Sudah ada / SPPB tidak bisa di revisi', 'stat' => 'Error']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error SPPB Access Denied', 'stat' => 'Error']);
    }

    public function pembatalan_check($data)
    {
        $invoice = Invoice::where('id_sppb','=', $data->id )->count();
        if($data->sppb_status == 5 && $invoice < 1 )
        {
            return true;
        }
        return false;
    }

    public function pembatalan_movement($data)
    {
        $stock_movement_sppb = StockMovement::where([
            ['doc_no','=', $data ],
            ['id_branch','=', Auth::user()->id_branch],
        ])->update(['status' => 1, 'ket' => "Pembatalan SPPB"]);
    }
}
